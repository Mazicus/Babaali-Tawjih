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
$_SERVER['PHP_SELF'] = $path;
chdir($root);
try {
    require $root . '/pages/' . $pages[$path];
} catch (Throwable $error) {
    error_log('Application error: ' . $error->getMessage());
    http_response_code(503);
    echo 'Service temporairement indisponible. Veuillez réessayer plus tard.';
}
