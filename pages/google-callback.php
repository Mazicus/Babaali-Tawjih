<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/google.php';

$pending = $_SESSION['google_oauth'] ?? [];
unset($_SESSION['google_oauth']);
$return = ($pending['return'] ?? '') === '/inscription.php' ? '/inscription.php' : '/login.php';
if (isset($_SESSION['user_id'])) {
    $return = '/Dashboard.php';
}
$message = 'La connexion Google a échoué ou a expiré. Veuillez réessayer.';
try {
    validateGoogleState($pending, $_GET['state'] ?? null);
    if (isset($_GET['error']) || !is_string($_GET['code'] ?? null) || $_GET['code'] === '') {
        throw new RuntimeException('Google authorization cancelled or missing code.');
    }
    $config = googleConfiguration();
    $tokens = googleRequest('https://oauth2.googleapis.com/token', [
        'code' => $_GET['code'], 'client_id' => $config['client_id'],
        'client_secret' => $config['client_secret'], 'redirect_uri' => $config['redirect_uri'],
        'grant_type' => 'authorization_code', 'code_verifier' => $pending['verifier'],
    ]);
    if (!is_string($tokens['access_token'] ?? null) || preg_match('/[\r\n]/', $tokens['access_token'])) {
        throw new RuntimeException('Missing Google access token.');
    }
    // UserInfo is fetched directly from Google over verified TLS; never trust browser profile data.
    $identity = googleIdentity(googleRequest('https://openidconnect.googleapis.com/v1/userinfo', null, $tokens['access_token']));
    $pdo->beginTransaction();
    $query = $pdo->prepare('SELECT u.id, u.full_name, u.adress_email FROM google_accounts g JOIN users u ON u.id = g.user_id WHERE g.google_sub = ?');
    $query->execute([$identity['sub']]);
    $user = $query->fetch();
    if (!$user) {
        $query = $pdo->prepare('SELECT id, full_name, adress_email FROM users WHERE adress_email = ?');
        $query->execute([$identity['email']]);
        $user = $query->fetch();
        if ($user && (string) ($_SESSION['user_id'] ?? '') !== (string) $user['id']) {
            $message = 'Cet email possède déjà un compte. Connectez-vous avec votre mot de passe, puis associez Google depuis le tableau de bord.';
            throw new RuntimeException('Existing account requires authenticated linking.');
        }
        if (!$user) {
            if (isset($_SESSION['user_id'])) {
                throw new RuntimeException('Google email does not match the signed-in account.');
            }
            $query = $pdo->prepare('INSERT INTO users (full_name, adress_email, phonenumber, mot_de_passe) VALUES (?, ?, ?, ?)');
            $query->execute([$identity['name'] ?: $identity['email'], $identity['email'], '', password_hash(bin2hex(random_bytes(32)), PASSWORD_DEFAULT)]);
            $user = ['id' => $pdo->lastInsertId(), 'full_name' => $identity['name'] ?: $identity['email'], 'adress_email' => $identity['email']];
        }
        $query = $pdo->prepare('INSERT INTO google_accounts (google_sub, user_id) VALUES (?, ?)');
        $query->execute([$identity['sub'], $user['id']]);
    }
    if (isset($_SESSION['user_id']) && (string) $_SESSION['user_id'] !== (string) $user['id']) {
        throw new RuntimeException('Cannot switch accounts while linking Google.');
    }
    $pdo->commit();
    signInUser($user, !empty($pending['remember']));
    header('Location: /Dashboard.php');
} catch (Throwable $error) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Google sign-in failed: ' . $error->getMessage());
    $_SESSION['oauth_error'] = $message;
    header('Location: ' . $return);
}
exit;
