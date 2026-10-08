<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/personal.php';

function favoriteResponse(array $data, int $status = 200): void
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if (!in_array($method, ['GET', 'POST'], true)) {
    header('Allow: GET, POST');
    favoriteResponse(['error' => 'Méthode non autorisée.'], 405);
}
if (!isset($_SESSION['user_id'])) {
    favoriteResponse(['authenticated' => false, 'ids' => []], $method === 'POST' ? 401 : 200);
}
try {
    $userId = (int) $_SESSION['user_id'];
    if ($method === 'POST') {
        if (!validPersonalCsrf($_POST['csrf'] ?? null)) {
            favoriteResponse(['error' => 'Votre session a expiré. Rechargez la page.'], 419);
        }
        $id = filter_var($_POST['school_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $action = $_POST['action'] ?? '';
        if ($id === false || !in_array($action, ['save', 'remove'], true)) {
            favoriteResponse(['error' => 'Demande invalide.'], 422);
        }
        setSchoolFavorite($pdo, $userId, $id, $action === 'save');
    }
    favoriteResponse(['authenticated' => true, 'ids' => savedSchoolIds($pdo, $userId), 'csrf' => personalCsrfToken()]);
} catch (InvalidArgumentException $error) {
    favoriteResponse(['error' => $error->getMessage()], 422);
} catch (Throwable $error) {
    error_log('Favorites: ' . $error->getMessage());
    favoriteResponse(['error' => 'Vos favoris sont momentanément indisponibles. Veuillez réessayer.'], 503);
}
