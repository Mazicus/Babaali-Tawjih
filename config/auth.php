<?php
declare(strict_types=1);

function accountAuthVersion(PDO $pdo, int $userId): int
{
    try {
        $query = $pdo->prepare('SELECT version FROM account_auth_versions WHERE user_id = ?');
        $query->execute([$userId]);
        return (int) ($query->fetchColumn() ?: 0);
    } catch (PDOException $error) {
        if ($error->getCode() === '42S02') { return 0; }
        throw $error;
    }
}

function signInUser(array $user, bool $remember = false): void
{
    global $pdo;
    session_regenerate_id(true);
    $_SESSION = [
        'user_id' => $user['id'],
        'user_name' => $user['full_name'],
        'user_email' => $user['adress_email'],
        'remember_me' => $remember,
        'auth_version' => accountAuthVersion($pdo, (int) $user['id']),
    ];
    $options = session_get_cookie_params();
    setcookie(session_name(), session_id(), [
        'expires' => $remember ? time() + 2592000 : 0,
        'path' => $options['path'],
        'secure' => $options['secure'],
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}
