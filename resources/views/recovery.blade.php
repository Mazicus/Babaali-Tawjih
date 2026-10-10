<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $resetMode ? 'Nouveau mot de passe' : 'Récupérer mon compte'; ?> · BABAALI TAWJIH</title>
<link rel="icon" href="/img/BABA_ALI_TAWJIH2.png">
<link rel="stylesheet" href="/style-login.css">
<link rel="stylesheet" href="/style-recovery.css">
<script src="/DarkMode.js" defer></script>
</head>
<body><main id="login"><div class="login-container">
      <div class="theme-box">
        <button id="theme-switch" type="button" aria-label="Activer le thème sombre">
          <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#082a7a"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q8 0 17 .5t23 1.5q-36 32-56 79t-20 99q0 90 63 153t153 63q52 0 99-18.5t79-51.5q1 12 1.5 19.5t.5 14.5q0 150-105 255T480-120Z"/></svg>
          <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#082a7a"><path d="M338.5-338.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-450H40v-60h160v60Zm720 0H760v-60h160v60ZM450-760v-160h60v160h-60Zm0 720v-160h60v160h-60ZM262-658l-100-97 43-44 96 100-39 41Zm494 496-98-100 41-41 99 98-42 43Zm-99-537 98-99 44 42-99 98-43-41ZM162-205l99-98 42 42-98 99-43-43Z"/></svg>
        </button>
      </div>
<div class="login-left">
        <div id="logo">
            <a href="/index.html">
                <img src="/img/BABA_ALI_TAWJIH2.png" alt="BABAALI TAWJIH">
                <img src="/img/white_icon.png" alt="BABAALI TAWJIH">
            </a>
        </div>
<h1>Retrouvez<br>votre espace.</h1><p>Vos écoles et vos informations restent associées à votre compte.</p></div><div class="login-right"><div class="login-form">
<h2><?php echo $resetMode ? 'Nouveau mot de passe' : 'Mot de passe oublié ?'; ?></h2>
<p class="recovery-copy"><?php echo $resetMode ? 'Choisissez un nouveau mot de passe pour votre compte.' : 'Saisissez votre adresse de connexion pour recevoir un lien de récupération.'; ?></p>
<?php if ($error !== ''): ?><p class="message-container error recovery-alert" role="alert"><span class="msg-text"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></span></p><?php endif; ?>
<?php if ($success !== ''): ?><p class="message-container success recovery-alert" role="status"><span class="msg-text"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></span></p><?php endif; ?>
<?php if ($success === '' && (!$resetMode || $tokenValid)): ?><form method="post" action="<?php echo $resetMode ? '/reset-password.php' : '/forgot-password.php'; ?>"><input type="hidden" name="_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
<?php if ($resetMode): ?><label class="recovery-label" for="password">Nouveau mot de passe</label><input id="password" name="password" type="password" minlength="8" maxlength="72" autocomplete="new-password" required><label class="recovery-label" for="confirmation">Confirmer le mot de passe</label><input id="confirmation" name="confirmation" type="password" minlength="8" maxlength="72" autocomplete="new-password" required><?php else: ?><label class="recovery-label" for="email">Adresse email</label><input id="email" name="email" type="email" maxlength="254" autocomplete="email" required><?php endif; ?>
<button type="submit"><?php echo $resetMode ? 'Enregistrer le mot de passe' : 'Recevoir le lien'; ?></button></form><?php endif; ?>
<div class="recovery-links"><a href="/login.php">Retour à la connexion</a><?php if ($resetMode && !$tokenValid && $success === ''): ?><a href="/forgot-password.php">Demander un nouveau lien</a><?php endif; ?><a href="/index.html">Accueil</a></div>
</div></div></div></main></body></html>
