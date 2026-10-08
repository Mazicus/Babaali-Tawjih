<?php
declare(strict_types=1);

function personalTableMissing(PDOException $error): bool
{
    return $error->getCode() === '42S02' || ($error->errorInfo[1] ?? null) === 1146;
}

function schoolCatalog(): array
{
    static $catalog;
    if ($catalog === null) {
        $schools = json_decode(file_get_contents(__DIR__ . '/../data/schools.json'), true, 512, JSON_THROW_ON_ERROR);
        $catalog = [];
        foreach ($schools as $school) {
            $catalog[(int) $school['id']] = $school;
        }
    }
    return $catalog;
}

function personalCsrfToken(): string
{
    if (!isset($_SESSION['personal_csrf'])) {
        $_SESSION['personal_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['personal_csrf'];
}

function validPersonalCsrf(mixed $value): bool
{
    return is_string($value) && isset($_SESSION['personal_csrf']) && hash_equals($_SESSION['personal_csrf'], $value);
}

function savedSchoolIds(PDO $pdo, int $userId): array
{
    $query = $pdo->prepare('SELECT school_id FROM user_favorites WHERE user_id = ? ORDER BY saved_at DESC, school_id');
    $query->execute([$userId]);
    return array_map('intval', $query->fetchAll(PDO::FETCH_COLUMN));
}

function setSchoolFavorite(PDO $pdo, int $userId, int $schoolId, bool $save): void
{
    if ($save && !isset(schoolCatalog()[$schoolId])) {
        throw new InvalidArgumentException('Cet établissement ne figure pas dans le catalogue.');
    }
    $sql = $save
        ? 'INSERT INTO user_favorites (user_id, school_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE school_id = VALUES(school_id)'
        : 'DELETE FROM user_favorites WHERE user_id = ? AND school_id = ?';
    $pdo->prepare($sql)->execute([$userId, $schoolId]);
}

function validatePersonalDetails(mixed $name, mixed $phone): array
{
    if (!is_string($name) || !is_string($phone)) {
        throw new InvalidArgumentException('Informations de profil invalides.');
    }
    $name = trim($name);
    $phone = trim($phone);
    if (mb_strlen($name) < 2 || mb_strlen($name) > 255 || preg_match('/[\x00-\x1f]/u', $name)) {
        throw new InvalidArgumentException('Le nom doit contenir entre 2 et 255 caractères.');
    }
    if ($phone !== '' && !preg_match('/^[\d\s+()\-]{7,15}$/', $phone)) {
        throw new InvalidArgumentException('Veuillez saisir un numéro de téléphone valide.');
    }
    return ['name' => $name, 'phone' => $phone];
}

function validateAvatarBytes(string $bytes): string
{
    if ($bytes === '' || strlen($bytes) > 1048576) {
        throw new InvalidArgumentException('La photo doit peser moins de 1 Mo.');
    }
    $image = @getimagesizefromstring($bytes);
    $mime = (new finfo(FILEINFO_MIME_TYPE))->buffer($bytes);
    if (!$image || !in_array($mime, ['image/jpeg', 'image/png', 'image/webp'], true)
        || ($image['mime'] ?? '') !== $mime || $image[0] > 4096 || $image[1] > 4096
        || $image[0] * $image[1] > 12000000) {
        throw new InvalidArgumentException('Choisissez une photo JPG, PNG ou WebP, de 4096 pixels maximum par côté.');
    }
    return $mime;
}

function savePersonalProfile(PDO $pdo, int $userId, array $details, ?string $bytes, ?string $mime, bool $removeAvatar): void
{
    $pdo->beginTransaction();
    try {
        $pdo->prepare('UPDATE users SET full_name = ?, phonenumber = ? WHERE id = ?')
            ->execute([$details['name'], $details['phone'], $userId]);
        if ($bytes !== null) {
            $query = $pdo->prepare('INSERT INTO user_avatars (user_id, mime_type, image_data) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE mime_type = VALUES(mime_type), image_data = VALUES(image_data), updated_at = CURRENT_TIMESTAMP');
            $query->bindValue(1, $userId, PDO::PARAM_INT);
            $query->bindValue(2, $mime);
            $query->bindValue(3, $bytes, PDO::PARAM_LOB);
            $query->execute();
        } elseif ($removeAvatar) {
            $pdo->prepare('DELETE FROM user_avatars WHERE user_id = ?')->execute([$userId]);
        }
        $pdo->commit();
    } catch (Throwable $error) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        throw $error;
    }
}
