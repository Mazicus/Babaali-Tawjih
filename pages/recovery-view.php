<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $resetMode ? 'Nouveau mot de passe' : 'Récupérer mon compte'; ?> · BABAALI TAWJIH</title>
<link rel="icon" href="/img/BABA_ALI_TAWJIH2.png"><link rel="stylesheet" href="/style-login.css">
<style>.recovery-brand{color:var(--primary);font-weight:700;text-decoration:none;margin-bottom:25px;display:block}.recovery-copy{color:var(--text-muted);font-size:14px;line-height:1.8;margin:15px 0 22px}.recovery-alert{padding:14px;border-left:4px solid var(--secondary);background:var(--gray);color:var(--text-gray);border-radius:12px;margin-bottom:20px;font-size:14px;line-height:1.7}.recovery-links{margin-top:24px;display:flex;flex-wrap:wrap;gap:18px}.recovery-links a{color:var(--primary);font-size:13px}.recovery-label{display:block;color:var(--text-gray);font-size:13px;margin-bottom:8px}</style>
</head>
<body><main id="login"><div class="login-container"><div class="login-left"><h1>Retrouvez<br>votre espace.</h1><p>Vos écoles et vos informations restent associées à votre compte.</p><a class="recovery-brand" href="/index.html">BABAALI TAWJIH</a></div><div class="login-right"><div class="login-form">
<h2><?php echo $resetMode ? 'Nouveau mot de passe' : 'Mot de passe oublié ?'; ?></h2>
<p class="recovery-copy"><?php echo $resetMode ? 'Choisissez un nouveau mot de passe pour votre compte.' : 'Saisissez votre adresse de connexion pour recevoir un lien de récupération.'; ?></p>
<?php if ($error !== ''): ?><p class="recovery-alert" role="alert"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
<?php if ($success !== ''): ?><p class="recovery-alert" role="status"><?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p><?php endif; ?>
<?php if ($success === '' && (!$resetMode || $tokenValid)): ?><form method="post" action="<?php echo $resetMode ? '/reset-password.php' : '/forgot-password.php'; ?>"><input type="hidden" name="csrf" value="<?php echo htmlspecialchars(personalCsrfToken(), ENT_QUOTES, 'UTF-8'); ?>">
<?php if ($resetMode): ?><label class="recovery-label" for="password">Nouveau mot de passe</label><input id="password" name="password" type="password" minlength="8" maxlength="72" autocomplete="new-password" required><label class="recovery-label" for="confirmation">Confirmer le mot de passe</label><input id="confirmation" name="confirmation" type="password" minlength="8" maxlength="72" autocomplete="new-password" required><?php else: ?><label class="recovery-label" for="email">Adresse email</label><input id="email" name="email" type="email" maxlength="254" autocomplete="email" required><?php endif; ?>
<button type="submit"><?php echo $resetMode ? 'Enregistrer le mot de passe' : 'Recevoir le lien'; ?></button></form><?php endif; ?>
<div class="recovery-links"><a href="/login.php">Retour à la connexion</a><?php if ($resetMode && !$tokenValid && $success === ''): ?><a href="/forgot-password.php">Demander un nouveau lien</a><?php endif; ?><a href="/index.html">Accueil</a></div>
</div></div></div></main></body></html>
