<?php
declare(strict_types=1);

function recoveryMailConfiguration(): array
{
    $key = trim(getenv('RESEND_API_KEY') ?: '');
    $from = trim(getenv('RECOVERY_EMAIL_FROM') ?: '');
    $origin = rtrim(trim(getenv('SITE_URL') ?: ''), '/');
    $uri = parse_url($origin);
    if ($key === '' || preg_match('/[\r\n]/', $key) || !filter_var($from, FILTER_VALIDATE_EMAIL)
        || !$uri || ($uri['scheme'] ?? '') !== 'https' || empty($uri['host'])
        || isset($uri['user']) || isset($uri['query']) || isset($uri['fragment']) || !empty($uri['path'])) {
        throw new RuntimeException('Password recovery mail configuration is missing or invalid.');
    }
    return ['key' => $key, 'from' => $from, 'origin' => $origin];
}

function sendRecoveryEmail(array $config, string $email, string $token): void
{
    $link = $config['origin'] . '/reset-password.php?token=' . rawurlencode($token);
    $handle = curl_init('https://api.resend.com/emails');
    curl_setopt_array($handle, [
        CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 20, CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $config['key'], 'Content-Type: application/json', 'User-Agent: BabaaliTawjih/1.0'],
        CURLOPT_POSTFIELDS => json_encode([
            'from' => 'BABAALI TAWJIH <' . $config['from'] . '>', 'to' => [$email],
            'subject' => 'Réinitialiser votre mot de passe — BABAALI TAWJIH',
            'text' => "Vous avez demandé à réinitialiser votre mot de passe. Ce lien est valable 30 minutes :\n$link\nSi vous n’êtes pas à l’origine de cette demande, ignorez cet email.",
        ], JSON_THROW_ON_ERROR),
    ]);
    $body = curl_exec($handle);
    $status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);
    if ($body === false || $status < 200 || $status >= 300) {
        throw new RuntimeException('Password recovery email delivery failed.');
    }
}

function claimRecoveryRequest(PDO $pdo, string $key): bool
{
    $now = time();
    $pdo->prepare('DELETE FROM password_reset_requests WHERE requested_at < ?')->execute([$now - 86400]);
    $query = $pdo->prepare('UPDATE password_reset_requests SET requested_at = ? WHERE request_key = ? AND requested_at <= ?');
    $query->execute([$now, $key, $now - 60]);
    if ($query->rowCount() === 1) { return true; }
    try {
        $pdo->prepare('INSERT INTO password_reset_requests (request_key, requested_at) VALUES (?, ?)')->execute([$key, $now]);
        return true;
    } catch (PDOException $error) {
        if ($error->getCode() === '23000') { return false; }
        throw $error;
    }
}

function recoveryClientIp(): string
{
    // Vercel overwrites this header at its edge. Other hosts use the socket address.
    $value = getenv('VERCEL') ? ($_SERVER['HTTP_X_FORWARDED_FOR'] ?? '') : ($_SERVER['REMOTE_ADDR'] ?? '');
    $ip = trim(explode(',', $value)[0]);
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
}

function storeRecoveryToken(PDO $pdo, int $userId, string $token): void
{
    $pdo->beginTransaction();
    try {
        $pdo->prepare('DELETE FROM password_reset_tokens WHERE user_id = ? OR expires_at <= ?')->execute([$userId, time()]);
        $pdo->prepare('INSERT INTO password_reset_tokens (token_hash, user_id, expires_at) VALUES (?, ?, ?)')
            ->execute([hash('sha256', $token), $userId, time() + 1800]);
        $pdo->commit();
    } catch (Throwable $error) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        throw $error;
    }
}

function consumeRecoveryToken(PDO $pdo, string $hash, string $password): void
{
    if (strlen($password) < 8 || strlen($password) > 72 || str_contains($password, "\0")) {
        throw new InvalidArgumentException('Choisissez un mot de passe de 8 à 72 caractères.');
    }
    $pdo->beginTransaction();
    try {
        $query = $pdo->prepare('SELECT user_id FROM password_reset_tokens WHERE token_hash = ? AND expires_at > ? FOR UPDATE');
        $query->execute([$hash, time()]);
        $userId = $query->fetchColumn();
        if ($userId === false) { throw new InvalidArgumentException('Ce lien a expiré ou a déjà été utilisé. Demandez un nouveau lien.'); }
        $pdo->prepare('UPDATE users SET mot_de_passe = ? WHERE id = ?')->execute([password_hash($password, PASSWORD_DEFAULT), $userId]);
        $pdo->prepare('INSERT INTO account_auth_versions (user_id, version) VALUES (?, 1) ON DUPLICATE KEY UPDATE version = version + 1')->execute([$userId]);
        $pdo->prepare('DELETE FROM password_reset_tokens WHERE user_id = ?')->execute([$userId]);
        $pdo->commit();
    } catch (Throwable $error) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        throw $error;
    }
}
