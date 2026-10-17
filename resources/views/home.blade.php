<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>BABAALI TAWJIH | Orientation et Accompagnement Académique</title>
        <link rel="icon" href="./img/BABA_ALI_TAWJIH2.png" style="height: max-content; width:max-content">
        <meta name="description" content="Expertise en orientation et accompagnement stratégique vers les grandes écoles, instituts et universités au Maroc.">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Fustat:wght@400;500;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="./style.css">
        <script src="./DarkMode.js" defer></script>
        <script src="/AuthNavigation.js" defer></script>
        <script src="/MobileNavigation.js" defer></script>
        <script src="/Favorites.js" defer></script>
        <script src="/SectionReveals.js" defer></script>
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
                <label for="menu" class="nav-backdrop" aria-hidden="true"></label>
                <nav class="nav" id="nav" aria-label="Navigation principale">
                    <div role="button" tabindex="0" class="close-btn" aria-label="Fermer le menu">
                        <i class="fas fa-times" aria-hidden="true"></i>
                    </div>
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
                    <div role="button" tabindex="0" class="menu-btn" aria-label="Ouvrir le menu" aria-controls="nav" aria-expanded="false">
                        <i class="fas fa-bars" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </header>


        <!-- Hero -->
        <section class="hero" id="logo">
            <div class="hero-content">
                <h1>
                    BABAALI TAWJIH<br>
                    <span lang="ar" dir="rtl">نوجهوك للطريق الصحيح</span>
                </h1>
                <p>
                    Choisissez votre parcours avec confiance. Un accompagnement en orientation
                    stratégique vers les écoles supérieures, de vos premières questions jusqu’à l’admission.
                </p>
                <div class="btns">
                    <a href="#contact" class="btn btn-primary">Parler de mon orientation</a>
                    <a href="#ecoles" class="btn btn-secondary">Explorer les écoles</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="./img/Graduate.png" alt="Diplômée souriante">
                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 649 578">
                    <path fill="#FFF" d="M-225.5,154.7l358.45,456.96c7.71,9.83,21.92,11.54,31.75,3.84l456.96-358.45c9.83-7.71,11.54-21.92,3.84-31.75
                        L267.05-231.66c-7.71-9.83-21.92-11.54-31.75-3.84l-456.96,358.45C-231.49,130.66-233.2,144.87-225.5,154.7z"></path>
                    <path class="customLineAnim" fill="none" stroke="#1C5FA8" stroke-width="1.5" stroke-miterlimit="10" d="M416-21l202.27,292.91c5.42,7.85,3.63,18.59-4.05,24.25L198,603" style="animation-delay: 300ms; animation-duration: 5s;"></path>
                </svg>
            </div>
        </section>

        <!-- Services -->
        <section id="services" class="guidance-services" aria-labelledby="services-title">
            <div class="section-title">
                <span class="section-eyebrow">À vos côtés</span>
                <h2 id="services-title">Nos services</h2>
                <p>Choisir un parcours adapté, découvrir les écoles supérieures et avancer dans vos démarches d’admission.</p>
            </div>
            <div class="services">
                <article class="card service-card">
                    <span class="service-icon"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></span>
                    <h3>Orientation post-bac</h3>
                    <p>Trouvez une filière qui correspond à vos envies, à vos résultats et à votre projet d’avenir.</p>
                    <span class="service-note">Explorer les possibilités</span>
                </article>
                <article class="card service-card">
                    <span class="service-icon"><i class="fa-solid fa-user-group" aria-hidden="true"></i></span>
                    <h3>Accompagnement personnalisé</h3>
                    <p>Faites le point sur votre parcours et avancez avec des conseils adaptés à votre situation.</p>
                    <span class="service-note">Clarifier votre projet</span>
                </article>
                <article class="card service-card">
                    <span class="service-icon"><i class="fa-solid fa-school" aria-hidden="true"></i></span>
                    <h3>Choix des grandes écoles</h3>
                    <p>Comparez les formations, les conditions d’accès et les établissements pour choisir avec confiance.</p>
                    <span class="service-note">Comparer les établissements</span>
                </article>
                <article class="card service-card">
                    <span class="service-icon"><i class="fa-solid fa-bell" aria-hidden="true"></i></span>
                    <h3>Concours et admissions</h3>
                    <p>Repérez les modalités de sélection et les échéances à vérifier pour préparer vos candidatures.</p>
                    <span class="service-note">Anticiper les démarches</span>
                </article>
                <article class="card service-card">
                    <span class="service-icon"><i class="fa-solid fa-bullseye" aria-hidden="true"></i></span>
                    <h3>Orientation stratégique</h3>
                    <p>Construisez un parcours cohérent avec les métiers qui vous intéressent, en prévoyant des alternatives.</p>
                    <span class="service-note">Définir vos priorités</span>
                </article>
                <article class="card service-card">
                    <span class="service-icon"><i class="fa-solid fa-file-lines" aria-hidden="true"></i></span>
                    <h3>Assistance administrative</h3>
                    <p>Organisez les pièces demandées et vérifiez les consignes avant de transmettre vos dossiers.</p>
                    <span class="service-note">Préparer vos dossiers</span>
                </article>
            </div>
        </section>

        <!-- Process -->
        <section id="process" class="guidance-process" aria-labelledby="process-title">
            <div class="section-title">
                <span class="section-eyebrow">Pas à pas</span>
                <h2 id="process-title">Un parcours clair, à chaque étape</h2>
                <p>Un accompagnement depuis le choix de votre parcours jusqu’aux démarches d’admission.</p>
            </div>
            <ol class="timeline process-timeline">
                <li class="step process-step">
                    <div class="timeline-marker" aria-hidden="true"><span class="timeline-dot"></span></div>
                    <div class="process-copy">
                        <span class="step-label">01 • <span>    Votre point de départ</span></span>
                        <h3>Comprendre votre profil</h3>
                        <p>Un échange sur vos résultats, vos centres d’intérêt et vos objectifs pour préciser ce que vous recherchez.</p>
                    </div>
                </li>
                <li class="step process-step">
                    <div class="timeline-marker" aria-hidden="true"><span class="timeline-dot"></span></div>
                    <div class="process-copy">
                        <span class="step-label">02 • <span>    Les options possibles</span></span>
                        <h3>Choisir votre direction</h3>
                        <p>Nous comparons les filières et les établissements selon votre profil, leurs conditions d’accès et vos contraintes.</p>
                    </div>
                </li>
                <li class="step process-step">
                    <div class="timeline-marker" aria-hidden="true"><span class="timeline-dot"></span></div>
                    <div class="process-copy">
                        <span class="step-label">03 • <span>    La mise en pratique</span></span>
                        <h3>Préparer vos dossiers</h3>
                        <p>Nous vous aidons à organiser les documents nécessaires et à vérifier les démarches et les délais de candidature.</p>
                    </div>
                </li>
                <li class="step process-step">
                    <div class="timeline-marker" aria-hidden="true"><span class="timeline-dot"></span></div>
                    <div class="process-copy">
                        <span class="step-label">04 • <span>    La prochaine étape</span></span>
                        <h3>Avancer vers l’inscription</h3>
                        <p>Nous vous aidons à comprendre les réponses des établissements et à préparer les formalités qui suivent.</p>
                    </div>
                </li>
            </ol>
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

        <section id="actualites" class="official-updates" aria-labelledby="updates-title">
            <div class="official-updates-copy">
                <span class="section-eyebrow">Le compte officiel · @babaalitawjih</span>
                <h2 id="updates-title">Gardez le fil de votre orientation.</h2>
                <p>Retrouvez les publications de BABAALI TAWJIH sur Instagram : orientation, écoles supérieures et informations sur les admissions.</p>
                <p lang="ar" dir="rtl">اختيار المسار المناسب بثقة، ومرافقة من البداية حتى القبول.</p>
            </div>
            <div class="official-updates-action">
                <span class="official-updates-icon" aria-hidden="true"><i class="fa-brands fa-instagram"></i></span>
                <a href="https://www.instagram.com/babaalitawjih/" target="_blank" rel="noopener noreferrer">Suivre @babaalitawjih <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                <span>Les publications s’ouvrent sur Instagram.</span>
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
            <p lang="ar" dir="rtl">نوجهوك للطريق الصحيح</p>
            <br>
            <div class="social-media">
                <a target="_blank" rel="noopener noreferrer" aria-label="Facebook" href="https://www.facebook.com/profile.php?id=61565968660252">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path d="M14 21v-8h3l.5-4H14V7c0-1.2.4-2 2-2h2V1.5A25 25 0 0 0 15 1c-3 0-5 1.8-5 5v3H7v4h3v8z"/></svg>
                </a>
                <a target="_blank" rel="noopener noreferrer" aria-label="Instagram" href="https://www.instagram.com/babaalitawjih/">
                    <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm5 3a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm5.5-3.5a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
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
