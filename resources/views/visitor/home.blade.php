@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    *, *::before, *::after { box-sizing: border-box; }

    :root {
        --navy: #0b1628;
        --navy-mid: #122240;
        --blue: #1a6eff;
        --blue-light: #4d93ff;
        --gold: #c9a84c;
        --gold-light: #e4c97c;
        --white: #ffffff;
        --off-white: #f4f6fa;
        --muted: #8898b3;
        --border: rgba(255,255,255,0.08);
    }

    body { font-family: 'Outfit', sans-serif; background: #f4f6fa; }

    /* ─── HERO FULL WIDTH BREAKOUT ──────────────────── */
    .hero-breakout {
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        margin-top: calc(-40px - 3rem);
    }

    /* ─── HERO ─────────────────────────────────────── */
    .hero {
        position: relative;
        min-height: 92vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        background: var(--navy);
    }
    .hero-bg {
        position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2070') center/cover no-repeat;
        opacity: 0.18;
        transform: scale(1.05);
        animation: slowZoom 20s ease-in-out infinite alternate;
    }
    @keyframes slowZoom { to { transform: scale(1.12); } }

    .hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(11,22,40,0.97) 40%, rgba(26,110,255,0.15) 100%);
    }

    .hero-grid {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(26,110,255,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(26,110,255,0.04) 1px, transparent 1px);
        background-size: 60px 60px;
    }

    .hero-blob {
        position: absolute;
        width: 600px; height: 600px;
        right: -100px; top: -100px;
        background: radial-gradient(circle, rgba(26,110,255,0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: pulse 6s ease-in-out infinite;
    }
    @keyframes pulse { 0%,100% { transform: scale(1); opacity: 0.8; } 50% { transform: scale(1.1); opacity: 1; } }

    .hero-content {
        position: relative; z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .hero-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(201,168,76,0.12);
        border: 1px solid rgba(201,168,76,0.3);
        color: var(--gold-light);
        font-size: 0.78rem;
        font-weight: 500;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 1.5rem;
        animation: fadeUp 0.6s ease both;
    }
    .hero-tag::before {
        content: '';
        width: 6px; height: 6px;
        background: var(--gold);
        border-radius: 50%;
        animation: blink 1.5s infinite;
    }
    @keyframes blink { 0%,100% { opacity: 1; } 50% { opacity: 0.2; } }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(3rem, 5vw, 5.5rem);
        font-weight: 700;
        line-height: 1.05;
        color: var(--blue);
        margin-bottom: 1.5rem;
        animation: fadeUp 0.6s 0.1s ease both;
    }
    .hero-title span {
        color: var(--blue);
        -webkit-text-stroke: 0px;
    }

    .hero-sub {
        color: var(--muted);
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 2.5rem;
        animation: fadeUp 0.6s 0.2s ease both;
    }

    .hero-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--blue);
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 16px 32px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
        animation: fadeUp 0.6s 0.3s ease both;
        box-shadow: 0 0 30px rgba(26,110,255,0.4);
    }
    .hero-cta:hover {
        background: var(--blue-light);
        transform: translateY(-2px);
        box-shadow: 0 0 50px rgba(26,110,255,0.6);
        color: white;
    }

    .hero-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        animation: fadeUp 0.6s 0.4s ease both;
    }
    .stat-card {
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
        transition: all 0.3s;
    }
    .stat-card:first-child {
        grid-column: 1 / -1;
        background: rgba(26,110,255,0.08);
        border-color: rgba(26,110,255,0.25);
    }
    .stat-card:hover {
        border-color: rgba(26,110,255,0.4);
        background: rgba(26,110,255,0.1);
        transform: translateY(-3px);
    }
    .stat-icon {
        width: 40px; height: 40px;
        background: rgba(26,110,255,0.15);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: var(--blue-light);
        font-size: 1rem;
        margin-bottom: 1rem;
    }
    .stat-card h4 {
        color: white;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 700;
        margin: 0 0 4px;
    }
    .stat-card p { color: var(--muted); font-size: 0.8rem; margin: 0; }

    .scroll-hint {
        position: absolute;
        bottom: 2rem; left: 50%;
        transform: translateX(-50%);
        z-index: 2;
        display: flex; flex-direction: column; align-items: center; gap: 8px;
        color: var(--muted);
        font-size: 0.75rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }
    .scroll-line {
        width: 1px; height: 50px;
        background: linear-gradient(to bottom, transparent, var(--blue));
        animation: scrollDown 1.5s ease-in-out infinite;
    }
    @keyframes scrollDown { 0% { opacity: 0; transform: scaleY(0); transform-origin: top; } 50% { opacity: 1; transform: scaleY(1); } 100% { opacity: 0; } }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ─── SECTION COMMONS ───────────────────────────── */
    .section { padding: 6rem 0; }
    .container-iga { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

    .label-tag {
        display: inline-block;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--blue);
        margin-bottom: 1rem;
    }

    .section-heading {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 700;
        color: var(--navy);
        line-height: 1.15;
        margin-bottom: 1rem;
    }

    /* ─── ABOUT ─────────────────────────────────────── */
    .about-section { background: white; }
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }

    .about-img-wrap { position: relative; }
    .about-img-wrap img {
        width: 100%;
        border-radius: 4px;
        display: block;
        position: relative;
        z-index: 1;
    }
    .about-img-wrap::before {
        content: '';
        position: absolute;
        inset: -16px -16px 16px 16px;
        border: 2px solid var(--blue);
        border-radius: 4px;
        opacity: 0.25;
        z-index: 0;
    }
    .about-img-wrap::after {
        content: '';
        position: absolute;
        bottom: -24px; right: -24px;
        width: 140px; height: 140px;
        background: var(--gold);
        opacity: 0.08;
        border-radius: 4px;
        z-index: 0;
    }

    .about-body p { color: #4a5a72; line-height: 1.85; margin-bottom: 1rem; font-size: 1.02rem; }
    .about-quote {
        border-left: 3px solid var(--blue);
        padding-left: 1.25rem;
        color: var(--navy-mid);
        font-weight: 500;
        font-style: italic;
        margin: 1.5rem 0;
        font-size: 1.05rem;
        line-height: 1.7;
    }

    /* ─── ACTIVITÉS ─────────────────────────────────── */
    .activites-section { background: var(--off-white); }

    .activites-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-top: 3rem;
    }

    .act-card {
        background: white;
        border: 1px solid #e8edf5;
        border-radius: 12px;
        padding: 2rem;
        transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
        overflow: hidden;
        cursor: default;
    }
    .act-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 3px;
        background: linear-gradient(90deg, var(--blue), var(--blue-light));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }
    .act-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px rgba(26,110,255,0.1);
        border-color: rgba(26,110,255,0.2);
    }
    .act-card:hover::before { transform: scaleX(1); }

    /* 4 cartes : disposition 3+1 centrée */
    .act-card:nth-child(4) { grid-column: 2 / 3; }

    .act-icon {
        width: 52px; height: 52px;
        background: rgba(26,110,255,0.08);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: var(--blue);
        font-size: 1.2rem;
        margin-bottom: 1.4rem;
        transition: all 0.3s;
    }
    .act-card:hover .act-icon {
        background: var(--blue);
        color: white;
    }
    .act-card h5 {
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 0.6rem;
        font-size: 1rem;
    }
    .act-card p { color: var(--muted); font-size: 0.88rem; line-height: 1.7; margin: 0; }

    /* ─── BANNER SLIDER FULL WIDTH ──────────────────── */
    .banner-breakout {
        width: 100vw;
        position: relative;
        left: 50%;
        margin-left: -50vw;
        margin-bottom: calc(-3rem - 40px);
    }

    .banner-slider {
        position: relative;
        height: 520px;
        overflow: hidden;
        background: var(--navy);
    }

    .bslide {
        position: absolute; inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.8s ease;
        pointer-events: none;
    }
    .bslide.active { opacity: 1; pointer-events: auto; }

    .bslide-immo {
        background:
            linear-gradient(135deg, rgba(11,22,40,0.92) 0%, rgba(26,110,255,0.18) 100%),
            url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=2073') center/cover no-repeat;
    }
    .bslide-real {
        background:
            linear-gradient(135deg, rgba(11,22,40,0.92) 0%, rgba(201,168,76,0.18) 100%),
            url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070') center/cover no-repeat;
    }

    .bslide::before {
        content: '';
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
        background-size: 60px 60px;
        pointer-events: none;
    }

    .bslide-inner {
        position: relative; z-index: 1;
        text-align: center;
        padding: 2rem;
        max-width: 720px;
        animation: none;
    }
    .bslide.active .bslide-inner { animation: fadeUp 0.7s ease both; }

    .bslide-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.7);
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 1.5rem;
    }

    .bslide-immo .bslide-tag { border-color: rgba(26,110,255,0.4); color: var(--blue-light); }
    .bslide-real .bslide-tag { border-color: rgba(201,168,76,0.4); color: var(--gold-light); }

    .bslide-inner h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2.2rem, 4vw, 3.8rem);
        font-weight: 700;
        color: white;
        line-height: 1.1;
        margin-bottom: 1rem;
    }
    .bslide-inner p {
        color: rgba(255,255,255,0.6);
        font-size: 1.02rem;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .bslide-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 14px 32px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }
    .bslide-immo .bslide-btn { background: var(--blue); color: white; box-shadow: 0 0 30px rgba(26,110,255,0.4); }
    .bslide-immo .bslide-btn:hover { background: var(--blue-light); transform: translateY(-2px); box-shadow: 0 0 50px rgba(26,110,255,0.6); color: white; }
    .bslide-real .bslide-btn { background: var(--gold); color: var(--navy); box-shadow: 0 0 30px rgba(201,168,76,0.3); }
    .bslide-real .bslide-btn:hover { background: var(--gold-light); transform: translateY(-2px); box-shadow: 0 0 50px rgba(201,168,76,0.5); color: var(--navy); }

    .bslider-dots {
        position: absolute;
        bottom: 1.8rem; left: 50%;
        transform: translateX(-50%);
        display: flex; gap: 10px;
        z-index: 10;
    }
    .bdot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        border: none; cursor: pointer;
        transition: all 0.3s;
        padding: 0;
    }
    .bdot.active { background: white; width: 28px; border-radius: 4px; }

    .bslider-arrow {
        position: absolute; top: 50%; z-index: 10;
        transform: translateY(-50%);
        width: 44px; height: 44px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 50%;
        color: white; font-size: 0.9rem;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        backdrop-filter: blur(6px);
    }
    .bslider-arrow:hover { background: rgba(255,255,255,0.2); }
    .bslider-arrow.prev { left: 2rem; }
    .bslider-arrow.next { right: 2rem; }

    .bslider-progress {
        position: absolute;
        bottom: 0; left: 0;
        height: 3px;
        background: var(--blue);
        z-index: 10;
        animation: progressBar 5s linear infinite;
    }
    @keyframes progressBar { from { width: 0; } to { width: 100%; } }

    /* ─── RESPONSIVE ────────────────────────────────── */
    @media (max-width: 900px) {
        .hero-content { grid-template-columns: 1fr; gap: 2rem; }
        .hero-stats { grid-template-columns: 1fr 1fr; }
        .about-grid { grid-template-columns: 1fr; }
        .about-img-wrap { order: -1; }
        .activites-grid { grid-template-columns: 1fr 1fr; }
        .act-card:nth-child(4) { grid-column: auto; }
    }
    @media (max-width: 600px) {
        .hero { min-height: 100svh; }
        .hero-content { padding: 5rem 1.25rem 2rem; }
        .hero-stats { grid-template-columns: 1fr; }
        .stat-card:first-child { grid-column: auto; }
        .activites-grid { grid-template-columns: 1fr; }
        .immo-inner { padding: 3rem 1.5rem; }
    }
