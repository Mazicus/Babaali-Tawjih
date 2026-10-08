<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/session.php';
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    exit;
}
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}
$query = $pdo->prepare('SELECT mime_type, image_data FROM user_avatars WHERE user_id = ?');
$query->execute([(int) $_SESSION['user_id']]);
$avatar = $query->fetch();
session_write_close();
if (!$avatar || !in_array($avatar['mime_type'], ['image/jpeg', 'image/png', 'image/webp'], true)) {
    http_response_code(404);
    exit;
}
header('Content-Type: ' . $avatar['mime_type']);
header('X-Content-Type-Options: nosniff');
header("Content-Security-Policy: default-src 'none'; sandbox");
echo $avatar['image_data'];
