<?php
declare(strict_types=1);

function signInUser(array $user, bool $remember = false): void
{
    session_regenerate_id(true);
    $_SESSION = [
        'user_id' => $user['id'],
        'user_name' => $user['full_name'],
        'user_email' => $user['adress_email'],
        'remember_me' => $remember,
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
