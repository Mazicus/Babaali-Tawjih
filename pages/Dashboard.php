<?php
require_once __DIR__ . '/../config/session.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
$userName = htmlspecialchars((string) $_SESSION['user_name'], ENT_QUOTES, 'UTF-8');
$userEmail = htmlspecialchars((string) $_SESSION['user_email'], ENT_QUOTES, 'UTF-8');
$oauthError = isset($_SESSION['oauth_error']) ? htmlspecialchars((string) $_SESSION['oauth_error'], ENT_QUOTES, 'UTF-8') : '';
unset($_SESSION['oauth_error']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon espace · BABAALI TAWJIH</title>
<link rel="icon" href="/img/BABA_ALI_TAWJIH2.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="/style.css">
<link rel="stylesheet" href="/Dashboard.css">
<script src="/DarkMode.js" defer></script>
</head>
<body class="dashboard-page">
<a class="dash-skip" href="#main-content">Aller au contenu</a>
<header class="header">
            <div class="container">
                <div class="logo">
                    <img class="logo-img-dark" src="./img/white_icon_s.png" alt="BABAALI TAWJIH">
                    <img class="logo-img-light" src="./img/BABA_ALI_TAWJIH.png" alt="BABAALI TAWJIH">
                    <a href="/index.html">
                        <span class="logo-top">BABAALI</span>
                        <span class="logo-bottom">TAWJIH</span>
                    </a>
                </div>
                <input type="checkbox" id="menu" aria-label="Ouvrir le menu">
                <nav class="nav" id="nav">
                    <label for="menu" class="close-btn">
                        <i class="fas fa-times"></i>
                    </label>
                    <ul>
<li><a href="#overview" aria-current="page">Mon espace</a></li>
<li><a href="#explore">Mon orientation</a></li>
<li><a href="/index.html#services">Nos services</a></li>
<li><a href="/index.html#contact">Contact</a></li>
</ul>
                    <div class="mobile-login"><a href="#account" class="login">Mon compte</a><a href="/logout.php" class="btn-inscr">Déconnexion</a></div>
                </nav>
                <div class="login-box"><a href="#account" class="login">Mon compte</a><a href="/logout.php" class="btn-inscr">Déconnexion</a></div>
                <div class="mobile-icons">
                    <div class="theme-box">
                        <button id="theme-switch" aria-label="Toggle dark mode">
                            <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px">
                                <path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q8 0 17 .5t23 1.5q-36 32-56 79t-20 99q0 90 63 153t153 63q52 0 99-18.5t79-51.5q1 12 1.5 19.5t.5 14.5q0 150-105 255T480-120Z"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px">
                                <path d="M338.5-338.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-450H40v-60h160v60Zm720 0H760v-60h160v60ZM450-760v-160h60v160h-60Zm0 720v-160h60v160h-60ZM262-658l-100-97 43-44 96 100-39 41Zm494 496-98-100 41-41 99 98-42 43Zm-99-537 98-99 44 42-99 98-43-41ZM162-205l99-98 42 42-98 99-43-43Z"/>
                            </svg>
                        </button>
                    </div>
                    <label for="menu" class="menu-btn">
                        <i class="fas fa-bars"></i>
                    </label>
                </div>
            </div>
        </header>
<main id="main-content">
<section class="dash-hero" id="overview" aria-labelledby="welcome-title">
    <div class="dash-hero-copy">
        <p class="dash-eyebrow"><span></span> VOTRE ESPACE D’ORIENTATION</p>
        <h1 id="welcome-title">Votre avenir,<br><span>votre prochain pas.</span></h1>
        <p class="dash-greeting">Bienvenue, <strong><?php echo $userName; ?></strong>.</p>
        <p class="dash-intro">Une école à découvrir, un parcours à construire, une question à poser. Retrouvez ici les ressources pour avancer avec confiance.</p>
        <div class="btns"><a class="btn btn-primary" href="/index.html#ecoles">Explorer les écoles <i class="fas fa-arrow-right" aria-hidden="true"></i></a><a class="btn btn-secondary" href="/index.html#contact">Parler à un conseiller</a></div>
        <p class="dash-signature" lang="ar" dir="rtl">نوجهوك للطريق الصحيح</p>
    </div>
    <aside class="dash-start" aria-labelledby="start-title">
        <div class="dash-start-photo"><img src="/img/Graduation_StudentsGroup_Smiling_Outdoor_GettyImages-907837926.jpg" alt="Des diplômés célèbrent la réussite de leur parcours"><span>CHOISIR AUJOURD’HUI, RÉUSSIR DEMAIN.</span></div>
        <div class="dash-start-body"><p class="dash-eyebrow">PAR OÙ COMMENCER ?</p><h2 id="start-title">Un choix éclairé commence par vous.</h2><p>Découvrez les formations, comparez les possibilités et échangez avec notre équipe sur votre projet.</p><a class="dash-text-link" href="#journey">Préparer mon orientation <i class="fas fa-arrow-down" aria-hidden="true"></i></a></div>
    </aside>
</section>
<section class="dash-explore" id="explore" aria-labelledby="explore-title">
    <div class="dash-section-heading"><div><p class="dash-eyebrow">DÉCOUVRIR & COMPRENDRE</p><h2 id="explore-title">Ouvrez le champ des possibles.</h2></div><p>Les bons repères pour trouver une formation qui correspond à vos ambitions.</p></div>
    <div class="dash-resources">
        <a class="dash-feature" href="/index.html#ecoles"><div class="dash-feature-top"><span class="dash-label">LE GUIDE DES ÉTABLISSEMENTS</span><i class="fas fa-university" aria-hidden="true"></i></div><h3>Une formation.<br>Votre direction.</h3><p>Explorez les écoles supérieures par ville, secteur et type de diplôme grâce au moteur de recherche.</p><span class="dash-feature-action">Trouver mon école <i class="fas fa-arrow-right" aria-hidden="true"></i></span></a>
        <div class="dash-resource-list">
            <a class="dash-resource" href="/index.html#services"><span class="dash-resource-icon"><i class="fas fa-compass" aria-hidden="true"></i></span><div><span class="dash-small-label">ACCOMPAGNEMENT</span><h3>Construire mon projet</h3><p>Découvrez nos services d’orientation et d’accompagnement académique.</p></div><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
            <a class="dash-resource" href="/index.html#process"><span class="dash-resource-icon"><i class="fas fa-route" aria-hidden="true"></i></span><div><span class="dash-small-label">MÉTHODE</span><h3>Comprendre les étapes</h3><p>Du premier échange à votre choix de formation, découvrez notre démarche.</p></div><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
            <a class="dash-resource" href="/index.html#contact"><span class="dash-resource-icon"><i class="fas fa-comments" aria-hidden="true"></i></span><div><span class="dash-small-label">CONSEIL</span><h3>Poser mes questions</h3><p>Échangez avec notre équipe pour clarifier vos choix et vos prochaines démarches.</p></div><i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
        </div>
    </div>
</section>
<section class="dash-journey" id="journey" aria-labelledby="journey-title">
    <div class="section-title"><p class="dash-eyebrow">À VOTRE RYTHME</p><h2 id="journey-title">De l’idée au projet.</h2><p>Trois étapes pour préparer votre prochaine décision.</p></div>
    <ol class="dash-steps">
        <li><span class="dash-step-number">01</span><h3>Identifiez vos envies</h3><p>Notez les matières que vous aimez, vos points forts et les métiers qui vous intéressent.</p></li>
        <li><span class="dash-step-number">02</span><h3>Explorez vos options</h3><p>Comparez les formations, leur durée, leur localisation et les diplômes proposés.</p></li>
        <li><span class="dash-step-number">03</span><h3>Faites-vous accompagner</h3><p>Discutez de vos pistes avec un conseiller pour avancer dans vos démarches.</p></li>
    </ol>
    <a class="dash-text-link" href="/index.html#contact">Préparer mon projet avec un conseiller <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
</section>
<section class="dash-account-section" id="account" aria-labelledby="account-title">
    <div class="dash-account">
        <div class="dash-account-copy"><p class="dash-eyebrow">MON COMPTE</p><h2 id="account-title">Votre espace,<br>en toute simplicité.</h2><p>Retrouvez vos informations de connexion et associez votre compte Google pour vos prochaines visites.</p><a class="dash-text-link" href="/logout.php">Se déconnecter <i class="fas fa-arrow-right-from-bracket" aria-hidden="true"></i></a></div>
        <div class="dash-account-details"><span class="dash-account-symbol"><i class="fas fa-user-graduate" aria-hidden="true"></i></span><dl><dt>Nom complet</dt><dd><?php echo $userName; ?></dd><dt>Adresse email</dt><dd><?php echo $userEmail; ?></dd></dl>
        <?php if ($oauthError !== ''): ?><p class="dash-message" role="alert"><?php echo $oauthError; ?></p><?php endif; ?>
        <a class="dash-google" href="/google-oauth.php"><i class="fab fa-google" aria-hidden="true"></i> Associer mon compte Google <i class="fas fa-arrow-right" aria-hidden="true"></i></a></div>
    </div>
</section>
</main>
<footer class="dash-footer"><h3>BABAALI TAWJIH</h3><p>Choisir aujourd’hui, réussir demain.</p><p lang="ar" dir="rtl">نوجهوك للطريق الصحيح</p><nav aria-label="Liens du pied de page"><a href="/index.html">Accueil</a><a href="/index.html#services">Services</a><a href="/index.html#contact">Contact</a></nav><p>© <?php echo date('Y'); ?> BABAALI TAWJIH — Tous droits réservés.</p></footer>
<script>
const menu = document.getElementById('menu');
document.querySelectorAll('#nav a').forEach(link => link.addEventListener('click', () => { menu.checked = false; }));
document.addEventListener('keydown', event => { if (event.key === 'Escape') menu.checked = false; });
</script>
</body>
</html>
