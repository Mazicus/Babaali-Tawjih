<?php
// Start session for user authentication
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/auth.php';

require_once __DIR__ . '/../config/database.php';

//initisialisation des vars
$error_message = '';
$success_message = '';
$email = '';

//login deja?
if (isset($_SESSION['user_id'])) {
    header('Location: Dashboard.php');
    exit();
}

// submision
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    try {  
      // sauvgrader les vars
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $remember_me = isset($_POST['remember_me']) ? true : false;
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Veuillez entrer une adresse email valide.');
        }
        
        // Validate password (minimum 6 characters)
        if (strlen($password) < 6) {
            throw new Exception('Le mot de passe doit contenir au moins 6 caractères.');
        }
        
        // executer requetes
       $stmt = $pdo->prepare("SELECT id, full_name, adress_email, mot_de_passe
FROM users
WHERE adress_email=?
");

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($user && password_verify($password,$user['mot_de_passe'])){
    signInUser($user, $remember_me);

    header("Location: Dashboard.php");
    exit();

}else{

    $error_message="Email ou mot de passe incorrect.";

}
        
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
    header('Location: /google-oauth.php?from=login');
    exit;
}

// Rate limiting - prevent brute force attacks
if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 5) {
    $time_remaining = 300 - (time() - $_SESSION['last_attempt_time']); // 5 minutes
    if ($time_remaining > 0) {
        $error_message = 'Trop de tentatives de connexion. Veuillez attendre ' . ceil($time_remaining/60) . ' minutes.';
    } else {
        // Reset attempts after timeout
        unset($_SESSION['login_attempts']);
        unset($_SESSION['last_attempt_time']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · SmartOrientation</title>
    <link rel="icon" href="./img/BABA_ALI_TAWJIH2.png" style="height: max-content; width:max-content">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./style-login.css">
    <script src="./DarkMode.js" defer></script>
</head>
<body>

  <section id="login">
    <div class="login-container">

      <!-- Dark mode -->
      <div class="theme-box">
        <button id="theme-switch" aria-label="Toggle dark mode">
          <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#082a7a"><path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q8 0 17 .5t23 1.5q-36 32-56 79t-20 99q0 90 63 153t153 63q52 0 99-18.5t79-51.5q1 12 1.5 19.5t.5 14.5q0 150-105 255T480-120Z"/></svg>
          <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#082a7a"><path d="M338.5-338.5Q280-397 280-480t58.5-141.5Q397-680 480-680t141.5 58.5Q680-563 680-480t-58.5 141.5Q563-280 480-280t-141.5-58.5ZM200-450H40v-60h160v60Zm720 0H760v-60h160v60ZM450-760v-160h60v160h-60Zm0 720v-160h60v160h-60ZM262-658l-100-97 43-44 96 100-39 41Zm494 496-98-100 41-41 99 98-42 43Zm-99-537 98-99 44 42-99 98-43-41ZM162-205l99-98 42 42-98 99-43-43Z"/></svg>
        </button>
      </div>

      <!-- left -->
      <div class="login-left">
        <!-- logo -->
        <div id="logo">
            <a href="./page principale.html">
                <img src="./img/BABA_ALI_TAWJIH2.png" >   
                <img src="./img/white_icon.png" >
            </a>
        </div>
        <h1>Bienvenue !</h1>
        <p>
          Connectez-vous à votre espace personnel pour suivre
          votre parcours d'orientation et accéder à toutes
          nos ressources.
        </p>

        <div id="messageBox" class="message-container <?php echo $error_message ? '' : 'hidden'; ?>">
          <i class="fas fa-circle-<?php echo $error_message ? 'exclamation' : 'info'; ?>"></i>
          <span class="msg-text" id="msgText">
            <?php 
            if ($error_message) {
                echo htmlspecialchars($error_message);
            } else {
                echo 'Entrez vos identifiants pour vous connecter.';
            }
            ?>
          </span>
        </div>
      </div>

      <!-- RIGHT: form -->
      <div class="login-right">
        <form class="login-form" id="loginForm" method="POST" action="" novalidate>
          <h2>Se connecter</h2>

          <input type="email" id="emailInput" name="email" placeholder="Adresse Email" value="<?php echo htmlspecialchars($email); ?>" required>
          <input type="password" id="passwordInput" name="password" placeholder="Mot de passe" required>

          <div class="options">
            <label>
              <input type="checkbox" id="rememberCheck" name="remember_me"> Se souvenir de moi
            </label>
            <a href="#">Mot de passe oublié ?</a>
          </div>

          <button type="submit" name="login">Connexion</button>

          <!-- Google Connect section -->
          <div class="divider"><hr><span>ou</span><hr></div>
          <button type="button" class="google-btn" id="googleBtn">
            <i class="fab fa-google"></i> Connecter avec Google
          </button>

          <p class="register-link">
            Vous n'avez pas encore de compte ?
            <a href="./inscription.php">S'inscrire</a>
          </p>
        </form>
      </div>
    </div>
  </section>

  <script>
    (function() {
      "use strict";
      // DOM elements
      const loginForm = document.getElementById('loginForm');
      const emailInput = document.getElementById('emailInput');
      const passwordInput = document.getElementById('passwordInput');
      const messageBox = document.getElementById('messageBox');
      const msgText = document.getElementById('msgText');
      
      // ----- MESSAGE HELPER (show on left container) -----
      function showMessage(text, type = 'warning') {
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
        // auto hide after 5 seconds if success/warning (but keep error until next action)
        if (type !== 'error') {
          clearTimeout(window.msgTimeout);
          window.msgTimeout = setTimeout(() => {
            messageBox.classList.add('hidden');
          }, 5000);
        }
      }

      function hideMessage() {
        messageBox.classList.add('hidden');
        clearTimeout(window.msgTimeout);
      }

      // ----- VALIDATION -----
      function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
      }

      function validatePassword(pwd) {
        return pwd.length >= 6; // at least 6 chars
      }

      // ----- FORM SUBMIT -----
      loginForm.addEventListener('submit', function(e) {
        hideMessage();

        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

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

        // Password validation
        if (!password) {
          e.preventDefault();
          showMessage('Veuillez entrer votre mot de passe.', 'error');
          passwordInput.focus();
          return;
        }
        if (!validatePassword(password)) {
          e.preventDefault();
          showMessage('Le mot de passe doit contenir au moins 6 caractères.', 'error');
          passwordInput.focus();
          return;
        }

        // If all valid, form will submit normally
        // The PHP will handle the actual login
      });

      document.getElementById('googleBtn').addEventListener('click', function() {
        window.location.href = '/google-oauth.php?from=login&remember=' + (document.querySelector('[name="remember_me"]:checked') ? '1' : '0');
      });

      // ----- REAL-TIME FIELD validation on blur (optional) -----
      emailInput.addEventListener('blur', function() {
        const val = this.value.trim();
        if (val && !validateEmail(val)) {
          showMessage('Format email invalide.', 'error');
        } else if (val && validateEmail(val)) {
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
      
      emailInput.addEventListener('input', function() {
        if (!messageBox.classList.contains('hidden')) {
          if (messageBox.classList.contains('error')) {
            // keep error until resolved
          } else {
            hideMessage();
          }
        }
      });
      
      passwordInput.addEventListener('input', function() {
        if (!messageBox.classList.contains('hidden') && !messageBox.classList.contains('error')) {
          hideMessage();
        }
      });

      // Show initial message only if no error message from PHP
      <?php if (!$error_message): ?>
      setTimeout(() => {
        showMessage('Entrez vos identifiants pour vous connecter.', 'warning');
      }, 300);
      <?php endif; ?>

    })();
  </script>
</body>
</html>
