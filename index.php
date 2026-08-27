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
                    </ul>
                    <div class="mobile-login">
                        <a href="login.php" class="login">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.00098 11.999L16.001 11.999M16.001 11.999L12.501 8.99902M16.001 11.999L12.501 14.999" stroke="#082a7a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.00195 7C9.01406 4.82497 9.11051 3.64706 9.87889 2.87868C10.7576 2 12.1718 2 15.0002 2L16.0002 2C18.8286 2 20.2429 2 21.1215 2.87868C22.0002 3.75736 22.0002 5.17157 22.0002 8L22.0002 16C22.0002 18.8284 22.0002 20.2426 21.1215 21.1213C20.2429 22 18.8286 22 16.0002 22H15.0002C12.1718 22 10.7576 22 9.87889 21.1213C9.11051 20.3529 9.01406 19.175 9.00195 17" stroke="#082a7a" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            Se connecter
                        </a>
                        <a href="inscription.php" class="btn-inscr">S'inscrire</a>
                    </div>
                </nav>
                <div class="login-box">
                    <a href="login.php" class="login" target="_blank">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.00098 11.999L16.001 11.999M16.001 11.999L12.501 8.99902M16.001 11.999L12.501 14.999" stroke="#082a7a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.00195 7C9.01406 4.82497 9.11051 3.64706 9.87889 2.87868C10.7576 2 12.1718 2 15.0002 2L16.0002 2C18.8286 2 20.2429 2 21.1215 2.87868C22.0002 3.75736 22.0002 5.17157 22.0002 8L22.0002 16C22.0002 18.8284 22.0002 20.2426 21.1215 21.1213C20.2429 22 18.8286 22 16.0002 22H15.0002C12.1718 22 10.7576 22 9.87889 21.1213C9.11051 20.3529 9.01406 19.175 9.00195 17" stroke="#082a7a" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                        Se connecter
                    </a>
                    <a href="inscription.php" class="btn-inscr" target="_blank">S'inscrire</a>
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
                    <input type="text" id="searchEcoles" placeholder="Rechercher une école, une ville, un secteur...">
                </div>
                <button class="filter-btn" id="filterToggle">
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
                        <a target="_blank" href="tel:+212700059552">+212 7 00 05 95 52</a>
                        <a target="_blank" href="tel:+212610131559">+212 6 10 13 15 59</a>
                        <a target="_blank" href="tel:+212529999422">+212 5 29 99 94 22</a>
                    </div>
                    <div class="contact-email">
                        <p><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/></svg> Email</p>
                        <a target="_blank" href="https://mail.google.com/mail/u/0/">contact@babaalitawjih.ma</a>
                    </div>
                    <div class="contact-location">
                        <p><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M536.5-503.5Q560-527 560-560t-23.5-56.5Q513-640 480-640t-56.5 23.5Q400-593 400-560t23.5 56.5Q447-480 480-480t56.5-23.5ZM480-186q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Z"/></svg> Bureau</p>
                        <div class="contact-address">
                        <iframe class="localisation" src="https://www.google.com/maps?q=Centre+Babaali+Biougra&output=embed" allowfullscreen loading="lazy"></iframe>
                            <br>
                                <a href="#">Rue Prince Moulay Rachid, Biougra, Morocco</a>


                        </div>
                    </div>
                    
                </div>

                <div class="contact-form">
                    <h2>Demande de contact</h2>
                <form action="contact.php" method="POST">
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

        <script>
            // Ecole data - FIXED: removed duplicates, fixed sector values
            const ecolesData = [
                // Sciences de la Santé et Médecine
                { id: 1, name: "FMP Agadir", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Agadir", sector: "sante", type: "public", acronym: "FMP", link: "https://fmpa.uiz.ac.ma/" },
                { id: 2, name: "FMP Marrakech", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Marrakech", sector: "sante", type: "public", acronym: "FMP", link: "https://fmpm.uca.ma/" },
                { id: 3, name: "FMP Casablanca", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Casablanca", sector: "sante", type: "public", acronym: "FMP", link: "https://www.fmpc.ac.ma/" },
                { id: 4, name: "FMP Rabat", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Rabat", sector: "sante", type: "public", acronym: "FMP", link: "https://fmp.um5.ac.ma/" },
                { id: 5, name: "FMP Oujda", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Oujda", sector: "sante", type: "public", acronym: "FMP", link: "http://fmpo.ump.ma/" },
                { id: 6, name: "FMP Tanger", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Tanger", sector: "sante", type: "public", acronym: "FMP", link: "https://fmpt.ac.ma/" },
                { id: 7, name: "FMP Laâyoune", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Laâyoune", sector: "sante", type: "public", acronym: "FMP", link: "http://fmpl.uiz.ac.ma/" },
                { id: 8, name: "FMP Errachidia", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Errachidia", sector: "sante", type: "public", acronym: "FMP", link: "https://www.fmpe.umi.ac.ma/" },
                { id: 9, name: "FMP Béni Mellal", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Béni Mellal", sector: "sante", type: "public", acronym: "FMP", link: "https://fmpbm.usms.ac.ma/" },
                { id: 10, name: "FMP Guelmim", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Guelmim", sector: "sante", type: "public", acronym: "FMP", link: "https://www.fmpg.uiz.ac.ma/" },
                { id: 11, name: "FMP Fès", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Fès", sector: "sante", type: "public", acronym: "FMP", link: "https://www.fmp-usmba.ac.ma/" },
                { id: 12, name: "FMD Casablanca", diploma: "Chirurgien Dentiste", duration: "6 ans", durationValue: "6ans", location: "Casablanca", sector: "sante", type: "public", acronym: "FMD", link: "https://www.fmd-uh2c.ac.ma/" },
                { id: 13, name: "FMD Rabat", diploma: "Chirurgien Dentiste", duration: "6 ans", durationValue: "6ans", location: "Rabat", sector: "sante", type: "public", acronym: "FMD", link: "https://fmd.um5.ac.ma/" },
                { id: 14, name: "FMD Fès", diploma: "Chirurgien Dentiste", duration: "6 ans", durationValue: "6ans", location: "Fès", sector: "sante", type: "public", acronym: "FMD", link: "https://www.fmp-usmba.ac.ma/" },
                { id: 15, name: "PH Agadir", diploma: "Pharmacien", duration: "6 ans", durationValue: "6ans", location: "Agadir", sector: "sante", type: "public", acronym: "PH", link: "https://fmpa.uiz.ac.ma/" },
                { id: 16, name: "PH Marrakech", diploma: "Pharmacien", duration: "6 ans", durationValue: "6ans", location: "Marrakech", sector: "sante", type: "public", acronym: "PH", link: "https://fmpm.uca.ma/" },
                { id: 17, name: "PH Casablanca", diploma: "Pharmacien", duration: "6 ans", durationValue: "6ans", location: "Casablanca", sector: "sante", type: "public", acronym: "PH", link: "https://www.fmpc.ac.ma/" },
                { id: 18, name: "PH Rabat", diploma: "Pharmacien", duration: "6 ans", durationValue: "6ans", location: "Rabat", sector: "sante", type: "public", acronym: "PH", link: "https://fmp.um5.ac.ma/" },
                { id: 19, name: "PH Oujda", diploma: "Pharmacien", duration: "6 ans", durationValue: "6ans", location: "Oujda", sector: "sante", type: "public", acronym: "PH", link: "http://fmpo.ump.ma/" },
                { id: 20, name: "PH Tanger", diploma: "Pharmacien", duration: "6 ans", durationValue: "6ans", location: "Tanger", sector: "sante", type: "public", acronym: "PH", link: "https://fmpt.ac.ma/" },
                { id: 21, name: "ISPITS", diploma: "L.M.D", duration: "3-5-7 ans", durationValue: "3ans,5ans,7ans", location: "Plusieurs Villes", sector: "sante", type: "public", acronym: "ISPITS", link: "https://ispits.sante.gov.ma/" },

                // Commerce, Gestion et Économie
                { id: 22, name: "ENCG Casablanca", diploma: "Diplôme d'ENCG", duration: "5 ans", durationValue: "5ans", location: "Casablanca", sector: "commerce", type: "public", acronym: "ENCG", link: "https://www.encgcasa.ma/" },
                { id: 23, name: "ISCAE Casablanca", diploma: "Licence", duration: "3 ans", durationValue: "3ans", location: "Casablanca", sector: "commerce", type: "public", acronym: "ISCAE", link: "https://www.groupeiscae.ma/" },
                { id: 24, name: "ISCAE Rabat", diploma: "Licence", duration: "3 ans", durationValue: "3ans", location: "Rabat", sector: "commerce", type: "public", acronym: "ISCAE", link: "https://www.groupeiscae.ma/" },

                // Architecture, Urbanisme et Aménagement
                { id: 25, name: "ENA Rabat", diploma: "Architecte", duration: "6 ans", durationValue: "6ans", location: "Rabat", sector: "architecture", type: "public", acronym: "ENA", link: "https://www.enarabat.ac.ma/" },
                { id: 26, name: "ENA Fès", diploma: "Architecte", duration: "6 ans", durationValue: "6ans", location: "Fès", sector: "architecture", type: "public", acronym: "ENA", link: "https://www.archi.ac.ma/" },
                { id: 27, name: "ENA Marrakech", diploma: "Architecte", duration: "6 ans", durationValue: "6ans", location: "Marrakech", sector: "architecture", type: "public", acronym: "ENA", link: "https://www.archi.ac.ma/" },
                { id: 28, name: "ENA Tétouan", diploma: "Architecte", duration: "6 ans", durationValue: "6ans", location: "Tétouan", sector: "architecture", type: "public", acronym: "ENA", link: "https://www.archi.ac.ma/" },
                { id: 29, name: "ENA Agadir", diploma: "Architecte", duration: "6 ans", durationValue: "6ans", location: "Agadir", sector: "architecture", type: "public", acronym: "ENA", link: "https://www.archi.ac.ma/" },
                { id: 30, name: "ENA Oujda", diploma: "Architecte", duration: "6 ans", durationValue: "6ans", location: "Oujda", sector: "architecture", type: "public", acronym: "ENA", link: "https://www.archi.ac.ma/" },
                { id: 31, name: "INAU Rabat", diploma: "Diplôme d'INAU", duration: "5 ans", durationValue: "5ans", location: "Rabat", sector: "architecture", type: "public", acronym: "INAU", link: "https://www.inau.ac.ma/" },

                // Ingénierie, Technologies et Sciences Exactes
                { id: 32, name: "ENSA Agadir", diploma: "Ingénieur d'État", duration: "5 ans", durationValue: "5ans", location: "Agadir", sector: "ingenierie", type: "public", acronym: "ENSA", link: "https://www.ensa-agadir.ac.ma/" },
                { id: 33, name: "ENSAM Meknès", diploma: "Ingénieur d'État", duration: "5 ans", durationValue: "5ans", location: "Meknès", sector: "ingenierie", type: "public", acronym: "ENSAM", link: "https://www.ensam.ac.ma/" },
                { id: 34, name: "ENSAM Casablanca", diploma: "Ingénieur d'État", duration: "5 ans", durationValue: "5ans", location: "Casablanca", sector: "ingenierie", type: "public", acronym: "ENSAM", link: "https://www.ensam-casa.ma/" },
                { id: 35, name: "ENSAM Rabat", diploma: "Ingénieur d'État", duration: "5 ans", durationValue: "5ans", location: "Rabat", sector: "ingenierie", type: "public", acronym: "ENSAM", link: "https://www.ensam-rabat.ma/" },
                { id: 36, name: "ENIAD Berkane", diploma: "Ingénieur", duration: "5 ans", durationValue: "5ans", location: "Berkane", sector: "ingenierie", type: "public", acronym: "ENIAD", link: "https://www.eniad.ump.ma/" },
                { id: 37, name: "ENSCK Kénitra", diploma: "Ingénieur", duration: "5 ans", durationValue: "5ans", location: "Kénitra", sector: "ingenierie", type: "public", acronym: "ENSCK", link: "https://www.ensck.uit.ac.ma/" },
                { id: 38, name: "FST Marrakech", diploma: "L.M.D", duration: "3-5-7 ans", durationValue: "3ans,5ans,7ans", location: "Marrakech", sector: "ingenierie", type: "public", acronym: "FST", link: "https://www.fst.uca.ma/" },
                { id: 39, name: "FST Settat", diploma: "L.M.D", duration: "3-5-7 ans", durationValue: "3ans,5ans,7ans", location: "Settat", sector: "ingenierie", type: "public", acronym: "FST", link: "https://www.fsts.ac.ma/" },
                { id: 40, name: "FST Mohammédia", diploma: "L.M.D", duration: "3-5-7 ans", durationValue: "3ans,5ans,7ans", location: "Mohammédia", sector: "ingenierie", type: "public", acronym: "FST", link: "https://www.fstm.ac.ma/" },
                { id: 41, name: "EST Casablanca", diploma: "DUT", duration: "2 ans", durationValue: "2ans", location: "Casablanca", sector: "ingenierie", type: "public", acronym: "EST", link: "https://www.estc.ac.ma/" },
                { id: 42, name: "ESITH Casablanca", diploma: "Technicien / Licence / Master / Ingénieur", duration: "2/3/5 ans", durationValue: "2ans,3ans,5ans", location: "Casablanca", sector: "ingenierie", type: "public", acronym: "ESITH", link: "https://www.esith.ac.ma/" },
                { id: 43, name: "BTS", diploma: "Technicien Spécialisé", duration: "2 ans", durationValue: "2ans", location: "Plusieurs Villes", sector: "ingenierie", type: "public", acronym: "BTS", link: "https://www.men.gov.ma/" },

                // Agriculture, Sciences Vétérinaires et Environnement
                { id: 44, name: "ENAM Meknès", diploma: "Ingénieur Agronome", duration: "5 ans", durationValue: "5ans", location: "Meknès", sector: "agriculture", type: "public", acronym: "ENAM", link: "http://www.enameknes.ma/" },
                { id: 45, name: "IAV Hassan II Rabat", diploma: "Ingénieur / Docteur Vétérinaire", duration: "5-6 ans", durationValue: "5ans,6ans", location: "Rabat", sector: "agriculture", type: "public", acronym: "IAV", link: "https://iav.ac.ma/" },

                // Filières Préparatoires
                { id: 46, name: "CPGE", diploma: "Accès aux Grandes Écoles d'Ingénieur", duration: "2 ans", durationValue: "2ans", location: "Plusieurs Villes", sector: "preparatoire", type: "public", acronym: "CPGE", link: "https://www.men.gov.ma/" },
                { id: 47, name: "LYDEX Benguerir", diploma: "Accès aux Grandes Écoles d'Ingénieur", duration: "2 ans", durationValue: "2ans", location: "Benguerir", sector: "preparatoire", type: "public", acronym: "LYDEX", link: "https://www.lyceedexcellence.ma/" },
                { id: 48, name: "LYDEX Rabat", diploma: "Accès aux Grandes Écoles d'Ingénieur", duration: "2 ans", durationValue: "2ans", location: "Rabat", sector: "preparatoire", type: "public", acronym: "LYDEX", link: "https://www.lyceedexcellence.ma/" },
                { id: 49, name: "LYDEX Casablanca", diploma: "Accès aux Grandes Écoles d'Ingénieur", duration: "2 ans", durationValue: "2ans", location: "Casablanca", sector: "preparatoire", type: "public", acronym: "LYDEX", link: "https://www.lyceedexcellence.ma/" },
                { id: 50, name: "LYDEX Martil", diploma: "Accès aux Grandes Écoles d'Ingénieur", duration: "2 ans", durationValue: "2ans", location: "Martil", sector: "preparatoire", type: "public", acronym: "LYDEX", link: "https://www.lyceedexcellence.ma/" },

                // Formation Militaire
                { id: 51, name: "ERA Marrakech", diploma: "Ingénieur Officier / Licence", duration: "4-5 ans", durationValue: "4ans,5ans", location: "Marrakech", sector: "militaire", type: "public", acronym: "ERA", link: "https://www.far.ma/" },
                { id: 52, name: "ERN Casablanca", diploma: "Ingénieur / Licence", duration: "4-5 ans", durationValue: "4ans,5ans", location: "Casablanca", sector: "militaire", type: "public", acronym: "ERN", link: "https://www.far.ma/" },
                { id: 53, name: "ARM Meknès", diploma: "Officier", duration: "4 ans", durationValue: "4ans", location: "Meknès", sector: "militaire", type: "public", acronym: "ARM", link: "https://www.far.ma/" },
                { id: 54, name: "ERSSM Rabat", diploma: "Médecin / Pharmacien / Chirurgien Dentiste", duration: "6 ans", durationValue: "6ans", location: "Rabat", sector: "militaire", type: "public", acronym: "ERSSM", link: "https://www.far.ma/" },

                // Tourisme et Hôtellerie
                { id: 55, name: "ISITT Tanger", diploma: "Licence / Master", duration: "3/5 ans", durationValue: "3ans,5ans", location: "Tanger", sector: "tourisme", type: "public", acronym: "ISITT", link: "https://www.isitt.ma/" },

                // Universités Privées - FIXED: all sectors are "prive", types are "prive"
                { id: 56, name: "UIASS Rabat", diploma: "L.M.D", duration: "3-5-6 ans", durationValue: "3ans,5ans,6ans", location: "Rabat", sector: "prive", type: "prive", acronym: "UIASS", fees: "1500 DH", link: "https://www.uiass.ma/" },
                { id: 57, name: "UM6SS Casablanca", diploma: "L.M.D", duration: "3-5-6 ans", durationValue: "3ans,5ans,6ans", location: "Casablanca", sector: "prive", type: "prive", acronym: "UM6SS", fees: "1500 DH", link: "https://www.um6ss.ma/campus-casablanca" },
                { id: 58, name: "UM6SS Rabat", diploma: "L.M.D", duration: "3-5-6 ans", durationValue: "3ans,5ans,6ans", location: "Rabat", sector: "prive", type: "prive", acronym: "UM6SS", fees: "1500 DH", link: "https://www.um6ss.ma/" },
                { id: 59, name: "UPSSA Agadir", diploma: "L.M.D", duration: "3-5-6 ans", durationValue: "3ans,5ans,6ans", location: "Agadir", sector: "prive", type: "prive", acronym: "UPSSA", fees: "800 DH", link: "https://www.upssa.ma/" },
                { id: 60, name: "UPM Marrakech", diploma: "L.M.D", duration: "3-5-6 ans", durationValue: "3ans,5ans,6ans", location: "Marrakech", sector: "prive", type: "prive", acronym: "UPM", fees: "1500 DH", link: "https://www.upm.ac.ma/" },
                { id: 61, name: "UIR Rabat", diploma: "L.M.D", duration: "3-5-6 ans", durationValue: "3ans,5ans,6ans", location: "Rabat", sector: "prive", type: "prive", acronym: "UIR", fees: "750 DH", link: "https://www.uir.ac.ma/" },

                // UM6P Benguerir - FIXED: all sectors are "um6p"
                { id: 62, name: "FMS Benguerir", diploma: "Médecin", duration: "6 ans", durationValue: "6ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "FMS", link: "https://www.um6p.ma/fr/college/faculte-de-medecine-et-de-pharmacie" },
                { id: 63, name: "SASE Benguerir", diploma: "Bachelor", duration: "4 ans", durationValue: "4ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "SASE", link: "https://www.um6p.ma/fr/college/sase" },
                { id: 64, name: "EMINES Benguerir", diploma: "Ingénieur", duration: "5 ans", durationValue: "5ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "EMINES", link: "https://www.emines-ingenieur.org/" },
                { id: 65, name: "CS Benguerir", diploma: "Ingénieur", duration: "5 ans", durationValue: "5ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "CS", link: "https://www.um6p.ma/fr/college/college-of-computing" },
                { id: 66, name: "GUP Benguerir", diploma: "Ingénieur", duration: "5 ans", durationValue: "5ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "GUP", link: "https://www.um6p.ma/fr/college/college-of-green-process-engineering" },
                { id: 67, name: "SHBM Benguerir", diploma: "Bachelor", duration: "4 ans", durationValue: "4ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "SHBM", link: "https://www.um6p.ma/fr/college/shbm" },
                { id: 68, name: "FGSES Benguerir", diploma: "Licence", duration: "3 ans", durationValue: "3ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "FGSES", link: "https://www.um6p.ma/fr/college/fgses" },
                { id: 69, name: "FGSES Rabat", diploma: "Licence", duration: "3 ans", durationValue: "3ans", location: "Rabat", sector: "um6p", type: "prive", acronym: "FGSES", link: "https://www.um6p.ma/fr/college/fgses" },
                { id: 70, name: "ESAFE Benguerir", diploma: "Ingénieur", duration: "5 ans", durationValue: "5ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "ESAFE", link: "https://www.um6p.ma/fr/college/esafe" },
                { id: 71, name: "ISSB-P Benguerir", diploma: "Licence", duration: "3 ans", durationValue: "3ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "ISSB-P", link: "https://www.um6p.ma/fr/college/issb-p" },
                { id: 72, name: "SAP+D Benguerir", diploma: "Architecte", duration: "6 ans", durationValue: "6ans", location: "Benguerir", sector: "um6p", type: "prive", acronym: "SAP+D", link: "https://www.um6p.ma/fr/college/sap-d" }
            ];

            // Secteur data
            const sectorConfig = {
                sante: {
                    label: 'Sciences de la Santé et Médecine',
                    icon: 'fa-solid fa-staff-snake',
                    color: 'primary',
                    image: 'https://png.pngtree.com/png-vector/20250524/ourmid/pngtree-smiling-female-doctor-with-stethoscope-isolated-on-transparent-background-png-image_16376010.png'
                },
                commerce: {
                    label: 'Commerce, Gestion et Économie',
                    icon: 'fa-solid fa-sharp fa-chart-line',
                    color: 'secondary',
                    image: 'https://png.pngtree.com/png-vector/20240124/ourmid/pngtree-ceo-business-profile-png-image_11479711.png'
                },
                architecture: {
                    label: 'Architecture, Urbanisme et Aménagement',
                    icon: 'fa-solid fa-building',
                    color: 'primary',
                    image: 'https://png.pngtree.com/png-vector/20241213/ourmid/pngtree-female-architect-holding-a-construction-blueprint-and-planning-designs-png-image_14724359.png'
                },
                ingenierie: {
                    label: 'Ingénierie, Technologies et Sciences Exactes',
                    icon: 'fa-solid fa-microchip',
                    color: 'secondary',
                    image: 'https://png.pngtree.com/png-vector/20240309/ourmid/pngtree-construction-worker-engineer-png-image_11917231.png'
                },
                agriculture: {
                    label: 'Agriculture, Sciences Vétérinaires et Environnement',
                    icon: 'fa-solid fa-seedling',
                    color: 'primary',
                    image: 'https://png.pngtree.com/png-clipart/20230131/ourmid/pngtree-agricultural-research-scientific-experiment-png-image_6197918.png'
                },
                preparatoire: {
                    label: 'Filières Préparatoires',
                    icon: 'fa-solid fa-book-open',
                    color: 'secondary',
                    image: 'https://png.pngtree.com/png-vector/20240317/ourmid/pngtree-university-or-college-student-study-online-at-home-png-image_11996657.png'
                },
                militaire: {
                    label: 'Formation Militaire',
                    icon: 'fa-solid fa-shield-halved',
                    color: 'primary',
                    image: 'https://png.pngtree.com/png-vector/20250928/ourmid/pngtree-army-officer-png-image_17577498.webp'
                },
                tourisme: {
                    label: 'Tourisme et Hôtellerie',
                    icon: 'fa-solid fa-umbrella-beach',
                    color: 'secondary',
                    image: 'https://png.pngtree.com/png-vector/20241001/ourmid/pngtree-male-waiter-manager-png-image_13986198.png'
                },
                prive: {
                    label: 'Universités Privées',
                    icon: 'fa-solid fa-building-columns',
                    color: 'primary',
                    image: 'https://images.unsplash.com/photo-1562774053-701939374585?w=400&h=200&fit=crop&auto=format'
                },
                um6p: {
                    label: 'Université Mohammed VI Polytechnique (UM6P)',
                    icon: 'fa-solid fa-graduation-cap',
                    color: 'secondary',
                    image: './img/um6p.png'
                }
            };

            // Group by sector
            function groupBySector(data) {
                const groups = {};
                data.forEach(item => {
                    if (!groups[item.sector]) {
                        groups[item.sector] = [];
                    }
                    groups[item.sector].push(item);
                });
                return groups;
            }

            // Function images
            function getUniversityImage(ecole) {
                const imageMap = {
                    'FMP Agadir': 'https://images.unsplash.com/photo-1516549655169-df83a0774514?w=400&h=300&fit=crop&auto=format',
                    'FMP Marrakech': 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=400&h=300&fit=crop&auto=format',
                    'FMP Casablanca': 'https://images.unsplash.com/photo-1551601651-2a8555f1a136?w=400&h=300&fit=crop&auto=format',
                    'FMP Rabat': 'https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=400&h=300&fit=crop&auto=format',
                    'FMP Oujda': 'https://images.unsplash.com/photo-1584982751601-97dcc096659c?w=400&h=300&fit=crop&auto=format',
                    'FMP Tanger': 'https://images.unsplash.com/photo-1666214280391-8ff5bd3c0bf0?w=400&h=300&fit=crop&auto=format',
                    'FMP Fès': 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=400&h=300&fit=crop&auto=format',
                    'FMD Casablanca': 'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=400&h=300&fit=crop&auto=format',
                    'FMD Rabat': 'https://images.unsplash.com/photo-1609840114035-3c981b782dcf?w=400&h=300&fit=crop&auto=format',
                    'PH Casablanca': 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=400&h=300&fit=crop&auto=format',
                    'PH Rabat': 'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=400&h=300&fit=crop&auto=format',
                    'ENCG Casablanca': 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400&h=300&fit=crop&auto=format',
                    'ISCAE Casablanca': 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&h=300&fit=crop&auto=format',
                    'ISCAE Rabat': 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=300&fit=crop&auto=format',
                    'ENA Rabat': 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=400&h=300&fit=crop&auto=format',
                    'ENA Fès': 'https://images.unsplash.com/photo-1503387837-b154d5074bd2?w=400&h=300&fit=crop&auto=format',
                    'INAU Rabat': 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400&h=300&fit=crop&auto=format',
                    'ENSA Agadir': 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=400&h=300&fit=crop&auto=format',
                    'ENSAM Meknès': 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&h=300&fit=crop&auto=format',
                    'FST Marrakech': 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=400&h=300&fit=crop&auto=format',
                    'EST Casablanca': 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0?w=400&h=300&fit=crop&auto=format',
                    'ENAM Meknès': 'https://images.unsplash.com/photo-1560493676-04071c5f467b?w=400&h=300&fit=crop&auto=format',
                    'IAV Hassan II Rabat': 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400&h=300&fit=crop&auto=format',
                    'CPGE': 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=300&fit=crop&auto=format',
                    'LYDEX Benguerir': 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400&h=300&fit=crop&auto=format',
                    'ERA Marrakech': 'https://images.unsplash.com/photo-1541844053589-346841d0b34c?w=400&h=300&fit=crop&auto=format',
                    'ARM Meknès': 'https://images.unsplash.com/photo-1582139329536-e7284fece509?w=400&h=300&fit=crop&auto=format',
                    'ISITT Tanger': 'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=400&h=300&fit=crop&auto=format',
                    'UIASS Rabat': 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=400&h=300&fit=crop&auto=format',
                    'UM6SS Casablanca': 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=400&h=300&fit=crop&auto=format',
                    'UIR Rabat': 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=400&h=300&fit=crop&auto=format',
                    'FMS Benguerir': 'https://images.unsplash.com/photo-1666887360610-84e3bd985971?w=400&h=300&fit=crop&auto=format',
                    'SASE Benguerir': 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?w=400&h=300&fit=crop&auto=format',
                    'EMINES Benguerir': 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=400&h=300&fit=crop&auto=format',
                    'CS Benguerir': 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop&auto=format',
                };
                const fallbacks = {
                    sante: 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?w=400&h=300&fit=crop&auto=format',
                    commerce: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=300&fit=crop&auto=format',
                    architecture: 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?w=400&h=300&fit=crop&auto=format',
                    ingenierie: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=400&h=300&fit=crop&auto=format',
                    agriculture: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400&h=300&fit=crop&auto=format',
                    preparatoire: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=400&h=300&fit=crop&auto=format',
                    militaire: 'https://images.unsplash.com/photo-1582139329536-e7284fece509?w=400&h=300&fit=crop&auto=format',
                    tourisme: 'https://images.unsplash.com/photo-1540541338287-41700207dee6?w=400&h=300&fit=crop&auto=format',
                    prive: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=400&h=300&fit=crop&auto=format',
                    um6p: 'https://images.unsplash.com/photo-1562774053-701939374585?w=400&h=300&fit=crop&auto=format'
                };
                return imageMap[ecole.name] || fallbacks[ecole.sector] || 'https://images.unsplash.com/photo-1523050854058-8df90110c7f1?w=400&h=300&fit=crop&auto=format';
            }

            // Rendering
            function renderSections(data) {
                const container = document.getElementById('ecolesSections');
                if (!container) return;

                const groups = groupBySector(data);
                const sectorKeys = Object.keys(sectorConfig);

                let totalItems = 0;
                let html = '';

                sectorKeys.forEach((key) => {
                    const items = groups[key] || [];
                    if (items.length === 0) return;

                    totalItems += items.length;
                    const config = sectorConfig[key];
                    const isPrimary = config.color === 'primary';
                    const sectionClass = isPrimary ? 'section-primary' : 'section-secondary';

                    html += `
                        <div class="ecole-subsection ${sectionClass}" data-sector-key="${key}">
                            <div class="section-header">
                                <div class="section-header-content">
                                    <div class="section-icon">
                                        <i class="${config.icon}"></i>
                                    </div>
                                    <div class="section-title-wrapper">
                                        <h3>${config.label}</h3>
                                        <span class="section-count">${items.length} établissements</span>
                                    </div>
                                </div>
                                <button type="button" class="section-toggle" aria-expanded="true" aria-controls="ecole-collapse-${key}" aria-label="Réduire la section ${config.label}">
                                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                </button>
                                <div class="section-image" aria-hidden="true">
                                    <img src="${config.image}" alt="" loading="lazy">
                                </div>
                            </div>
                            <div class="ecole-section-collapse" id="ecole-collapse-${key}">
                                <div class="ecole-section-collapse-inner">
                                    <hr class="section-divider">
                                    <div class="ecole-section">
                                        <div class="section-grid">
                                            ${items.map(ecole => {
                                        const sectorLabel = sectorConfig[ecole.sector]?.label || ecole.sector;
                                        const sectorShort = sectorLabel.split(' ')[0].replaceAll(",", "");
                                        const typeLabel = ecole.type === 'public' ? 'Public' : 'Privé';
                                        const driveLink = ecole.drive || ecole.link;
                                        return `
                                        <article class="ecole-card" data-sector="${ecole.sector}" data-duration="${ecole.durationValue}" data-type="${ecole.type}">
                                            <button type="button" class="ecole-card-toggle" aria-expanded="false" aria-controls="ecole-panel-${ecole.id}" id="ecole-toggle-${ecole.id}">
                                                <span class="ecole-card-badges">
                                                    <span class="sector-tag">${sectorShort}</span>
                                                    <span class="type-tag ${ecole.type}">${typeLabel}</span>
                                                </span>
                                                <h3 class="card-title">${ecole.name}</h3>
                                                <ul class="card-summary-list">
                                                    <li class="detail-item">
                                                        <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                                                        <span>${ecole.diploma}</span>
                                                    </li>
                                                    <li class="detail-item">
                                                        <i class="fas fa-clock" aria-hidden="true"></i>
                                                        <span>${ecole.duration}</span>
                                                    </li>
                                                    <li class="detail-item">
                                                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                                        <span>${ecole.location}</span>
                                                    </li>
                                                </ul>
                                                <span class="ecole-card-chevron" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
                                            </button>
                                            <div class="ecole-card-panel" id="ecole-panel-${ecole.id}" role="region" aria-labelledby="ecole-toggle-${ecole.id}">
                                                <div class="ecole-card-panel-inner">
                                                    <ul class="card-full-list">
                                                        <li class="detail-item">
                                                            <i class="fas fa-layer-group" aria-hidden="true"></i>
                                                            <span><strong>Secteur :</strong> ${sectorLabel}</span>
                                                        </li>
                                                        <li class="detail-item">
                                                            <i class="fas fa-graduation-cap" aria-hidden="true"></i>
                                                            <span><strong>Diplôme :</strong> ${ecole.diploma}</span>
                                                        </li>
                                                        <li class="detail-item">
                                                            <i class="fas fa-clock" aria-hidden="true"></i>
                                                            <span><strong>Durée :</strong> ${ecole.duration}</span>
                                                        </li>
                                                        <li class="detail-item">
                                                            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                                            <span><strong>Ville :</strong> ${ecole.location}</span>
                                                        </li>
                                                        ${ecole.fees ? `
                                                        <li class="detail-item">
                                                            <i class="fas fa-coins" aria-hidden="true"></i>
                                                            <span><strong>Frais :</strong> ${ecole.fees}</span>
                                                        </li>` : ''}
                                                    </ul>
                                                    <a href="${ecole.link}" target="_blank" rel="noopener noreferrer" class="btn-card">
                                                        En savoir plus <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="${driveLink}" target="_blank" rel="noopener noreferrer" class="ecole-card-drive" aria-label="Accéder aux détails sur Drive - ${ecole.name}">
                                                <i class="fa-brands fa-google-drive" aria-hidden="true"></i>
                                                <span>Accéder aux détails sur Drive</span>
                                            </a>
                                        </article>
                                    `;
                                    }).join('')}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                document.getElementById('resultCount').textContent = totalItems;
                container.innerHTML = html;
            }

            // Filter
            function getFilteredData() {
                const searchQuery = document.getElementById('searchEcoles')?.value.toLowerCase().trim() || '';

                const checkedSectors = [...document.querySelectorAll('#filterDropdown .filter-group:first-child input[type="checkbox"]:checked')]
                    .map(el => el.value);
                const checkedDurations = [...document.querySelectorAll('#filterDropdown .filter-group:nth-child(2) input[type="checkbox"]:checked')]
                    .map(el => el.value);
                const checkedTypes = [...document.querySelectorAll('#filterDropdown .filter-group:nth-child(3) input[type="checkbox"]:checked')]
                    .map(el => el.value);

                let filtered = [...ecolesData];

                if (searchQuery) {
                    filtered = filtered.filter(ecole =>
                        ecole.name.toLowerCase().includes(searchQuery) ||
                        ecole.diploma.toLowerCase().includes(searchQuery) ||
                        ecole.location.toLowerCase().includes(searchQuery) ||
                        (sectorConfig[ecole.sector]?.label.toLowerCase().includes(searchQuery)) ||
                        (ecole.acronym && ecole.acronym.toLowerCase().includes(searchQuery))
                    );
                }

                if (checkedSectors.length > 0) {
                    filtered = filtered.filter(ecole => checkedSectors.includes(ecole.sector));
                }

                if (checkedDurations.length > 0) {
                    filtered = filtered.filter(ecole => {
                        const durations = ecole.durationValue.split(',');
                        return checkedDurations.some(d => durations.includes(d));
                    });
                }

                if (checkedTypes.length > 0) {
                    filtered = filtered.filter(ecole => checkedTypes.includes(ecole.type));
                }

                return filtered;
            }

            function applyFilters() {
                const filtered = getFilteredData();
                renderSections(filtered);
            }

            // Event listeners
            document.getElementById('searchEcoles')?.addEventListener('input', applyFilters);
            document.getElementById('filterToggle')?.addEventListener('click', function() {
                const dropdown = document.getElementById('filterDropdown');
                dropdown.classList.toggle('show');
                this.classList.toggle('active');
            });

            document.querySelector('.btn-filter-apply')?.addEventListener('click', applyFilters);

            document.querySelector('.btn-filter-reset')?.addEventListener('click', function() {
                document.querySelectorAll('#filterDropdown input[type="checkbox"]').forEach(el => el.checked = false);
                document.getElementById('searchEcoles').value = '';
                applyFilters();
            });

            document.addEventListener('click', function(e) {
                const filterContainer = document.querySelector('.search-container');
                const dropdown = document.getElementById('filterDropdown');
                if (filterContainer && dropdown) {
                    if (!filterContainer.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.remove('show');
                        document.getElementById('filterToggle')?.classList.remove('active');
                    }
                }
            });

            // Ecole card - progressive disclosure (expand/collapse)
            document.getElementById('ecolesSections')?.addEventListener('click', function (e) {
                const sectionToggle = e.target.closest('.section-toggle');
                if (sectionToggle) {
                    const subsection = sectionToggle.closest('.ecole-subsection');
                    if (!subsection) return;
                    const isCollapsed = subsection.classList.toggle('is-collapsed');
                    sectionToggle.setAttribute('aria-expanded', String(!isCollapsed));
                    return;
                }

                const toggle = e.target.closest('.ecole-card-toggle');
                if (!toggle) return;
                const card = toggle.closest('.ecole-card');
                if (!card) return;
                const isExpanded = card.classList.toggle('is-expanded');
                toggle.setAttribute('aria-expanded', String(isExpanded));
            });

            // Initialisation
            renderSections(ecolesData);
        </script>
    </body>
</html>