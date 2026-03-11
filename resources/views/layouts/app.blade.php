<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'IGA Plus Sarl')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3b7cff;
            --primary-light: #6ba1ff;
            --primary-soft: #e8f0ff;
            --dark: #1e2a41;
            --gray: #5f6b7a;
            --light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #2d3a4f;
            background-color: #ffffff;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navigation */
        .navbar-custom {
            background: linear-gradient(135deg, var(--primary) 0%, #4a8cff 100%);
            padding: 15px 0;
            box-shadow: 0 4px 20px rgba(59, 124, 255, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
            color: white !important;
            position: relative;
            padding-bottom: 5px;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 40px; height: 3px;
            background: white;
            border-radius: 2px;
        }

        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0 8px;
            padding: 8px 0 !important;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            transform: translateX(-50%);
            width: 0; height: 2px;
            background: white;
            transition: width 0.3s ease;
        }

        .nav-link:hover::before,
        .nav-link.active::before { width: 80%; }

        .nav-link:hover {
            color: white !important;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: white !important;
            font-weight: 600;
        }

        main {
            flex: 1;
            animation: fadeIn 0.5s ease;
            padding: 40px 0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── FOOTER ─── */
        .footer-modern {
            background: linear-gradient(135deg, #1a2639 0%, #2a3650 100%);
            color: #e5e9f0;
            padding: 60px 0 30px;
            position: relative;
        }

        .footer-modern::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #ffd966, var(--primary));
        }

        .footer-title {
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 40px; height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }

        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a {
            color: #b4c1d9;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .footer-links a:hover { color: white; transform: translateX(5px); }
        .footer-links a i { font-size: 0.9rem; color: var(--primary); }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 15px;
            color: #b4c1d9;
        }
        .contact-item i { color: var(--primary); font-size: 1.2rem; margin-top: 3px; }

        .social-links { display: flex; gap: 15px; margin-top: 25px; }
        .social-link {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.2rem;
        }
        .social-link:hover {
            background: var(--primary);
            transform: translateY(-5px) scale(1.1);
        }

        .newsletter-form { display: flex; gap: 10px; margin-top: 20px; }
        .newsletter-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.05);
            border-radius: 8px;
            color: white;
            font-size: 0.9rem;
        }
        .newsletter-input::placeholder { color: #8a9bb5; }
        .newsletter-input:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255,255,255,0.1);
        }

        .newsletter-btn {
            padding: 12px 20px;
            background: var(--primary);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .newsletter-btn:hover { background: #2a5fe0; transform: translateY(-2px); }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 25px;
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .copyright { color: #8a9bb5; font-size: 0.9rem; }

        .footer-bottom-links { display: flex; gap: 20px; }
        .footer-bottom-links a {
            color: #b4c1d9; text-decoration: none;
            font-size: 0.9rem; transition: color 0.3s;
        }
        .footer-bottom-links a:hover { color: white; }

        .admin-btn {
            background: rgba(255,255,255,0.1);
            color: white !important;
            padding: 8px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .admin-btn:hover {
            background: var(--primary);
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 124, 255, 0.3);
        }

        @media (max-width: 991px) {
            /* Supprime la barre de soulignement sous les liens en mode hamburger */
            .nav-link::before { display: none; }

            /* Remplace par un fond subtil pour indiquer le lien actif */
            .nav-link.active {
                background: rgba(255,255,255,0.15);
                border-radius: 8px;
                padding: 8px 12px !important;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand { font-size: 1.3rem; }
            .footer-bottom { flex-direction: column; text-align: center; }
            .newsletter-form { flex-direction: column; }
            .footer-bottom-links { justify-content: center; }
            main { padding: 20px 0; }
        }
    </style>
</head>
<body>

<header class="navbar-custom">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark p-0">
            <a class="navbar-brand" href="{{ route('home') }}">
                IGA Plus Sarl
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('biens') ? 'active' : '' }}" href="{{ route('biens') }}">
                            Biens
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('realisations') ? 'active' : '' }}" href="{{ route('realisations') }}">
                            Réalisations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('apropos') ? 'active' : '' }}" href="{{ route('apropos') }}">
                            À propos
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

<main class="container my-5">
    @yield('content')
</main>

{{-- ← Slot pour les sections pleine largeur avant le footer --}}
@yield('before_footer')

<footer class="footer-modern">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4">
                <h5 class="footer-title">IGA Plus Sarl U</h5>
                <p class="mb-4" style="color: #b4c1d9; line-height: 1.8;">
                    Votre partenaire de confiance dans les domaines du BTP,
                    de l'expertise topographique et de l'immobilier.
                    Expertise, professionnalisme et accompagnement personnalisé.
                </p>
                {{-- <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                </div> --}}
            </div>

            <div class="col-lg-2">
                <h5 class="footer-title">Liens</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right"></i>Accueil</a></li>
                    <li><a href="{{ route('biens') }}"><i class="fas fa-chevron-right"></i>Nos biens</a></li>
                    <li><a href="{{ route('realisations') }}"><i class="fas fa-chevron-right"></i>Réalisations</a></li>
                    <li><a href="{{ route('apropos') }}"><i class="fas fa-chevron-right"></i>À propos</a></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h5 class="footer-title">Contact</h5>
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <div>+228 90 71 33 35</div>
                        <div>+228 92 02 89 89</div>
                    </div>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span><!--email_off-->igaplus.ingrak@gmail.com<!--/email_off--></span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Ouvert 24/24 et 7j/7</span>
                </div>
            </div>

            <div class="col-lg-3">
                <h5 class="footer-title">Newsletter</h5>
                <p style="color: #b4c1d9; font-size: 0.9rem; margin-bottom: 15px;">
                    Recevez nos dernières offres et actualités
                </p>
                <form class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Votre email">
                    <button type="submit" class="newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
                <div class="mt-4">
                    <a href="{{ route('admin.login') }}" class="admin-btn">
                        <i class="fas fa-lock me-2"></i>Espace Admin
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="copyright">
                © {{ date('Y') }} IGA Plus Sarl U. Tous droits réservés.
            </div>
            <div class="footer-bottom-links">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
                <a href="#">CGU</a>
            </div>
        </div>
    </div>
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>