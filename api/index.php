<?php
declare(strict_types=1);
ini_set('display_errors', '0');
ini_set('log_errors', '1');

$root = dirname(__DIR__);
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$pages = [
    '/login.php' => 'login.php',
    '/inscription.php' => 'inscription.php',
    '/Dashboard.php' => 'Dashboard.php',
    '/dashboard.php' => 'Dashboard.php',
    '/logout.php' => 'logout.php',
    '/contact.php' => 'contact.php',
    '/favorites.php' => 'favorites.php',
    '/profile.php' => 'profile.php',
    '/avatar.php' => 'avatar.php',
    '/google-oauth.php' => 'google-oauth.php',
    '/google-callback.php' => 'google-callback.php',
];
if ($path === '/index.php') {
    header('Location: /index.html', true, 302);
    exit;
}
if (!isset($pages[$path])) {
    http_response_code(404);
    exit('Page introuvable.');
}
header('Cache-Control: private, no-store');
header('Referrer-Policy: no-referrer');
$_SERVER['PHP_SELF'] = $path;
chdir($root);
try {
    require $root . '/pages/' . $pages[$path];
} catch (Throwable $error) {
    error_log('Application error: ' . $error->getMessage());
    http_response_code(503);
    if ($path === '/favorites.php') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['error' => 'Les favoris sont momentanément indisponibles. Veuillez réessayer.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    echo 'Service temporairement indisponible. Veuillez réessayer plus tard.';
}
