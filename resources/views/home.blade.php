<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BABAALI TAWJIH | Orientation et Accompagnement Académique</title>
        <link rel="icon" href="./img/BABA_ALI_TAWJIH2.png" style="height: max-content; width:max-content">
        <meta name="description" content="Expertise en orientation et accompagnement stratégique vers les grandes écoles, instituts et universités au Maroc.">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="./style.css">
        <script src="./DarkMode.js" defer></script>
        <script src="/AuthNavigation.js" defer></script>
        <script src="/Favorites.js" defer></script>
        <script src="/Schools.js" defer></script>
        <link rel="stylesheet" href="/favorites.css">
    </head>
    <body>
        <!-- Header -->
       <header class="header">
            <div class="container">
                <div class="logo">
                    <img class="logo-img-dark" src="./img/white_icon_s.png" alt="BABAALI TAWJIH">
                    <img class="logo-img-light" src="./img/BABA_ALI_TAWJIH.png" alt="BABAALI TAWJIH">
                    <a href="#logo">
                        <span class="logo-top">BABAALI</span>
                        <span class="logo-bottom">TAWJIH</span>
                    </a>
                </div>
                <input type="checkbox" id="menu">
                <nav class="nav" id="nav">
                    <label for="menu" class="close-btn">
                        <i class="fas fa-times"></i>
                    </label>
                    <ul>
                        <li><a href="#logo">Accueil</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#ecoles">Écoles Supérieures</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li data-auth="member" hidden><a href="/Dashboard.php">Mon espace</a></li>
                    </ul>
                    <div class="mobile-login">
                    <form  class="login" data-auth="member" hidden method="post" action="/logout.php">@csrf<button type="submit">Se déconnecter</button></form>
                        <a href="/login.php" data-auth="guest" hidden class="login">
                            <svg class="login-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path d="M14 4h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-4"/><path d="M4 12h11m-4-4 4 4-4 4"/></svg>
                            Se connecter
                        </a>
                        <a href="/inscription.php" data-auth="guest" hidden class="btn-inscr">S'inscrire</a>
                    </div>
                </nav>
                <div class="login-box">
                    <form  class="login" data-auth="member" hidden method="post" action="/logout.php">@csrf<button type="submit">Se déconnecter</button></form>
                    <a href="/login.php" data-auth="guest" hidden class="login">
                        <svg class="login-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path d="M14 4h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-4"/><path d="M4 12h11m-4-4 4 4-4 4"/></svg>
                        Se connecter
                    </a>
                    <a href="/inscription.php" data-auth="guest" hidden class="btn-inscr">S'inscrire</a>
                </div>
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


        <!-- Hero -->
        <section class="hero" id="logo">
            <div class="hero-content">
                <h1>
                    BABAALI TAWJIH<br>
                    <span>نوجهوك للطريق الصحيح</span>
                </h1>
                <p>
                    Expertise en orientation et accompagnement stratégique vers les grandes écoles,
                    instituts et universités au Maroc.
                </p>
                <div class="btns">
                    <a href="#contact" class="btn btn-primary">Commencer maintenant</a>
                    <a href="#contact" class="btn btn-secondary">Nous contacter</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="./img/Graduate.png" alt="Gradute Picture">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 649 578">
                    <path fill="#FFF" d="M-225.5,154.7l358.45,456.96c7.71,9.83,21.92,11.54,31.75,3.84l456.96-358.45c9.83-7.71,11.54-21.92,3.84-31.75
                        L267.05-231.66c-7.71-9.83-21.92-11.54-31.75-3.84l-456.96,358.45C-231.49,130.66-233.2,144.87-225.5,154.7z"></path>
                    <path class="customLineAnim" fill="none" stroke="#1C5FA8" stroke-width="1.5" stroke-miterlimit="10" d="M416-21l202.27,292.91c5.42,7.85,3.63,18.59-4.05,24.25L198,603" style="animation-delay: 300ms; animation-duration: 5s;"></path>
                </svg>
            </div>
        </section>

        <!-- Services -->
        <section id="services">
            <div class="section-title">
                <h2>Nos Services</h2>
                <p>Un accompagnement complet vers votre réussite académique.</p>
            </div>
            <div class="services">
                <div class="card">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <h3>Orientation Post-Bac</h3>
                    <p>Choix stratégique des filières et établissements.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-user-group"></i>
                    <h3>Accompagnement Personnalisé</h3>
                    <p>Suivi adapté à chaque étudiant.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-school"></i>
                    <h3>Grandes Écoles</h3>
                    <p>Inscription et accompagnement complet.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-bell"></i>
                    <h3>Concours & Résultats</h3>
                    <p>Veille et suivi des opportunités.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-bullseye"></i>
                    <h3>Conseils Stratégiques</h3>
                    <p>Orientation selon votre profil.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-file-lines"></i>
                    <h3>Assistance Administrative</h3>
                    <p>Préparation et gestion des dossiers.</p>
                </div>
            </div>
        </section>

        <!-- Process -->
        <section id="process">
            <div class="section-title">
                <h2>Notre Processus</h2>
            </div>
            <div class="timeline">
                <div class="step">
                    <div class="number">1</div>
                    <h3>Analyse du Profil</h3>
                    <p>Étude approfondie du parcours et des objectifs.</p>
                </div>
                <div class="step">
                    <div class="number">2</div>
                    <h3>Choix Stratégique</h3>
                    <p>Sélection des meilleures opportunités.</p>
                </div>
                <div class="step">
                    <div class="number">3</div>
                    <h3>Préparation des Dossiers</h3>
                    <p>Constitution et vérification des documents.</p>
                </div>
                <div class="step">
                    <div class="number">4</div>
                    <h3>Inscription & Suivi</h3>
                    <p>Accompagnement jusqu'à l'admission.</p>
                </div>
            </div>
        </section>

        <!-- Les Ecoles sup -->
        <section class="ecoles" id="ecoles">
            <div class="section-title">
                <h2>Écoles Supérieures</h2>
                <p>Trouvez l'école qui correspond à vos critères parmi nos établissements partenaires</p>
            </div>

            <!-- Search & Filter -->
            <div class="search-container">
                <div class="search-box">
                    <span class="icon">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#dedede" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <input type="text" id="searchEcoles" aria-label="Rechercher une école, une ville ou un secteur" placeholder="Rechercher une école, une ville, un secteur...">
                </div>
                <button class="filter-btn" id="filterToggle" type="button" aria-expanded="false" aria-controls="filterDropdown">
                    <span class="filter-icon">⏷</span>
                    Filtrer
                </button>
            </div>

            <!-- Filter Dropdown -->
            <div class="filter-dropdown" id="filterDropdown">
                <div class="filter-group">
                    <h4>Secteur</h4>
                    <label><input type="checkbox" value="sante"> Sciences de la Santé</label>
                    <label><input type="checkbox" value="commerce"> Commerce & Gestion</label>
                    <label><input type="checkbox" value="architecture"> Architecture</label>
                    <label><input type="checkbox" value="ingenierie"> Ingénierie & Technologies</label>
                    <label><input type="checkbox" value="agriculture"> Agriculture & Environnement</label>
                    <label><input type="checkbox" value="militaire"> Formation Militaire</label>
                    <label><input type="checkbox" value="tourisme"> Tourisme & Hôtellerie</label>
                    <label><input type="checkbox" value="prive"> Universités Privées</label>
                    <label><input type="checkbox" value="preparatoire"> Filières Préparatoires</label>
                    <label><input type="checkbox" value="um6p"> UM6P Benguerir</label>
                </div>
                <div class="filter-group">
                    <h4>Durée</h4>
                    <label><input type="checkbox" value="2ans"> 2 ans</label>
                    <label><input type="checkbox" value="3ans"> 3 ans</label>
                    <label><input type="checkbox" value="4ans"> 4 ans</label>
                    <label><input type="checkbox" value="5ans"> 5 ans</label>
                    <label><input type="checkbox" value="6ans"> 6 ans</label>
                    <label><input type="checkbox" value="7ans"> 7 ans</label>
                </div>
                <div class="filter-group">
                    <h4>Type</h4>
                    <label><input type="checkbox" value="public"> Public</label>
                    <label><input type="checkbox" value="prive"> Privé</label>
                </div>
                <div class="filter-actions">
                    <button class="btn-filter-apply">Appliquer</button>
                    <button class="btn-filter-reset">Réinitialiser</button>
                </div>
            </div>

            <!-- Results Count -->
            <div class="results-count">
                <span id="resultCount">0</span> établissements trouvés
            </div>

            <!-- ===== SECTION HEADER WITH IMAGE ===== -->


            <!-- ===== CARDS SECTION ===== -->
            <p id="favorite-status" role="status" aria-live="polite"></p>
            <div class="ecoles-sections" id="ecolesSections">
                <!-- Cards will be dynamically rendered here -->
            </div>
        </section>

        <!-- Contact -->
      <section id="contact">
            <div class="section-title">
                <h2>Contactez-nous</h2>
                <p>Une question ? Un besoin spécifique ? Notre équipe est là pour vous accompagner.</p>
            </div>
            <div class="contact">
                <div class="contact-info">
                    <h3>Nos Coordonnées</h3>
                    <p><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12Z"/></svg> Téléphone</p>
                    <div class="numbers">
                        <a href="tel:+212700059552">+212 7 00 05 95 52</a>
                        <a href="tel:+212610131559">+212 6 10 13 15 59</a>
                        <a href="tel:+212529999422">+212 5 29 99 94 22</a>
                    </div>
                    <div class="contact-email">
                        <p><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/></svg> Email</p>
                        <a href="mailto:contact@babaalitawjih.ma">contact@babaalitawjih.ma</a>
                    </div>
                    <div class="contact-location">
                        <p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M536.5-503.5Q560-527 560-560t-23.5-56.5Q513-640 480-640t-56.5 23.5Q400-593 400-560t23.5 56.5Q447-480 480-480t56.5-23.5ZM480-186q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Z"/></svg> Bureau</p>
                        <div class="contact-address">
                        <iframe class="localisation" src="https://www.google.com/maps?q=Centre+Babaali+Biougra&output=embed" allowfullscreen loading="lazy"></iframe>
                            <br>
                                <a href="https://www.google.com/maps/search/?api=1&amp;query=Centre+Babaali+Biougra">Rue Prince Moulay Rachid, Biougra, Morocco</a>


                        </div>
                    </div>

                </div>

                <div class="contact-form">
                    <h2>Demande de contact</h2>
                <form action="contact.php" method="POST">@csrf @if(session("success"))<p role="status">{{ session("success") }}</p>@endif @if($errors->any())<p role="alert">{{ $errors->first() }}</p>@endif
                    <input type="text" name ="full_name" placeholder="Nom complet" required>
                    <input type="email" name = "adresse_email" placeholder="Adresse Email" required>
                    <textarea class="message" rows="5" name = "message_TEXT" placeholder="Votre message" required></textarea>
                    <button class="send-botton" type = "submit">
                        <p>Envoyer</p>
                        <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.93935 12.6464L7.69211 11.8973L7.69211 11.8973L7.6921 11.8973C5.3389 11.1129 4.16229 10.7207 4.16229 9.99997C4.16229 9.27921 5.3389 8.88701 7.69212 8.10261L16.2053 5.26488C17.8611 4.71295 18.689 4.43699 19.126 4.87401C19.563 5.31102 19.287 6.13892 18.7351 7.79471L15.8974 16.3079L15.8974 16.3079L15.8974 16.3079C15.113 18.6611 14.7208 19.8377 14 19.8377C13.2793 19.8377 12.8871 18.6611 12.1026 16.3079L11.3536 14.0606L15.7071 9.70708C16.0976 9.31656 16.0976 8.68339 15.7071 8.29287C15.3166 7.90234 14.6834 7.90234 14.2929 8.29287L9.93935 12.6464Z" fill="#082a7a"/>
                        </svg>
                    </button>
                </form>

                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <h3>BABAALI TAWJIH</h3>
            <p>Choisir aujourd'hui, réussir demain.</p>
            <p>نوجهوك للطريق الصحيح</p>
            <br>
            <div class="social-media">
                <a target="_blank" href="https://www.facebook.com/profile.php?id=61565968660252">
                    <svg width="45px" height="45px" fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z"></path>
                    </svg>
                </a>
                <a target="_blank" href="https://www.instagram.com/babaalitawjih/">
                    <svg width="43px" height="43px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="#ffffff"/>
                        <path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="#ffffff"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" fill="#ffffff"/>
                    </svg>
                </a>
            </div>
            <br>
            <p>© 2026 BABAALI TAWJIH - Tous droits réservés.</p>
        </footer>

        <!-- WhatsApp Floating Button -->
        <a href="https://wa.me/212700059552" class="whatsapp" target="_blank">
            <i class="fab fa-whatsapp"></i>
        </a>


    </body>
</html>