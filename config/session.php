<?php
declare(strict_types=1);
require_once __DIR__ . '/database.php';

final class DatabaseSessions implements SessionHandlerInterface, SessionUpdateTimestampHandlerInterface
{
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }
    public function open(string $path, string $name): bool { return true; }
    public function close(): bool { return true; }
    public function read(string $id): string|false
    {
        $query = $this->pdo->prepare('SELECT data FROM site_sessions WHERE id = ? AND expires_at > ?');
        $query->execute([$id, time()]);
        $data = $query->fetchColumn();
        return $data === false ? '' : (string) $data;
    }
    public function write(string $id, string $data): bool
    {
        $query = $this->pdo->prepare('INSERT INTO site_sessions (id, data, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE data = VALUES(data), expires_at = VALUES(expires_at)');
        $lifetime = !empty($_SESSION['remember_me']) ? 2592000 : 86400;
        return $query->execute([$id, $data, time() + $lifetime]);
    }
    public function destroy(string $id): bool
    {
        $query = $this->pdo->prepare('DELETE FROM site_sessions WHERE id = ?');
        return $query->execute([$id]);
    }
    public function gc(int $maxLifetime): int|false
    {
        $query = $this->pdo->prepare('DELETE FROM site_sessions WHERE expires_at <= ?');
        $query->execute([time()]);
        return $query->rowCount();
    }
    public function validateId(string $id): bool
    {
        $query = $this->pdo->prepare('SELECT id FROM site_sessions WHERE id = ? AND expires_at > ?');
        $query->execute([$id, time()]);
        return $query->fetchColumn() !== false;
    }
    public function updateTimestamp(string $id, string $data): bool { return $this->write($id, $data); }
}

ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.gc_maxlifetime', '86400');
session_name('babaali_session');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => (bool) getenv('VERCEL') || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_set_save_handler(new DatabaseSessions($pdo), true);
session_start();
require_once __DIR__ . '/auth.php';
if (isset($_SESSION['user_id']) && (int) ($_SESSION['auth_version'] ?? 0) !== accountAuthVersion($pdo, (int) $_SESSION['user_id'])) {
    $_SESSION = [];
    session_regenerate_id(true);
}
