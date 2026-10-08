<?php
require_once __DIR__ . '/../config/session.php';

$options = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires' => time() - 3600, 'path' => $options['path'],
    'secure' => $options['secure'], 'httponly' => true, 'samesite' => 'Lax',
]);
session_unset();
session_destroy();

header("Location: /index.html");
exit();