<?php
declare(strict_types=1);
require __DIR__ . '/../config/personal.php';
function dashboardEscape(mixed $value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
$source = file_get_contents(__DIR__ . '/../pages/Dashboard.php');
$template = substr($source, strpos($source, '?>') + 2);

function renderDashboardFixture(string $template, bool $populated, bool $available = true): string
{
    $user = ['full_name' => 'Sara Benali', 'adress_email' => 'sara@example.com', 'phonenumber' => '+212600123456'];
    $favorites = $populated ? array_slice(array_values(schoolCatalog()), 0, 4) : [];
    $sectors = json_decode(file_get_contents(__DIR__ . '/../data/sectors.json'), true);
    $csrf = 'fixture-token';
    $initials = 'SB';
    $profileInput = ['name' => $user['full_name'], 'phone' => $user['phonenumber']];
    $errors = $successes = [];
    $avatarVersion = false;
    $favoritesAvailable = $photosAvailable = $available;
    $cities = count(array_unique(array_column($favorites, 'location')));
    $googleConfigured = false;
    ob_start();
    eval('?>' . $template);
    return ob_get_clean();
}
foreach ([false, true] as $populated) {
    $output = renderDashboardFixture($template, $populated);
    $document = new DOMDocument();
    @$document->loadHTML('<?xml encoding="UTF-8">' . $output);
    $xpath = new DOMXPath($document);
    $seed = json_decode($xpath->query('//script[@id="saved-school-data"]')->item(0)->textContent, true);
    if (count($seed) !== ($populated ? 4 : 0)) { throw new RuntimeException('Favorite seed count mismatch.'); }
    if ($xpath->query('//input[@name="csrf"]')->length !== 1) { throw new RuntimeException('Missing CSRF form fields.'); }
    if ($xpath->query('//input[@id="email" and @readonly]')->length !== 1) { throw new RuntimeException('Login email must be read-only.'); }
    if ($xpath->query('//input[@type="file" and @name="avatar"]')->length !== 1) { throw new RuntimeException('Photo upload missing.'); }
    file_put_contents(__DIR__ . '/preview-' . ($populated ? 'saved' : 'empty') . '.html', $output);
}
echo "Empty/populated dashboard markup and forms verified; synthetic previews generated under tests/.\n";
$unavailable = renderDashboardFixture($template, false, false);
if (!str_contains($unavailable, 'Vos favoris sont momentanément indisponibles.') || str_contains($unavailable, 'id="saved-school-data"')) {
    throw new RuntimeException('Missing migration must show unavailable favorites, not a false empty list.');
}
if (str_contains($unavailable, 'type="file"') || !str_contains($unavailable, 'Enregistrer les modifications')) {
    throw new RuntimeException('Missing photo table must disable only photo uploads while preserving profile edits.');
}
echo "Missing optional tables preserve dashboard/profile access with honest unavailable states.\n";
