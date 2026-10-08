<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once __DIR__ . '/../config/session.php';

// Check if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: Dashboard.php');
    exit();
}

require_once __DIR__ . '/../config/database.php';

$error_message = '';
$success_message = '';
$full_name = '';
$email = '';
$phone = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    try {
        $full_name = trim($_POST['full_name']);
        $email = trim($_POST['adress_email']);
        $phone = trim($_POST['phonenumber']);
        $password = $_POST['mot_de_passe'];
        $confirm_password = $_POST['confirm_password'];

        // Validation
        if (empty($full_name) || strlen($full_name) < 2) {
            throw new Exception('Le nom complet doit contenir au moins 2 caractères.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Veuillez entrer une adresse email valide.');
        }

        if (empty($phone) || !preg_match('/^[\d\s\+\(\)\-]{7,15}$/', $phone)) {
            throw new Exception('Veuillez entrer un numéro de téléphone valide.');
        }

        if (strlen($password) < 6) {
            throw new Exception('Le mot de passe doit contenir au moins 6 caractères.');
        }

        if ($password !== $confirm_password) {
            throw new Exception('Les mots de passe ne correspondent pas.');
        }

        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE adress_email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            throw new Exception('Cet email est déjà utilisé. Veuillez vous connecter.');
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $stmt = $pdo->prepare("
            INSERT INTO users (full_name, adress_email, phonenumber, mot_de_passe)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $full_name,
            $email,
            $phone,
            $passwordHash
        ]);

        // Get the new user ID
        $user_id = $pdo->lastInsertId();

        // Redirect to dashboard
        header("Location: login.php");
        exit();

    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Consume OAuth errors once.
