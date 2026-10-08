<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=utf-8');
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    exit;
}
$authenticated = isset($_SESSION['user_id']);
if ($authenticated) {
    $query = $pdo->prepare('SELECT id FROM users WHERE id = ?');
    $query->execute([(int) $_SESSION['user_id']]);
    $authenticated = $query->fetchColumn() !== false;
}
echo json_encode(['authenticated' => $authenticated]);
