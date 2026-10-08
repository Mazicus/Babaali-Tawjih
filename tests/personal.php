<?php
declare(strict_types=1);
require __DIR__ . '/../config/personal.php';

function check(bool $condition, string $message): void
{
    if (!$condition) { throw new RuntimeException($message); }
}
function invalid(callable $action): void
{
    try { $action(); } catch (InvalidArgumentException $error) { return; }
    throw new RuntimeException('Expected invalid input rejection.');
}
// Use an ephemeral SQLite database to exercise persistence and account isolation.
// Translate MySQL upsert syntax only; production still uses MySQL and needs a deployed smoke test.
final class PersonalTestDatabase extends PDO
{
    public function prepare(string $query, array $options = []): PDOStatement|false
    {
        $query = str_replace('ON DUPLICATE KEY UPDATE school_id = VALUES(school_id)', 'ON CONFLICT(user_id, school_id) DO NOTHING', $query);
        $query = str_replace('ON DUPLICATE KEY UPDATE mime_type = VALUES(mime_type), image_data = VALUES(image_data), updated_at = CURRENT_TIMESTAMP', 'ON CONFLICT(user_id) DO UPDATE SET mime_type = excluded.mime_type, image_data = excluded.image_data, updated_at = CURRENT_TIMESTAMP', $query);
        return parent::prepare($query, $options);
    }
}
$pdo = new PersonalTestDatabase('sqlite::memory:');
// Exercise old deployments without touching a real database. Only a missing
// table may trigger DDL; repeated calls must not run it again.
final class MissingPersonalDatabase extends PDO
{
    public array $statements = [];
    public function __construct(private bool $missing = true) {}
    public function query(string $query, ?int $fetchMode = null, mixed ...$fetchModeArgs): PDOStatement|false
    {
        $this->statements[] = $query;
        $error = new PDOException('Storage unavailable');
        $error->errorInfo = $this->missing ? ['42S02', 1146] : ['08006', 2006];
        throw $error;
    }
    public function exec(string $statement): int|false
    {
        $this->statements[] = $statement;
        return 0;
    }
}
$legacy = new MissingPersonalDatabase();
ensurePersonalTable($legacy, 'user_favorites');
ensurePersonalTable($legacy, 'user_favorites');
ensurePersonalTable($legacy, 'user_avatars');
check(count($legacy->statements) === 4, 'Missing tables should each initialize once per connection.');
check(str_contains($legacy->statements[1], 'CREATE TABLE IF NOT EXISTS user_favorites'), 'Old deployments must initialize persistent favorites.');
check(str_contains($legacy->statements[3], 'CREATE TABLE IF NOT EXISTS user_avatars'), 'Old deployments must initialize profile photos.');
$offline = new MissingPersonalDatabase(false);
try {
    ensurePersonalTable($offline, 'user_favorites');
    throw new RuntimeException('Connection errors must propagate.');
} catch (PDOException $error) {
    check(count($offline->statements) === 1, 'Connection errors must not trigger schema changes.');
}
$missingTable = new PDOException('Table missing');
$missingTable->errorInfo = ['42S02', 1146];
check(personalTableMissing($missingTable), 'Missing MySQL tables should be classified for graceful fallback.');
$connectionError = new PDOException('Connection failed');
$connectionError->errorInfo = ['08006', 2006];
check(!personalTableMissing($connectionError), 'Connection failures must not be mistaken for missing optional tables.');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON');
$pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, full_name TEXT, phonenumber TEXT)');
$pdo->exec("INSERT INTO users VALUES (1, 'Person One', '1111111'), (2, 'Person Two', '2222222')");
$pdo->exec('CREATE TABLE user_favorites (user_id INTEGER REFERENCES users(id), school_id INTEGER, saved_at TEXT DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (user_id, school_id))');
$pdo->exec('CREATE TABLE user_avatars (user_id INTEGER PRIMARY KEY REFERENCES users(id), mime_type TEXT, image_data BLOB, updated_at TEXT DEFAULT CURRENT_TIMESTAMP)');
$schools = array_keys(schoolCatalog());
check(count($schools) === count(array_unique($schools)), 'School IDs must be unique.');
setSchoolFavorite($pdo, 1, $schools[0], true);
setSchoolFavorite($pdo, 1, $schools[0], true);
setSchoolFavorite($pdo, 2, $schools[0], true);
setSchoolFavorite($pdo, 1, $schools[1], true);
check(count(savedSchoolIds($pdo, 1)) === 2, 'Duplicate save must be idempotent.');
check(savedSchoolIds($pdo, 2) === [$schools[0]], 'Favorites must be isolated per account.');
setSchoolFavorite($pdo, 1, $schools[0], false);
check(savedSchoolIds($pdo, 1) === [$schools[1]], 'Remove should affect only the requesting user.');
check(savedSchoolIds($pdo, 2) === [$schools[0]], 'Another user favorite must remain.');
invalid(fn() => setSchoolFavorite($pdo, 1, 999999, true));

