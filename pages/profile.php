<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/personal.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Allow: POST');
    http_response_code(405);
    exit;
}
if (!validPersonalCsrf($_POST['csrf'] ?? null)) {
    $_SESSION['profile_error'] = 'Votre session a expiré. Rechargez la page et réessayez.';
    header('Location: /Dashboard.php#profile', true, 303);
    exit;
}
try {
    $details = validatePersonalDetails($_POST['full_name'] ?? null, $_POST['phone'] ?? null);
    $userId = (int) $_SESSION['user_id'];
    $avatar = $_FILES['avatar'] ?? null;
    $bytes = null;
    $mime = null;
    if (is_array($avatar) && ($avatar['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        if (($avatar['error'] ?? null) !== UPLOAD_ERR_OK || !is_string($avatar['tmp_name'] ?? null)
            || !is_uploaded_file($avatar['tmp_name']) || ($avatar['size'] ?? 0) > 1048576) {
            throw new InvalidArgumentException('La photo n’a pas pu être envoyée. Choisissez une image de moins de 1 Mo.');
        }
        $bytes = file_get_contents($avatar['tmp_name']);
        if ($bytes === false) {
            throw new InvalidArgumentException('Impossible de lire la photo.');
        }
        $mime = validateAvatarBytes($bytes);
    }
    savePersonalProfile($pdo, $userId, $details, $bytes, $mime, isset($_POST['remove_avatar']));
    $_SESSION['user_name'] = $details['name'];
    $_SESSION['profile_success'] = 'Vos informations ont été enregistrées.';
} catch (InvalidArgumentException $error) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    $_SESSION['profile_error'] = $error->getMessage();
    // Preserve valid text entries so a photo error does not discard the user's edits.
    $_SESSION['profile_input'] = [
        'name' => is_string($_POST['full_name'] ?? null) ? mb_substr($_POST['full_name'], 0, 255) : '',
        'phone' => is_string($_POST['phone'] ?? null) ? substr($_POST['phone'], 0, 32) : '',
    ];
} catch (Throwable $error) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    error_log('Profile update: ' . $error->getMessage());
    $_SESSION['profile_error'] = 'Impossible d’enregistrer votre profil pour le moment. Veuillez réessayer.';
}
header('Location: /Dashboard.php#profile', true, 303);
exit;
