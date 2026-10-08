<?php
declare(strict_types=1);

function siteDatabase(): PDO
{
    static $connection;
    if ($connection instanceof PDO) {
        return $connection;
    }
    $host = getenv('DB_HOST');
    $name = getenv('DB_NAME');
    $user = getenv('DB_USER');
    if (!$host || !$name || !$user) {
        throw new RuntimeException('Set DB_HOST, DB_NAME, DB_USER and DB_PASSWORD in Vercel.');
    }
    $port = getenv('DB_PORT') ?: '3306';
    if (!ctype_digit($port) || preg_match('/[;\r\n]/', $host . $name)) {
        throw new RuntimeException('Invalid database configuration.');
    }
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_TIMEOUT => 10,
    ];
    $certificate = getenv('DB_SSL_CA');
    if ($certificate) {
        $caPath = sys_get_temp_dir() . '/babaali-mysql-ca-' . hash('sha256', $certificate) . '.pem';
        if (!is_file($caPath)) {
            file_put_contents($caPath, $certificate);
        }
        $options[PDO::MYSQL_ATTR_SSL_CA] = $caPath;
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
    } elseif (is_file(__DIR__ . '/tidb-ca.crt')) {
        $options[PDO::MYSQL_ATTR_SSL_CA] = __DIR__ . '/tidb-ca.crt';
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
    }
    $connection = new PDO(
        "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4",
        $user,
        getenv('DB_PASSWORD') ?: '',
        $options
    );
    return $connection;
}

$pdo = siteDatabase();
