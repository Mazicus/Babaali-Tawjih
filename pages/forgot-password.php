<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/personal.php';
require_once __DIR__ . '/../config/recovery.php';
$resetMode = false;
$tokenValid = false;
$error = $success = '';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    try {
        if (!validPersonalCsrf($_POST['csrf'] ?? null)) { throw new InvalidArgumentException('Rechargez la page et réessayez.'); }
        $email = $_POST['email'] ?? null;
        if (!is_string($email) || strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Veuillez saisir une adresse email valide.');
        }
        $email = strtolower(trim($email));
        $mail = recoveryMailConfiguration();
        if (!claimRecoveryRequest($pdo, hash('sha256', 'email:' . $email))
            || !claimRecoveryRequest($pdo, hash('sha256', 'ip:' . recoveryClientIp()))) {
            throw new InvalidArgumentException('Veuillez attendre une minute avant une nouvelle demande.');
        }
        $query = $pdo->prepare('SELECT id, adress_email FROM users WHERE adress_email = ?');
        $query->execute([$email]);
        $user = $query->fetch();
        if ($user) {
            $token = bin2hex(random_bytes(32));
            storeRecoveryToken($pdo, (int) $user['id'], $token);
            try { sendRecoveryEmail($mail, $user['adress_email'], $token); }
            catch (Throwable $deliveryError) {
                $pdo->prepare('DELETE FROM password_reset_tokens WHERE token_hash = ?')->execute([hash('sha256', $token)]);
                error_log('Password recovery email delivery failed.');
            }
        }
        // Identical response for known/unknown accounts and delivery failures.
        $success = 'Si cette adresse correspond à un compte, vous recevrez un lien valable 30 minutes. Vérifiez aussi vos courriers indésirables.';
    } catch (InvalidArgumentException $exception) {
        $error = $exception->getMessage();
    } catch (Throwable $exception) {
        error_log('Password recovery unavailable: ' . $exception->getMessage());
        $error = 'La récupération par email est momentanément indisponible. Veuillez réessayer plus tard.';
    }
}
require __DIR__ . '/recovery-view.php';