</style>

{{-- ─── HERO ──────────────────────────────────────────── --}}
<div class="hero-breakout">
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-grid"></div>
    <div class="hero-blob"></div>

    <div class="hero-content">
        <div>
            <div class="hero-tag">Expertise & Construction</div>
            <h1 class="hero-title">IGA Plus <span>Sarl</span></h1>
            <p class="hero-sub">
                BTP & Génie Civil — Expertise Topographique, Foncière & Immobilière — AEP & Forage — Import/Export
            </p>
            <a href="{{ route('biens') }}" class="hero-cta">
                <i class="fas fa-home"></i> Consulter nos biens immobiliers
            </a>
        </div>

        <div class="hero-stats">
            {{-- Carte 1 : BTP + Génie Civil + AEP & Forage combinés --}}
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-hard-hat"></i></div>
                <h4>BTP, Génie Civil & AEP / Forage</h4>
                <p>Construction, infrastructures, adduction d'eau potable et forages</p>
            </div>
            {{-- Carte 2 : Expertise topographique, foncière et immobilière --}}
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-drafting-compass"></i></div>
                <h4>Expertise Topographique, Foncière & Immobilière</h4>
                <p>Levés précis, délimitations foncières et expertise immobilière</p>
            </div>
            {{-- Carte 3 : Import / Export --}}
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-ship"></i></div>
                <h4>Import / Export</h4>
                <p>Logistique et commerce international</p>
            </div>
        </div>
    </div>

    <div class="scroll-hint">
        <span>Découvrir</span>
        <div class="scroll-line"></div>
    </div>