if (isset($_SESSION['oauth_error'])) {
    $error_message = $_SESSION['oauth_error'];
    unset($_SESSION['oauth_error']);
}
if (isset($_GET['google_oauth'])) {
    header('Location: /google-oauth.php?from=inscription');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription · BABAALI TAWJIH</title>
    <link rel="icon" href="./img/BABA_ALI_TAWJIH2.png" style="height: max-content; width:max-content">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./style-inscription.css">
    <script src="./DarkMode.js" defer></script>
</head>
<body>

<section id="register">
    <div class="register-container">
        <!-- Dark mode -->
        <div class="theme-box">
            <button id="theme-switch" aria-label="Toggle dark mode">
                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q8 0 17 .5t23 1.5q-36 32-56 79t-20 99q0 90 63 153t153 63q52 0 99-18.5t79-51.5q1 12 1.5 19.5t.5 14.5q0 150-105 255T480-120Z"/></svg>
                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px"><path d="M338.5-338.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-450H40v-60h160v60Zm720 0H760v-60h160v60ZM450-760v-160h60v160h-60Zm0 720v-160h60v160h-60ZM262-658l-100-97 43-44 96 100-39 41Zm494 496-98-100 41-41 99 98-42 43Zm-99-537 98-99 44 42-99 98-43-41ZM162-205l99-98 42 42-98 99-43-43Z"/></svg>
            </button>
        </div>

        <!-- LEFT -->
        <div class="register-left">
            <!-- logo -->
            <div id="logo">
                <a href="/index.html">
                    <img src="./img/BABA_ALI_TAWJIH2.png" >   
                    <img src="./img/white_icon.png" >
                </a>
            </div>
            <h1>Créer un compte</h1>
            <p>
                Rejoignez <span id="babaali">BABAALI</span> <span id="tawjih">TAWJIH</span> et accédez à votre espace personnel
                pour suivre votre orientation académique.
            </p>
            <ul>
                <li>✓ Suivi personnalisé</li>
                <li>✓ Accès aux informations des écoles</li>
                <li>✓ Conseils d'orientation</li>
                <li>✓ Notifications importantes</li>
            </ul>
            <!-- message container -->
            <?php if ($error_message): ?>
            <div class="message-container error">
                <i class="fas fa-circle-exclamation"></i>
                <span class="msg-text"><?php echo htmlspecialchars($error_message); ?></span>
            </div>
            <?php elseif ($success_message): ?>
            <div class="message-container success">
                <i class="fas fa-circle-check"></i>
                <span class="msg-text"><?php echo htmlspecialchars($success_message); ?></span>
            </div>
            <?php else: ?>
            <div id="messageBox" class="message-container hidden">
                <i class="fas fa-circle-info"></i>
                <span class="msg-text" id="msgText">Message</span>
            </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT: form -->
        <div class="register-right">
           <form class="register-form" id="registerForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
                <h2>Inscription</h2>

                <input type="text" id="fullName" name="full_name" placeholder="Nom complet" value="<?php echo htmlspecialchars($full_name); ?>" required>
                <input type="email" id="emailInput" name="adress_email" placeholder="Adresse Email" value="<?php echo htmlspecialchars($email); ?>" required>
                <input type="tel" id="phoneInput" name="phonenumber" placeholder="Téléphone" value="<?php echo htmlspecialchars($phone); ?>" required>
                <input type="password" id="passwordInput" name="mot_de_passe" placeholder="Mot de passe" required>
                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirmer le mot de passe" required>

                <button type="submit" name="register">Créer mon compte</button>

                <!-- Google -->
                <div class="divider"><hr><span>ou</span><hr></div>
                <button type="button" class="google-btn" id="googleBtn">
                    <i class="fab fa-google"></i> S'inscrire avec Google
                </button>

                <p class="login-link">
                    Déjà un compte ?
                    <a href="./login.php">Se connecter</a>
                </p>
            </form>
        </div>

    </div>
</section>
<script>
    (function() {
        "use strict";

        const registerForm = document.getElementById('registerForm');
        const fullName = document.getElementById('fullName');
        const emailInput = document.getElementById('emailInput');
        const phoneInput = document.getElementById('phoneInput');
        const passwordInput = document.getElementById('passwordInput');
        const confirmPassword = document.getElementById('confirmPassword');
        const messageBox = document.getElementById('messageBox');
        const msgText = document.getElementById('msgText');

        // Check if there's already a PHP message displayed
        const existingMessage = document.querySelector('.message-container:not(.hidden)');
        if (existingMessage && messageBox) {
            messageBox.classList.add('hidden');
        }

        // ----- MESSAGE HELPER -----
        function showMessage(text, type = 'warning') {
            if (!messageBox) return;
            
            msgText.textContent = text;
            messageBox.classList.remove('hidden', 'warning', 'error', 'success');
            if (type === 'error') {
                messageBox.classList.add('error');
                messageBox.querySelector('i').className = 'fas fa-circle-exclamation';
            } else if (type === 'success') {
                messageBox.classList.add('success');
                messageBox.querySelector('i').className = 'fas fa-circle-check';
            } else {
                messageBox.classList.add('warning');
                messageBox.querySelector('i').className = 'fas fa-triangle-exclamation';
            }
            if (type !== 'error') {
                clearTimeout(window.msgTimeout);
                window.msgTimeout = setTimeout(() => { 
                    if (messageBox) messageBox.classList.add('hidden'); 
                }, 5000);
            }
        }
        
        function hideMessage() { 
            if (messageBox) {
                messageBox.classList.add('hidden'); 
            }
            clearTimeout(window.msgTimeout); 
        }

        // ----- VALIDATION HELPERS -----
        function validateEmail(email) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email); }
        function validatePhone(phone) { return /^[\d\s\+\(\)\-]{7,15}$/.test(phone); }
        function validatePassword(pwd) { return pwd.length >= 6; }

        // ----- FORM SUBMIT (Client-side validation) -----
        registerForm.addEventListener('submit', function(e) {
            // Hide any existing JS message
            hideMessage();

            const name = fullName.value.trim();
            const email = emailInput.value.trim();
            const phone = phoneInput.value.trim();
            const pwd = passwordInput.value.trim();
            const confirm = confirmPassword.value.trim();

            // Name validation
            if (!name) { 
                e.preventDefault();
                showMessage('Veuillez entrer votre nom complet.', 'error'); 
                fullName.focus(); 
                return; 
            }
            if (name.length < 2) { 
                e.preventDefault();
                showMessage('Le nom doit contenir au moins 2 caractères.', 'error'); 
                fullName.focus(); 
                return; 
            }

            // Email validation
            if (!email) { 
                e.preventDefault();
                showMessage('Veuillez entrer votre adresse email.', 'error'); 
                emailInput.focus(); 
                return; 
            }
            if (!validateEmail(email)) { 
                e.preventDefault();
                showMessage('Format d\'email invalide. (ex: nom@domaine.com)', 'error'); 
                emailInput.focus(); 
                return; 
            }

            // Phone validation
            if (!phone) { 
                e.preventDefault();
                showMessage('Veuillez entrer votre numéro de téléphone.', 'error'); 
                phoneInput.focus(); 
                return; 
            }
            if (!validatePhone(phone)) { 
                e.preventDefault();
                showMessage('Numéro de téléphone invalide. (ex: 0612345678)', 'error'); 
                phoneInput.focus(); 
                return; 
            }

            // Password validation
            if (!pwd) { 
                e.preventDefault();
                showMessage('Veuillez créer un mot de passe.', 'error'); 
                passwordInput.focus(); 
                return; 
            }
            if (!validatePassword(pwd)) { 
                e.preventDefault();
                showMessage('Le mot de passe doit contenir au moins 6 caractères.', 'error'); 
                passwordInput.focus(); 
                return; 
            }

            // Confirm password
            if (!confirm) { 
                e.preventDefault();
                showMessage('Veuillez confirmer votre mot de passe.', 'error'); 
                confirmPassword.focus(); 
                return; 
            }
            if (pwd !== confirm) { 
                e.preventDefault();
                showMessage('Les mots de passe ne correspondent pas.', 'error'); 
                confirmPassword.focus(); 
                return; 
            }

            // If all validations pass, form submits normally to PHP
            // Show success message before submit
            showMessage('Inscription en cours...', 'success');
        });

        document.getElementById('googleBtn').addEventListener('click', function() {
        window.location.href = '/google-oauth.php?from=inscription&remember=' + (document.querySelector('[name="remember_me"]:checked') ? '1' : '0');
      });

      // ----- LIVE FEEDBACK -----
        emailInput.addEventListener('blur', function() {
            const val = this.value.trim();
            if (val && !validateEmail(val)) {
                showMessage('Format email invalide.', 'error');
            } else if (val && validateEmail(val)) {
                hideMessage();
            }
        });

        phoneInput.addEventListener('blur', function() {
            const val = this.value.trim();
            if (val && !validatePhone(val)) {
                showMessage('Format téléphone invalide. (ex: 0612345678)', 'error');
            } else if (val && validatePhone(val)) {
                hideMessage();
            }
        });

        passwordInput.addEventListener('blur', function() {
            const val = this.value.trim();
            if (val && !validatePassword(val)) {
                showMessage('Mot de passe trop court (min 6 caractères).', 'error');
            } else if (val && validatePassword(val)) {
                hideMessage();
            }
        });

        confirmPassword.addEventListener('blur', function() {
            const pwd = passwordInput.value.trim();
            const confirm = this.value.trim();
            if (confirm && pwd !== confirm) {
                showMessage('Les mots de passe ne correspondent pas.', 'error');
            } else if (confirm && pwd === confirm) {
                hideMessage();
            }
        });

        // Hide messages when typing (if not error)
        [fullName, emailInput, phoneInput, passwordInput, confirmPassword].forEach(input => {
            input.addEventListener('input', function() {
                if (!messageBox.classList.contains('hidden') && !messageBox.classList.contains('error')) {
                    hideMessage();
                }
            });
        });

        // Welcome hint (only if no PHP message exists)
        const hasPhpMessage = document.querySelector('.message-container:not(.hidden)');
        if (!hasPhpMessage && messageBox) {
            setTimeout(() => {
                showMessage('Remplissez tous les champs pour créer votre compte.', 'warning');
            }, 300);
        }

    })();
</script>
</body>
</html>