$_SESSION = [];
$token = personalCsrfToken();
check(strlen($token) === 64 && validPersonalCsrf($token), 'Valid CSRF token should be accepted.');
check(!validPersonalCsrf('wrong') && !validPersonalCsrf([$token]), 'Forged and malformed CSRF tokens must fail.');
check(validatePersonalDetails('  Sara Benali  ', '+212600123456')['name'] === 'Sara Benali', 'Names should be trimmed.');
invalid(fn() => validatePersonalDetails('A', ''));
invalid(fn() => validatePersonalDetails(str_repeat('a', 256), ''));
invalid(fn() => validatePersonalDetails('Sara', '<script>'));
invalid(fn() => validatePersonalDetails(['Sara'], ''));

$png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aX1sAAAAASUVORK5CYII=');
check(validateAvatarBytes($png) === 'image/png', 'Valid raster photo should be accepted.');
invalid(fn() => validateAvatarBytes('<svg xmlns="http://www.w3.org/2000/svg"></svg>'));
invalid(fn() => validateAvatarBytes('<?php echo "bad";'));
invalid(fn() => validateAvatarBytes(str_repeat('x', 1048577)));
invalid(fn() => validateAvatarBytes(substr_replace($png, pack('N', 5000), 16, 4)));

$details = ['name' => 'Updated One', 'phone' => '3333333'];
savePersonalProfile($pdo, 1, $details, $png, 'image/png', false);
check($pdo->query('SELECT full_name FROM users WHERE id = 1')->fetchColumn() === 'Updated One', 'Profile should persist.');
check($pdo->query('SELECT full_name FROM users WHERE id = 2')->fetchColumn() === 'Person Two', 'Other profile must stay unchanged.');
check($pdo->query('SELECT COUNT(*) FROM user_avatars WHERE user_id = 2')->fetchColumn() == 0, 'Avatar must stay with its owner.');
savePersonalProfile($pdo, 1, $details, $png, 'image/png', false);
check($pdo->query('SELECT COUNT(*) FROM user_avatars WHERE user_id = 1')->fetchColumn() == 1, 'Replacing a photo must not create duplicates.');
savePersonalProfile($pdo, 1, $details, null, null, true);
check($pdo->query('SELECT COUNT(*) FROM user_avatars')->fetchColumn() == 0, 'Photo removal should persist.');
$pdo->exec('DROP TABLE user_avatars');
try {
    savePersonalProfile($pdo, 1, ['name' => 'Should Roll Back', 'phone' => '4444444'], $png, 'image/png', false);
    throw new RuntimeException('Expected database failure.');
} catch (PDOException $error) {
    check($pdo->query('SELECT full_name FROM users WHERE id = 1')->fetchColumn() === 'Updated One', 'Failed photo save must roll back profile updates.');
}
echo "Favorites persistence/isolation, CSRF, profile validation, photo validation, replacement/removal and rollback checks passed.\n";
