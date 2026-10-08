<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/personal.php';
require_once __DIR__ . '/../config/recovery.php';
$resetMode = true;
$error = $success = '';
$tokenValid = false;
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    unset($_SESSION['reset_hash']);
    if (is_string($token) && preg_match('/^[a-f0-9]{64}$/D', $token)) {
        $_SESSION['reset_hash'] = hash('sha256', $token);
    }
    header('Location: /reset-password.php', true, 303);
    exit;
}
try {
    $hash = $_SESSION['reset_hash'] ?? '';
    if ($hash !== '') {
        $query = $pdo->prepare('SELECT user_id FROM password_reset_tokens WHERE token_hash = ? AND expires_at > ?');
        $query->execute([$hash, time()]);
        $tokenValid = $query->fetchColumn() !== false;
    }
    if (!$tokenValid) { $error = 'Ce lien a expiré ou a déjà été utilisé. Demandez un nouveau lien.'; }
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        if (!validPersonalCsrf($_POST['csrf'] ?? null)) { throw new InvalidArgumentException('Rechargez la page et réessayez.'); }
        if (!$tokenValid) { throw new InvalidArgumentException($error); }
        $password = $_POST['password'] ?? null;
        $confirmation = $_POST['confirmation'] ?? null;
        if (!is_string($password) || $password !== $confirmation) { throw new InvalidArgumentException('Les mots de passe ne correspondent pas.'); }
        consumeRecoveryToken($pdo, $hash, $password);
        $_SESSION = [];
        session_regenerate_id(true);
        $tokenValid = false;
        $error = '';
        $success = 'Votre mot de passe a été modifié. Connectez-vous avec votre nouveau mot de passe.';
    }
} catch (InvalidArgumentException $exception) {
    $error = $exception->getMessage();
} catch (Throwable $exception) {
    error_log('Password reset unavailable: ' . $exception->getMessage());
    $tokenValid = false;
    $error = 'La réinitialisation est momentanément indisponible. Veuillez réessayer plus tard.';
}
require __DIR__ . '/recovery-view.php';
