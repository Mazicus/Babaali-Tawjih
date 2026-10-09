<?php
$options = [PDO::ATTR_TIMEOUT => 10];
if (extension_loaded('pdo_mysql')) {
    $ca = env('MYSQL_ATTR_SSL_CA');
    if (!$ca && env('DB_SSL_CA')) {
        $ca = sys_get_temp_dir().'/babaali-ca-'.hash('sha256', env('DB_SSL_CA')).'.pem';
        if (!is_file($ca)) { file_put_contents($ca, env('DB_SSL_CA')); }
    }
    $ca ??= str_contains((string) env('DB_HOST'), 'tidbcloud.com') && is_file(__DIR__.'/tidb-ca.crt') ? __DIR__.'/tidb-ca.crt' : null;
    if ($ca) {
        $options[defined('Pdo\\Mysql::ATTR_SSL_CA') ? constant('Pdo\\Mysql::ATTR_SSL_CA') : PDO::MYSQL_ATTR_SSL_CA] = $ca;
        $options[defined('Pdo\\Mysql::ATTR_SSL_VERIFY_SERVER_CERT') ? constant('Pdo\\Mysql::ATTR_SSL_VERIFY_SERVER_CERT') : PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
    }
}
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => ['driver'=>'mysql','url'=>env('DB_URL'),'host'=>env('DB_HOST','127.0.0.1'),'port'=>env('DB_PORT','3306'),
            'database'=>env('DB_DATABASE',env('DB_NAME','babaali')),'username'=>env('DB_USERNAME',env('DB_USER','root')),
            'password'=>env('DB_PASSWORD',''),'unix_socket'=>'','charset'=>'utf8mb4','collation'=>'utf8mb4_unicode_ci',
            'prefix'=>'','prefix_indexes'=>true,'strict'=>true,'engine'=>null,'options'=>$options],
        'sqlite' => ['driver'=>'sqlite','url'=>env('DB_URL'),'database'=>env('DB_DATABASE',database_path('database.sqlite')),
            'prefix'=>'','foreign_key_constraints'=>true,'busy_timeout'=>5000],
    ],
    'migrations' => ['table'=>'migrations','update_date_on_publish'=>true],
];
