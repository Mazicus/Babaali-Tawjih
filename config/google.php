<?php
declare(strict_types=1);

function googleConfiguration(): array
{
    $config = [
        'client_id' => trim(getenv('GOOGLE_CLIENT_ID') ?: ''),
        'client_secret' => trim(getenv('GOOGLE_CLIENT_SECRET') ?: ''),
        'redirect_uri' => trim(getenv('GOOGLE_REDIRECT_URI') ?: ''),
    ];
    $uri = parse_url($config['redirect_uri']);
    $local = in_array($uri['host'] ?? '', ['localhost', '127.0.0.1'], true);
    if (in_array('', $config, true) || !$uri || isset($uri['user']) || isset($uri['fragment'])
        || (($uri['scheme'] ?? '') !== 'https' && !($local && ($uri['scheme'] ?? '') === 'http'))
        || ($uri['path'] ?? '') !== '/google-callback.php' || isset($uri['query'])) {
        throw new RuntimeException('Google OAuth configuration is missing or invalid.');
    }
    return $config;
}

function googleRequest(string $url, ?array $form = null, ?string $token = null): array
{
    if (!function_exists('curl_init')) {
        throw new RuntimeException('Google OAuth requires the PHP cURL extension.');
    }
    $handle = curl_init($url);
    $headers = ['Accept: application/json'];
    if ($token !== null) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    $options = [CURLOPT_RETURNTRANSFER => true, CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 20, CURLOPT_HTTPHEADER => $headers,
        CURLOPT_SSL_VERIFYPEER => true, CURLOPT_SSL_VERIFYHOST => 2];
    if ($form !== null) {
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS] = http_build_query($form, '', '&', PHP_QUERY_RFC3986);
    }
    curl_setopt_array($handle, $options);
    $body = curl_exec($handle);
    $status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);
    if ($body === false || $status !== 200) {
        throw new RuntimeException('Google OAuth request failed.');
    }
    $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    if (!is_array($data)) {
        throw new RuntimeException('Invalid Google response.');
    }
    return $data;
}

function validateGoogleState(array $pending, mixed $state): void
{
    if (!is_string($state) || !isset($pending['state'], $pending['created_at'])
        || !hash_equals($pending['state'], $state)
        || time() - $pending['created_at'] > 600) {
        throw new RuntimeException('Invalid or expired OAuth state.');
    }
}

function googleIdentity(array $profile): array
{
    if (!is_string($profile['sub'] ?? null) || $profile['sub'] === '' || strlen($profile['sub']) > 255
        || ($profile['email_verified'] ?? false) !== true
        || !is_string($profile['email'] ?? null) || strlen($profile['email']) > 254
        || !filter_var($profile['email'], FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('Google identity is not verified.');
    }
    return ['sub' => $profile['sub'], 'email' => strtolower($profile['email']),
        'name' => substr(trim((string) ($profile['name'] ?? $profile['email'])), 0, 255)];
}