</section>
</div>

{{-- ─── QUI SOMMES-NOUS ───────────────────────────────── --}}
<section class="section about-section">
    <div class="container-iga">
        <div class="about-grid">
            <div class="about-img-wrap">
                <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070" alt="IGA Plus Expertise">
            </div>
            <div class="about-body">
                <div class="label-tag">À propos</div>
                <h2 class="section-heading">Qui sommes-nous ?</h2>
                <p>
                    IGA Plus Sarl est une entreprise spécialisée dans les Bâtiments et Travaux Publics (BTP),
                    l'expertise topographique, foncière et immobilière.
                </p>
                <p>
                    Nous intervenons également dans les projets d'AEP & forage, le génie civil,
                    ainsi que les opérations d'import-export.
                </p>
                <blockquote class="about-quote">
                    Grâce à notre expertise technique et notre savoir-faire, nous accompagnons nos clients
                    dans la réalisation de projets durables, fiables et conformes aux normes en vigueur.
                </blockquote>
            </div>
        </div>
    </div>
</section>

{{-- ─── DOMAINES D'ACTIVITÉ ──────────────────────────── --}}
<section class="section activites-section">
    <div class="container-iga">
        <div class="label-tag" style="display:block; text-align:center;">Ce que nous faisons</div>
        <h2 class="section-heading" style="text-align:center;">Nos Domaines d'Activité</h2>

        <div class="activites-grid">
            @php
            $activites = [
                ['BTP, Génie Civil & AEP / Forage', 'Construction, réhabilitation, infrastructures publiques, adduction d\'eau potable et réalisation de forages.', 'fa-hard-hat'],
                ['Expertise Topographique', 'Études techniques, levés topographiques, délimitations foncières et analyses agricoles.', 'fa-drafting-compass'],
                ['Expertise Foncière & Immobilière', 'Évaluation, délimitation et expertise de biens fonciers et immobiliers pour particuliers et professionnels.', 'fa-landmark'],
                ['Import – Export', 'Solutions logistiques et commerciales pour l\'importation et l\'exportation de produits.', 'fa-ship'],
            ];
            @endphp

            @foreach($activites as $item)
            <div class="act-card">
                <div class="act-icon">
                    <i class="fas {{ $item[2] }}"></i>
                </div>
                <h5>{{ $item[0] }}</h5>
                <p>{{ $item[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ─── BANNER SLIDER PLEIN LARGEUR ───────────────────── --}}
<div class="banner-breakout">
    <div class="banner-slider" id="bannerSlider">

        {{-- Slide 1 : Immobilier --}}
        <div class="bslide bslide-immo active">
            <div class="bslide-inner">
                <div class="bslide-tag"><i class="fas fa-home"></i> Immobilier</div>
                <h2>Nos Biens Immobiliers</h2>
                <p>En complément de nos activités techniques, nous proposons des biens immobiliers sélectionnés avec rigueur pour répondre aux besoins des particuliers et investisseurs.</p>
                <a href="{{ route('biens') }}" class="bslide-btn">
                    Voir tous nos biens <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Slide 2 : Réalisations --}}
        <div class="bslide bslide-real">
            <div class="bslide-inner">
                <div class="bslide-tag"><i class="fas fa-images"></i> Réalisations</div>
                <h2>Nos Réalisations</h2>
                <p>Découvrez nos projets achevés : constructions, infrastructures, forages et expertises topographiques réalisés avec rigueur et savoir-faire sur le terrain.</p>
                <a href="{{ route('realisations') }}" class="bslide-btn">
                    Voir nos réalisations <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Arrows --}}
        <button class="bslider-arrow prev" onclick="bannerSlide(-1)"><i class="fas fa-chevron-left"></i></button>
        <button class="bslider-arrow next" onclick="bannerSlide(1)"><i class="fas fa-chevron-right"></i></button>

        {{-- Dots --}}
        <div class="bslider-dots">
            <button class="bdot active" onclick="bannerGoTo(0)"></button>
            <button class="bdot" onclick="bannerGoTo(1)"></button>
        </div>

        {{-- Progress --}}
        <div class="bslider-progress" id="bProgress"></div>
    </div>
</div>

<script>
    (function() {
        const slides = document.querySelectorAll('.bslide');
        const dots   = document.querySelectorAll('.bdot');
        const prog   = document.getElementById('bProgress');
        let current  = 0;
        let timer;

        function goTo(n) {
            slides[current].classList.remove('active');
            dots[current].classList.remove('active');
            current = (n + slides.length) % slides.length;
            slides[current].classList.add('active');
            dots[current].classList.add('active');
            prog.style.animation = 'none';
            void prog.offsetWidth;
            prog.style.animation = 'progressBar 5s linear infinite';
            clearInterval(timer);
            timer = setInterval(() => goTo(current + 1), 5000);
        }

        window.bannerSlide = (dir) => goTo(current + dir);
        window.bannerGoTo  = (n)   => goTo(n);

        timer = setInterval(() => goTo(current + 1), 5000);
    })();
</script>

@endsection