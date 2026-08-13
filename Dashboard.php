<?php
session_start();

if (!isset($_SESSION['user_id'])) {
     header("Location: index.php");
     exit();
}

$userName = htmlspecialchars($_SESSION['user_name']);
$userEmail = htmlspecialchars($_SESSION['user_email']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard · BABAALI TAWJIH</title>
    <link rel="icon" href="./img/BABA_ALI_TAWJIH2.png" style="height: max-content; width:max-content">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Font (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./palette.css">
    <link rel="stylesheet" href="./Dashboard.css">
    <script src="./DarkMode.js" defer></script>
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: var(--light);
            color: var(--black);
            min-height: 100vh;
            transition: background 0.25s, color 0.2s;
        }

        /* ===== HEADER / NAVBAR (same style as page principale) ===== */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background: var(--light);
            box-shadow: 0 10px 30px var(--shadow-light);
            transition: background 0.3s, box-shadow 0.3s;
        }

        .container {
            width: 100%;
            padding: 0 2%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 80px;
            background: var(--light);
            transition: background 0.3s;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .logo a {
            display: flex;
            flex-direction: column;
            font-weight: bold;
            text-decoration: none;
            line-height: 1.2;
        }

        .logo-top {
            color: var(--navy-blue);
            font-size: 17px;
            transition: color 0.3s;
        }

        .logo-bottom {
            color: var(--logo-gold);
            font-size: 17px;
            transition: color 0.3s;
        }

        .logo-img-light {
            width: 5pc;
            height: 5pc;
            object-fit: contain;
        }

        .logo-img-dark {
            width: 5pc;
            height: 5pc;
            object-fit: contain;
        }

        .logo .logo-img-light { display: block; }
        .logo .logo-img-dark { display: none; }

        .darkmode .logo .logo-img-light { display: none; }
        .darkmode .logo .logo-img-dark { display: block; }
        .darkmode .logo-top,
        .darkmode .logo-bottom { color: white; }

        /* Navigation */
        .nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav ul {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0;
        }

        .nav ul li a {
            display: block;
            padding: 28px 18px;
            color: var(--text-gray);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: color 0.3s, transform 0.3s, text-shadow 0.3s;
        }

        .nav ul li a:hover {
            color: var(--accent-blue);
            text-shadow: 0 0 1px var(--accent-blue);
            transform: translateY(-2px);
        }

        .nav ul li a.active {
            color: var(--accent-blue);
            border-bottom: 3px solid var(--secondary);
        }

        /* User info in navbar */
        .user-box {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        .user-info {
            text-align: right;
            line-height: 1.3;
        }

        .user-info .name {
            color: var(--primary);
            font-weight: 600;
            font-size: 14px;
        }

        .user-info .email {
            color: var(--text-muted);
            font-size: 12px;
        }

        .logout-btn {
            background: linear-gradient(135deg, #d62828, #b00020);
            color: #fff;
            padding: 10px 22px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            scale: 1.05;
            box-shadow: 0 0 20px rgba(214, 40, 40, 0.4);
        }

        .logout-btn:active {
            scale: 0.98;
        }

        /* Dark mode toggle */
        .theme-box {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #theme-switch {
            height: 40px;
            width: 40px;
            padding: 0;
            border: none;
            border-radius: 50%;
            background-color: var(--gray);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: rotate 0.4s ease, scale 0.4s ease, background 0.3s;
        }

        #theme-switch svg {
            fill: var(--primary-switch);
            scale: 0.6;
            width: 28px;
            height: 28px;
            transition: fill 0.3s;
        }

        #theme-switch svg:last-child {
            display: none;
        }

        .darkmode #theme-switch svg:first-child {
            display: none;
        }

        .darkmode #theme-switch svg:last-child {
            display: block;
        }

        #theme-switch:hover {
            scale: 1.1;
            rotate: -15deg;
        }

        #theme-switch:active {
            scale: 0.9;
            rotate: 25deg;
        }

        /* Mobile menu (same as page principale) */
        .menu-btn {
            display: none;
            font-size: 28px;
            color: var(--primary);
            cursor: pointer;
            z-index: 1002;
        }

        .mobile-icons {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1002;
        }

        #menu,
        .close-btn {
            display: none;
        }

        .mobile-login {
            display: none;
        }

        /* ===== MAIN CONTENT ===== */
        .main {
            margin-top: 80px;
            padding: 30px 35px;
            background: var(--light);
            transition: background 0.3s;
            min-height: calc(100vh - 80px);
        }

        /* Welcome banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary), var(--accent-blue-dark));
            padding: 35px 40px;
            border-radius: 24px;
            color: #fff;
            margin-bottom: 35px;
            box-shadow: 0 8px 30px var(--shadow-medium);
        }

        .welcome-banner h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .welcome-banner h1 span {
            color: var(--secondary);
        }

        .welcome-banner p {
            opacity: 0.9;
            font-size: 1.05rem;
        }

        /* ===== CARDS ===== */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: var(--light);
            padding: 28px 24px;
            border-radius: 20px;
            box-shadow: 0 8px 25px var(--shadow-light);
            border: 1px solid var(--border-gray);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 35px var(--shadow-medium);
            border-color: var(--secondary);
        }

        .card i {
            font-size: 2.6rem;
            color: var(--secondary);
            margin-bottom: 14px;
            display: inline-block;
            transition: color 0.3s;
        }

        .card h3 {
            color: var(--primary);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 6px;
            transition: color 0.3s;
        }

        .card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .card .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent-blue);
            margin-top: 8px;
            display: block;
        }

        /* ===== QUICK ACTIONS ===== */
        .quick-actions {
            background: var(--light);
            padding: 30px 35px;
            border-radius: 24px;
            box-shadow: 0 8px 25px var(--shadow-light);
            border: 1px solid var(--border-gray);
            transition: background 0.3s, box-shadow 0.3s, border-color 0.3s;
        }

        .quick-actions h2 {
            color: var(--primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
            transition: color 0.3s;
        }

        .quick-actions h2 i {
            color: var(--secondary);
            margin-right: 10px;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .buttons a {
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 40px;
            background: var(--primary);
            color: #fff;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid transparent;
        }

        .buttons a:hover {
            background: var(--secondary);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px var(--shadow-medium);
        }

        .buttons a i {
            color: inherit;
        }

        .buttons a.danger {
            background: #d62828;
        }

        .buttons a.danger:hover {
            background: #b00020;
            color: #fff;
        }

        /* ===== RESPONSIVE ===== */
        @media screen and (max-width: 991px) {
            .menu-btn {
                display: block;
            }

            .user-box {
                display: none;
            }

            .nav {
                position: fixed;
                top: 0;
                right: -100%;
                width: 340px;
                max-width: 90%;
                height: 100vh;
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
                background: var(--nav-mobile-bg);
                border-left: 1px solid rgba(255, 255, 255, 0.79);
                transition: right 0.4s ease;
                overflow-y: auto;
                padding: 90px 0 80px;
                flex-direction: column;
                align-items: flex-start;
                box-shadow: -15px 0 35px rgba(0, 0, 0, 0.35);
                z-index: 1005;
            }

            .nav::-webkit-scrollbar {
                display: none;
            }

            #menu:checked~.nav {
                right: 0;
            }

            .nav ul {
                flex-direction: column;
                width: 100%;
                padding: 0 20px;
            }

            .nav ul li {
                width: 100%;
            }

            .nav ul li a {
                padding: 16px 28px;
                font-size: 15px;
                border-radius: 8px;
            }

            .nav ul li a:hover {
                background: var(--secondary-transparent);
                color: var(--accent-blue);
            }

            .nav ul li a.active {
                border-bottom: none;
                background: var(--secondary-transparent);
            }

            .close-btn {
                position: absolute;
                top: 25px;
                right: 20px;
                display: block;
                font-size: 30px;
                color: var(--primary);
                cursor: pointer;
                z-index: 1003;
            }

            .mobile-login {
                display: flex;
                flex-direction: column;
                gap: 12px;
                padding: 20px 30px;
                width: 100%;
            }

            .mobile-login .user-info-mobile {
                padding: 12px 16px;
                background: var(--gray);
                border-radius: 12px;
                text-align: center;
            }

            .mobile-login .user-info-mobile .name {
                color: var(--primary);
                font-weight: 600;
            }

            .mobile-login .user-info-mobile .email {
                color: var(--text-muted);
                font-size: 13px;
            }

            .mobile-login .logout-btn-mobile {
                width: 100%;
                text-align: center;
                padding: 14px;
                font-size: 15px;
                border-radius: 12px;
                background: #d62828;
                color: #fff;
                text-decoration: none;
                font-weight: 600;
                transition: background 0.3s;
            }

            .mobile-login .logout-btn-mobile:hover {
                background: #b00020;
            }

            .mobile-icons {
                position: relative;
                z-index: 1002;
                gap: 15px;
            }

            .main {
                padding: 20px;
            }

            .welcome-banner {
                padding: 25px 28px;
            }

            .welcome-banner h1 {
                font-size: 1.6rem;
            }

            .cards {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 18px;
            }

            .quick-actions {
                padding: 22px 24px;
            }
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 0 15px;
                min-height: 70px;
            }

            .logo-top,
            .logo-bottom {
                font-size: 14px;
            }

            .logo-img-dark,
            .logo-img-light {
                width: 4pc;
                height: 4pc;
            }

            .welcome-banner h1 {
                font-size: 1.3rem;
            }

            .welcome-banner p {
                font-size: 0.95rem;
            }

            .card {
                padding: 20px 18px;
            }

            .card i {
                font-size: 2rem;
            }

            .card .stat-number {
                font-size: 1.6rem;
            }

            .buttons a {
                width: 100%;
                justify-content: center;
                padding: 14px 20px;
            }
        }

        @media screen and (max-width: 480px) {
            .main {
                padding: 15px;
            }

            .welcome-banner {
                padding: 20px;
            }

            .welcome-banner h1 {
                font-size: 1.1rem;
            }

            .cards {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }

            .card {
                padding: 16px 14px;
            }

            .card h3 {
                font-size: 1rem;
            }

            .card p {
                font-size: 0.85rem;
            }

            .card i {
                font-size: 1.6rem;
                margin-bottom: 8px;
            }

            .quick-actions {
                padding: 18px 16px;
            }

            .quick-actions h2 {
                font-size: 1.2rem;
            }

            #theme-switch {
                height: 34px;
                width: 34px;
            }

            #theme-switch svg {
                scale: 0.45;
                width: 22px;
                height: 22px;
            }

            .menu-btn {
                font-size: 24px;
            }

            .mobile-icons {
                gap: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- ===== HEADER / NAVBAR (horizontal, same as page principale) ===== -->
    <header class="header">
        <div class="container">
            <!-- Logo -->
            <div class="logo">
                <img class="logo-img-dark" src="./img/white_icon_s.png" alt="BABAALI TAWJIH">
                <img class="logo-img-light" src="./img/BABA_ALI_TAWJIH.png" alt="BABAALI TAWJIH">
                <a href="#">
                    <span class="logo-top">BABAALI</span>
                    <span class="logo-bottom">TAWJIH</span>
                </a>
            </div>

            <!-- Menu Toggle -->
            <input type="checkbox" id="menu">

            <!-- Navigation -->
            <nav class="nav" id="nav">
                <label for="menu" class="close-btn">
                    <i class="fas fa-times"></i>
                </label>
                <ul>
                    <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-school"></i> Écoles</a></li>
                    <li><a href="#"><i class="fas fa-university"></i> Universités</a></li>
                    <li><a href="#"><i class="fas fa-file-alt"></i> Concours</a></li>
                    <li><a href="#"><i class="fas fa-heart"></i> Favoris</a></li>
                    <li><a href="#"><i class="fas fa-calendar"></i> Calendrier</a></li>
                </ul>
                <!-- Mobile user info & logout -->
                <div class="mobile-login">
                    <div class="user-info-mobile">
                        <div class="name"><?php echo $userName; ?></div>
                        <div class="email"><?php echo $userEmail; ?></div>
                    </div>
                    <a href="logout.php" class="logout-btn-mobile">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </a>
                </div>
            </nav>

            <!-- Desktop User Info + Logout -->
            <div class="user-box">
                <div class="user-info">
                    <div class="name"><?php echo $userName; ?></div>
                    <div class="email"><?php echo $userEmail; ?></div>
                </div>
                <a href="logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>

            <!-- Mobile Icons (dark mode + hamburger) -->
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

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main">

        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h1>Bienvenue <span><?php echo $userName; ?></span> 👋</h1>
            <p>Votre espace personnel BABAALI TAWJIH — suivez votre orientation académique en toute simplicité.</p>
        </div>

        <!-- Stats Cards -->
        <div class="cards">
            <div class="card">
                <i class="fas fa-school"></i>
                <h3>Écoles Supérieures</h3>
                <span class="stat-number">120</span>
                <p>Établissements référencés</p>
            </div>
            <div class="card">
                <i class="fas fa-university"></i>
                <h3>Universités</h3>
                <span class="stat-number">45</span>
                <p>Universités partenaires</p>
            </div>
            <div class="card">
                <i class="fas fa-file-signature"></i>
                <h3>Concours</h3>
                <span class="stat-number">18</span>
                <p>Concours ouverts</p>
            </div>
            <div class="card">
                <i class="fas fa-bell"></i>
                <h3>Notifications</h3>
                <span class="stat-number">0</span>
                <p>Aucune nouvelle notification</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2><i class="fas fa-bolt"></i> Actions rapides</h2>
            <div class="buttons">
                <a href="#"><i class="fas fa-school"></i> Voir les écoles</a>
                <a href="#"><i class="fas fa-search"></i> Rechercher une université</a>
                <a href="#"><i class="fas fa-file-alt"></i> Voir les concours</a>
                <a href="#"><i class="fas fa-user"></i> Mon profil</a>
                <a href="logout.php" class="danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            </div>
        </div>

    </main>

</body>
</html>