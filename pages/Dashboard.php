<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/personal.php';
require_once __DIR__ . '/../config/google.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
$userId = (int) $_SESSION['user_id'];
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (!validPersonalCsrf($_POST['csrf'] ?? null)) {
        $_SESSION['dashboard_error'] = 'Votre session a expiré. Veuillez réessayer.';
    } else {
        $id = filter_var($_POST['school_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false || ($_POST['action'] ?? '') !== 'remove') {
            $_SESSION['dashboard_error'] = 'Demande invalide.';
        } else {
            try {
                setSchoolFavorite($pdo, $userId, $id, false);
                $_SESSION['dashboard_success'] = 'L’école a été retirée de vos favoris.';
            } catch (Throwable $error) {
                error_log('Dashboard favorite removal: ' . $error->getMessage());
                $_SESSION['dashboard_error'] = 'Impossible de retirer ce favori pour le moment.';
            }
        }
    }
    header('Location: /Dashboard.php#favorites', true, 303);
    exit;
}
$query = $pdo->prepare('SELECT full_name, adress_email, phonenumber FROM users WHERE id = ?');
$query->execute([$userId]);
$user = $query->fetch();
if (!$user) {
    session_unset();
    header('Location: /login.php');
    exit;
}
$_SESSION['user_name'] = $user['full_name'];
$_SESSION['user_email'] = $user['adress_email'];
$catalog = schoolCatalog();
$favorites = [];
foreach (savedSchoolIds($pdo, $userId) as $id) {
    if (isset($catalog[$id])) { $favorites[] = $catalog[$id]; }
}
$sectors = json_decode(file_get_contents(__DIR__ . '/../data/sectors.json'), true, 512, JSON_THROW_ON_ERROR);
$query = $pdo->prepare('SELECT updated_at FROM user_avatars WHERE user_id = ?');
$query->execute([$userId]);
$avatarVersion = $query->fetchColumn();
$csrf = personalCsrfToken();
$parts = preg_split('/\s+/u', trim($user['full_name']), -1, PREG_SPLIT_NO_EMPTY);
$initials = mb_strtoupper(mb_substr($parts[0] ?? '', 0, 1) . (count($parts) > 1 ? mb_substr($parts[count($parts) - 1], 0, 1) : ''));
$profileInput = $_SESSION['profile_input'] ?? ['name' => $user['full_name'], 'phone' => $user['phonenumber']];
$errors = array_filter([$_SESSION['oauth_error'] ?? '', $_SESSION['profile_error'] ?? '', $_SESSION['dashboard_error'] ?? '']);
$successes = array_filter([$_SESSION['profile_success'] ?? '', $_SESSION['dashboard_success'] ?? '']);
unset($_SESSION['oauth_error'], $_SESSION['profile_error'], $_SESSION['dashboard_error'], $_SESSION['profile_success'], $_SESSION['dashboard_success'], $_SESSION['profile_input']);
function dashboardEscape(mixed $value): string { return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'); }
$cities = count(array_unique(array_column($favorites, 'location')));
$googleConfigured = false;
try { googleConfiguration(); $googleConfigured = true; } catch (RuntimeException $error) { /* Hide unconfigured optional account linking. */ }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon espace · BABAALI TAWJIH</title>
<link rel="icon" href="/img/BABA_ALI_TAWJIH2.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="/palette.css">
<link rel="stylesheet" href="/Dashboard.css">
<script src="/DarkMode.js" defer></script>
<script src="/Dashboard.js" defer></script>
</head>
<body>
<a class="skip-link" href="#main-content">Aller au contenu</a>
<header class="workspace-header">
    <a class="workspace-brand" href="/index.html" aria-label="Babaali Tawjih, accueil"><img class="brand-light" src="/img/BABA_ALI_TAWJIH.png" alt=""><img class="brand-dark" src="/img/white_icon_s.png" alt=""><span>BABAALI<strong>TAWJIH</strong></span></a>
    <span class="workspace-breadcrumb">Mon espace personnel</span>
    <div class="workspace-header-actions">
        <button id="theme-switch" type="button" aria-label="Changer le thème"><svg viewBox="0 -960 960 960" aria-hidden="true"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q8 0 17 .5t23 1.5q-36 32-56 79t-20 99q0 90 63 153t153 63q52 0 99-18.5t79-51.5q1 12 1.5 19.5t.5 14.5q0 150-105 255T480-120Z"/></svg><svg viewBox="0 -960 960 960" aria-hidden="true"><path d="M338.5-338.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-450H40v-60h160v60Zm720 0H760v-60h160v60ZM450-760v-160h60v160h-60Zm0 720v-160h60v160h-60ZM262-658l-100-97 43-44 96 100-39 41Zm494 496-98-100 41-41 99 98-42 43Zm-99-537 98-99 44 42-99 98-43-41ZM162-205l99-98 42 42-98 99-43-43Z"/></svg></button>
        <a class="header-avatar avatar" href="#profile" aria-label="Mon profil"><?php if ($avatarVersion): ?><img src="/avatar.php?v=<?php echo urlencode($avatarVersion); ?>" alt=""><?php else: ?><span><?php echo dashboardEscape($initials); ?></span><?php endif; ?></a>
    </div>
</header>
<div class="workspace-layout">
    <aside class="workspace-sidebar">
        <p class="sidebar-label">MON ORIENTATION</p>
        <nav aria-label="Navigation personnelle"><a class="sidebar-active" href="#favorites"><i class="far fa-heart" aria-hidden="true"></i> Mes écoles <span><?php echo count($favorites); ?></span></a><a href="#profile"><i class="far fa-user" aria-hidden="true"></i> Mon profil</a><a href="/index.html#ecoles"><i class="fas fa-search" aria-hidden="true"></i> Explorer les écoles</a></nav>
        <div class="sidebar-help"><span class="help-icon"><i class="far fa-comments" aria-hidden="true"></i></span><h2>Un choix à clarifier ?</h2><p>Notre équipe vous aide à trouver votre direction.</p><a href="/index.html#contact">Contacter un conseiller <i class="fas fa-arrow-right" aria-hidden="true"></i></a></div>
        <a class="sidebar-logout" href="/logout.php"><i class="fas fa-arrow-right-from-bracket" aria-hidden="true"></i> Se déconnecter</a>
        <p class="sidebar-signature" lang="ar" dir="rtl">نوجهوك للطريق الصحيح</p>
    </aside>
    <main id="main-content" class="workspace-main">
        <div class="workspace-heading"><div><p class="eyebrow">VOTRE PROJET, À VOTRE RYTHME</p><h1>Bonjour, <?php echo dashboardEscape($user['full_name']); ?>.</h1><p>Gardez vos écoles préférées à portée de main.</p></div><a class="primary-button" href="/index.html#ecoles"><i class="fas fa-plus" aria-hidden="true"></i> Découvrir une école</a></div>
        <?php foreach ($errors as $message): ?><p class="workspace-message error" role="alert"><?php echo dashboardEscape($message); ?></p><?php endforeach; ?>
        <?php foreach ($successes as $message): ?><p class="workspace-message" role="status"><?php echo dashboardEscape($message); ?></p><?php endforeach; ?>
        <div class="workspace-stats"><div><span class="stat-icon"><i class="far fa-heart" aria-hidden="true"></i></span><p><strong><?php echo count($favorites); ?></strong><span>écoles enregistrées</span></p></div><div><span class="stat-icon gold"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span><p><strong><?php echo $cities; ?></strong><span>villes à explorer</span></p></div><a href="#profile"><span class="stat-icon"><i class="far fa-user" aria-hidden="true"></i></span><p><strong>Mon profil</strong><span>Gérer mes informations</span></p><i class="fas fa-arrow-right" aria-hidden="true"></i></a></div>
        <div class="workspace-columns">
            <section class="favorites-section" id="favorites" aria-labelledby="favorites-title">
                <div class="section-heading"><div><h2 id="favorites-title">Mes écoles favorites <span><?php echo count($favorites); ?></span></h2><p>Votre sélection personnelle, enregistrée sur votre compte.</p></div></div>
                <?php if (!$favorites): ?>
                    <div class="favorites-empty"><span><i class="far fa-heart" aria-hidden="true"></i></span><h3>Votre sélection commence ici.</h3><p>Dans le catalogue, cliquez sur « Enregistrer » pour retrouver une école dans cet espace.</p><a class="primary-button" href="/index.html#ecoles">Explorer le catalogue <i class="fas fa-arrow-right" aria-hidden="true"></i></a></div>
                <?php else: ?>
                    <label class="favorite-search"><i class="fas fa-search" aria-hidden="true"></i><span class="sr-only">Rechercher dans mes écoles favorites</span><input id="favorite-search" type="search" placeholder="Rechercher une école, une ville…" autocomplete="off"></label>
                    <p id="favorite-search-status" class="sr-only" role="status" aria-live="polite"></p>
                    <div class="saved-schools">
                    <?php foreach ($favorites as $school): ?>
                        <article class="saved-school" data-search="<?php echo dashboardEscape($school['name'] . ' ' . $school['location'] . ' ' . $school['diploma'] . ' ' . ($sectors[$school['sector']]['label'] ?? '')); ?>">
                            <div class="saved-school-top"><span class="school-monogram"><?php echo dashboardEscape($school['acronym'] ?? 'École'); ?></span><form method="post" action="/Dashboard.php"><input type="hidden" name="csrf" value="<?php echo dashboardEscape($csrf); ?>"><input type="hidden" name="school_id" value="<?php echo (int) $school['id']; ?>"><input type="hidden" name="action" value="remove"><button class="remove-favorite" type="submit" aria-label="Retirer <?php echo dashboardEscape($school['name']); ?> des favoris" title="Retirer des favoris"><i class="fas fa-heart" aria-hidden="true"></i></button></form></div>
                            <span class="school-sector"><?php echo dashboardEscape($sectors[$school['sector']]['label'] ?? $school['sector']); ?></span><h3><?php echo dashboardEscape($school['name']); ?></h3><p class="school-location"><i class="fas fa-map-marker-alt" aria-hidden="true"></i> <?php echo dashboardEscape($school['location']); ?><span><?php echo $school['type'] === 'public' ? 'Public' : 'Privé'; ?></span></p>
                            <dl class="school-details"><div><dt><i class="fas fa-graduation-cap" aria-hidden="true"></i> Diplôme</dt><dd><?php echo dashboardEscape($school['diploma']); ?></dd></div><div><dt><i class="far fa-clock" aria-hidden="true"></i> Durée</dt><dd><?php echo dashboardEscape($school['duration']); ?></dd></div></dl>
                            <a class="school-visit" href="<?php echo dashboardEscape($school['link']); ?>" target="_blank" rel="noopener noreferrer">Site de l’établissement <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i><span class="sr-only"> (nouvel onglet)</span></a>
                        </article>
                    <?php endforeach; ?>
                    </div><p id="favorite-no-results" class="search-empty" hidden>Aucune école enregistrée ne correspond à cette recherche.</p>
                <?php endif; ?>
            </section>
            <section class="profile-section" id="profile" aria-labelledby="profile-title">
                <div class="section-heading"><h2 id="profile-title">Mon profil</h2><i class="fas fa-user-shield" aria-hidden="true"></i></div>
                <form class="profile-form" method="post" action="/profile.php" enctype="multipart/form-data">
                    <input type="hidden" name="csrf" value="<?php echo dashboardEscape($csrf); ?>"><input type="hidden" name="MAX_FILE_SIZE" value="1048576">
                    <div class="profile-photo"><div class="avatar profile-avatar"><?php if ($avatarVersion): ?><img src="/avatar.php?v=<?php echo urlencode($avatarVersion); ?>" alt="Votre photo de profil"><?php else: ?><span><?php echo dashboardEscape($initials); ?></span><?php endif; ?></div><div><label class="photo-picker" for="avatar"><i class="fas fa-camera" aria-hidden="true"></i> Changer la photo</label><input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/webp" aria-describedby="photo-help photo-selection"><p id="photo-help">JPG, PNG, WebP · 1 Mo max.</p><p id="photo-selection" role="status"></p></div></div>
                    <?php if ($avatarVersion): ?><label class="remove-photo"><input type="checkbox" name="remove_avatar" value="1"> Supprimer ma photo</label><?php endif; ?>
                    <label for="full-name">Nom complet</label><input id="full-name" name="full_name" type="text" value="<?php echo dashboardEscape($profileInput['name']); ?>" minlength="2" maxlength="255" autocomplete="name" required>
                    <label for="email">Adresse email</label><input id="email" type="email" value="<?php echo dashboardEscape($user['adress_email']); ?>" readonly aria-describedby="email-help"><p class="field-help" id="email-help">Votre adresse de connexion.</p>
                    <label for="phone">Téléphone <span>(facultatif)</span></label><input id="phone" name="phone" type="tel" value="<?php echo dashboardEscape($profileInput['phone']); ?>" maxlength="15" autocomplete="tel" placeholder="Votre numéro de téléphone">
                    <button class="primary-button save-profile" type="submit">Enregistrer les modifications</button><p class="profile-save-note">Vos informations restent associées à votre compte.</p>
                </form>
                <?php if ($googleConfigured): ?><div class="profile-google"><i class="fab fa-google" aria-hidden="true"></i><div><h3>Connexion Google</h3><p>Associez Google pour vos prochaines visites.</p><a href="/google-oauth.php">Associer mon compte <i class="fas fa-arrow-right" aria-hidden="true"></i></a></div></div><?php endif; ?>
            </section>
        </div>
        <footer class="workspace-footer"><span>© <?php echo date('Y'); ?> BABAALI TAWJIH</span><a href="/index.html#contact">Besoin d’aide ?</a></footer>
    </main>
</div>
</body>
</html>
