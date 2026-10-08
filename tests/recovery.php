<?php
declare(strict_types=1);
require __DIR__ . '/../config/recovery.php';
require __DIR__ . '/../config/auth.php';
function verify(bool $condition, string $message): void { if (!$condition) { throw new RuntimeException($message); } }
function denied(callable $action): void {
    try { $action(); } catch (InvalidArgumentException $error) { return; }
    throw new RuntimeException('Expected invalid recovery token/password rejection.');
}
final class RecoveryTestDatabase extends PDO {
    public function prepare(string $query, array $options = []): PDOStatement|false {
        $query = str_replace(' FOR UPDATE', '', $query);
        $query = str_replace('ON DUPLICATE KEY UPDATE version = version + 1', 'ON CONFLICT(user_id) DO UPDATE SET version = version + 1', $query);
        return parent::prepare($query, $options);
    }
}
$pdo = new RecoveryTestDatabase('sqlite::memory:');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, mot_de_passe TEXT)');
$pdo->exec("INSERT INTO users VALUES (1, 'old-one'), (2, 'old-two')");
$pdo->exec('CREATE TABLE password_reset_tokens (token_hash TEXT PRIMARY KEY, user_id INTEGER, expires_at INTEGER)');
$pdo->exec('CREATE TABLE password_reset_requests (request_key TEXT PRIMARY KEY, requested_at INTEGER)');
$pdo->exec('CREATE TABLE account_auth_versions (user_id INTEGER PRIMARY KEY, version INTEGER)');
$token = bin2hex(random_bytes(32));
storeRecoveryToken($pdo, 1, $token);
verify($pdo->query('SELECT token_hash FROM password_reset_tokens')->fetchColumn() !== $token, 'Raw token must never be stored.');
verify(claimRecoveryRequest($pdo, 'email-key'), 'First request should be accepted.');
verify(!claimRecoveryRequest($pdo, 'email-key'), 'Rapid repeated requests must be throttled.');
denied(fn() => consumeRecoveryToken($pdo, hash('sha256', 'wrong'), 'new-password'));
denied(fn() => consumeRecoveryToken($pdo, hash('sha256', $token), 'short'));
consumeRecoveryToken($pdo, hash('sha256', $token), 'new-password');
verify(password_verify('new-password', $pdo->query('SELECT mot_de_passe FROM users WHERE id = 1')->fetchColumn()), 'Password should be changed for token owner.');
verify($pdo->query('SELECT mot_de_passe FROM users WHERE id = 2')->fetchColumn() === 'old-two', 'Other account must remain unchanged.');
verify(accountAuthVersion($pdo, 1) === 1 && accountAuthVersion($pdo, 2) === 0, 'Only reset account sessions should be invalidated.');
denied(fn() => consumeRecoveryToken($pdo, hash('sha256', $token), 'another-password'));
storeRecoveryToken($pdo, 1, $token);
$pdo->exec('UPDATE password_reset_tokens SET expires_at = 0');
denied(fn() => consumeRecoveryToken($pdo, hash('sha256', $token), 'another-password'));
putenv('RESEND_API_KEY=test'); putenv('RECOVERY_EMAIL_FROM=no-reply@example.com'); putenv('SITE_URL=https://example.com');
verify(recoveryMailConfiguration()['origin'] === 'https://example.com', 'Configured site origin must be used for reset links.');
putenv('SITE_URL=https://evil.example/?redirect=anything');
try { recoveryMailConfiguration(); throw new LogicException('Invalid origin should fail.'); } catch (RuntimeException $error) {}
echo "Recovery token hashing, expiry, replay protection, throttling, account isolation and session invalidation checks passed.\n";
