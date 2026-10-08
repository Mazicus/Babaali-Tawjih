<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/google.php';

$return = ($_GET['from'] ?? '') === 'inscription' ? '/inscription.php' : '/login.php';
if (isset($_SESSION['user_id'])) {
    $return = '/Dashboard.php';
}
try {
    $config = googleConfiguration();
    $state = bin2hex(random_bytes(32));
    $verifier = bin2hex(random_bytes(32));
    $_SESSION['google_oauth'] = ['state' => $state, 'verifier' => $verifier,
        'created_at' => time(), 'return' => $return,
        'remember' => ($_GET['remember'] ?? '') === '1'];
    $query = http_build_query([
        'client_id' => $config['client_id'], 'redirect_uri' => $config['redirect_uri'],
        'response_type' => 'code', 'scope' => 'openid email profile',
        'state' => $state, 'code_challenge' => rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '='),
        'code_challenge_method' => 'S256', 'prompt' => 'select_account',
    ], '', '&', PHP_QUERY_RFC3986);
    session_write_close();
    header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . $query);
} catch (Throwable $error) {
    error_log($error->getMessage());
    $_SESSION['oauth_error'] = 'La connexion Google n’est pas encore configurée. Veuillez utiliser votre email et votre mot de passe.';
    header('Location: ' . $return);
}
exit;
