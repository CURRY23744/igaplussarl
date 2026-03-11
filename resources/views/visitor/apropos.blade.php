@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
    :root {
        --navy: #0b1628;
        --gold: #c9a84c;
        --gold-light: #e8c97a;
        --off-white: #f8fafc;
        --text-muted: #64748b;
        --border: #e2e8f0;
    }

    body { font-family: 'DM Sans', sans-serif; background: var(--off-white); }

    /* ─── HERO ─── */
    .hero-header {
        width: 100vw; position: relative; left: 50%; margin-left: -50vw;
        margin-top: calc(-40px - 3rem); margin-bottom: 5rem;
        height: 420px; background: var(--navy); overflow: hidden;
        display: flex; align-items: center; justify-content: center;
    }
    .hero-bg-pattern {
        position: absolute; inset: 0;
        background-image:
            radial-gradient(circle at 20% 50%, rgba(201,168,76,0.08) 0%, transparent 60%),
            radial-gradient(circle at 80% 20%, rgba(201,168,76,0.06) 0%, transparent 50%);
    }
    .hero-grid-lines {
        position: absolute; inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
        background-size: 60px 60px;
    }
    .hero-content { position: relative; text-align: center; z-index: 2; }
    .hero-eyebrow {
        font-size: 0.7rem; font-weight: 600; letter-spacing: 5px;
        text-transform: uppercase; color: var(--gold); margin-bottom: 20px;
        display: flex; align-items: center; justify-content: center; gap: 12px;
    }
    .hero-eyebrow::before, .hero-eyebrow::after {
        content: ''; width: 40px; height: 1px; background: var(--gold); opacity: 0.6;
    }
    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        font-weight: 800; color: white; line-height: 1.1; margin: 0;
    }
    .hero-title span { color: var(--gold); }
    .hero-subtitle {
        font-size: 0.95rem; color: rgba(255,255,255,0.45);
        margin-top: 20px; font-weight: 300; letter-spacing: 1px;
    }

    /* ─── SECTION PRÉSENTATION ─── */
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
        margin-bottom: 6rem;
    }

    .about-img-col { position: relative; }

    .about-img-frame { position: relative; border-radius: 0; }

    .about-img-frame img {
        width: 100%; height: 480px;
        object-fit: cover; display: block;
    }

    .about-img-frame::before {
        content: '';
        position: absolute;
        top: -16px; left: -16px;
        right: 16px; bottom: 16px;
        border: 2px solid var(--gold);
        opacity: 0.4; z-index: 0; pointer-events: none;
    }

    .about-img-frame::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(11,22,40,0.3) 0%, transparent 50%);
    }

    .about-badge {
        position: absolute;
        bottom: -20px; right: -20px;
        background: var(--navy);
        border: 1px solid rgba(201,168,76,0.3);
        padding: 20px 28px; z-index: 2; text-align: center;
    }
    .about-badge strong {
        display: block;
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem; font-weight: 800;
        color: var(--gold); line-height: 1;
    }
    .about-badge span {
        font-size: 0.65rem; font-weight: 600;
        letter-spacing: 3px; text-transform: uppercase;
        color: rgba(255,255,255,0.5);
    }

    .section-eyebrow {
        font-size: 0.65rem; font-weight: 700; letter-spacing: 5px;
        text-transform: uppercase; color: var(--gold);
        margin-bottom: 16px; display: block;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 3vw, 2.8rem);
        font-weight: 800; color: var(--navy);
        line-height: 1.2; margin-bottom: 24px;
    }

    .section-divider {
        width: 40px; height: 3px;
        background: var(--gold); margin-bottom: 28px;
    }

    .section-desc {
        font-size: 1rem; color: var(--text-muted);
        line-height: 1.9; margin-bottom: 0;
    }

    /* ─── VALEURS ─── */
    .values-band {
        width: 100vw; position: relative;
        left: 50%; margin-left: -50vw;
        background: var(--navy);
        padding: 80px 0; margin-bottom: 6rem; overflow: hidden;
    }
    .values-band::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse at 50% 0%, rgba(201,168,76,0.08) 0%, transparent 60%);
    }

    .values-inner {
        max-width: 1200px; margin: 0 auto; padding: 0 40px; position: relative;
    }

    .values-header { text-align: center; margin-bottom: 60px; }
    .values-header .section-eyebrow { justify-content: center; display: flex; }
    .values-header .section-title { color: white; }

    .values-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px;
    }

    .value-item {
        padding: 40px 35px;
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.06);
        transition: background 0.3s; text-align: center;
    }
    .value-item:hover { background: rgba(201,168,76,0.06); }

    .value-icon {
        width: 52px; height: 52px;
        border: 1px solid rgba(201,168,76,0.3);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 1.2rem; color: var(--gold);
    }

    .value-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem; font-weight: 700; color: white; margin-bottom: 12px;
    }

    .value-desc { font-size: 0.85rem; color: rgba(255,255,255,0.4); line-height: 1.7; }

    /* ─── CONTACT ─── */
    .contact-section { margin-bottom: 0; }

    .contact-grid {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 60px; align-items: start;
    }

    .contact-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        font-weight: 800; color: var(--navy);
        line-height: 1.2; margin-bottom: 16px;
    }

    .contact-sub {
        font-size: 0.95rem; color: var(--text-muted);
        line-height: 1.8; margin-bottom: 36px;
    }

    .contact-items { display: flex; flex-direction: column; }

    .contact-item {
        display: flex; align-items: center; gap: 18px;
        padding: 14px 0;
        border-bottom: 1px solid var(--border);
        text-decoration: none;
        transition: gap 0.25s;
    }
    .contact-item:last-child { border-bottom: none; }
    .contact-item:hover { gap: 24px; color: inherit; }

    .contact-item-icon {
        width: 42px; height: 42px; flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; border-radius: 50%;
    }

    .contact-item-label {
        font-size: 0.6rem; font-weight: 700; letter-spacing: 3px;
        text-transform: uppercase; color: var(--text-muted); margin-bottom: 3px;
    }

    .contact-item-val {
        font-size: 0.95rem; font-weight: 600; color: var(--navy);
    }

    .socials-row { display: flex; gap: 12px; margin-top: 28px; }

    .social-btn {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 12px 20px;
        border: 1.5px solid var(--border);
        font-size: 0.75rem; font-weight: 700;
        letter-spacing: 1px; text-transform: uppercase;
        color: var(--navy); text-decoration: none; transition: all 0.25s;
    }
    .social-btn:hover { background: var(--navy); border-color: var(--navy); color: white; }
    .social-btn i { font-size: 1rem; }

    /* Horaires */
    .hours-box { background: var(--navy); padding: 40px; height: 100%; }

    .hours-eyebrow {
        font-size: 0.6rem; font-weight: 700; letter-spacing: 4px;
        text-transform: uppercase; color: var(--gold); margin-bottom: 24px; display: block;
    }

    .hours-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem; font-weight: 700; color: white; margin-bottom: 28px;
    }

    /* Badge 24h/24 */
    .hours-always-open {
        display: flex; align-items: center; gap: 16px;
        padding: 20px 0; border-bottom: 1px solid rgba(255,255,255,0.07);
    }
    .hours-always-open:last-child { border-bottom: none; }

    .hours-open-icon {
        width: 44px; height: 44px; flex-shrink: 0;
        border: 1px solid rgba(201,168,76,0.3);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; color: var(--gold);
    }

    .hours-open-label {
        font-size: 0.6rem; font-weight: 700; letter-spacing: 3px;
        text-transform: uppercase; color: rgba(255,255,255,0.4); margin-bottom: 4px;
    }
    .hours-open-val {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem; font-weight: 700; color: white; line-height: 1;
    }

    .hours-open-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(37,211,102,0.12);
        border: 1px solid rgba(37,211,102,0.25);
        border-radius: 50px; padding: 5px 14px; margin-top: 16px;
        font-size: 0.7rem; font-weight: 700; letter-spacing: 1px;
        text-transform: uppercase; color: #25d366;
    }
    .hours-open-badge::before {
        content: ''; width: 7px; height: 7px;
        background: #25d366; border-radius: 50%;
        animation: pulse-green 1.5s infinite;
    }
    @keyframes pulse-green {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.4; transform: scale(0.7); }
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 992px) {
        .about-grid { grid-template-columns: 1fr; gap: 40px; }
        .about-img-frame img { height: 320px; }
        .about-badge { bottom: -15px; right: 10px; }
        .values-grid { grid-template-columns: 1fr; gap: 2px; }
        .contact-grid { grid-template-columns: 1fr; gap: 40px; }
        .values-inner { padding: 0 20px; }
    }

    @media (max-width: 576px) {
        .socials-row { flex-direction: column; }
        .hours-box { padding: 28px 24px; }
    }
</style>

{{-- ─── HERO ─── --}}
<div class="hero-header">
    <div class="hero-bg-pattern"></div>
    <div class="hero-grid-lines"></div>
    <div class="hero-content">
        <div class="hero-eyebrow">IGA Plus Immobilier</div>
        <h1 class="hero-title">À <span>Propos</span></h1>
        <p class="hero-subtitle">Notre histoire, nos valeurs, notre engagement</p>
    </div>
</div>

@if($apropos)

<div class="container">

    {{-- ─── PRÉSENTATION ─── --}}
    <div class="about-grid">

        {{-- Image --}}
        <div class="about-img-col">
            <div class="about-img-frame">
                @if($apropos->image)
                    <img src="{{ asset('storage/' . $apropos->image) }}" alt="{{ $apropos->titre }}">
                @else
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800"
                         alt="IGA Plus Sarl">
                @endif
            </div>
            <div class="about-badge">
                <strong>{{ now()->year - 2015 }}+</strong>
                <span>Ans d'expertise</span>
            </div>
        </div>

        {{-- Texte --}}
        <div class="about-text-col">
            <span class="section-eyebrow">Qui sommes-nous</span>
            <h2 class="section-title">{{ $apropos->titre }}</h2>
            <div class="section-divider"></div>
            <p class="section-desc">{{ $apropos->description }}</p>
        </div>

    </div>

</div>

{{-- ─── VALEURS ─── --}}
<div class="values-band">
    <div class="values-inner">
        <div class="values-header">
            <span class="section-eyebrow">Ce qui nous définit</span>
            <h2 class="section-title">Nos valeurs fondamentales</h2>
        </div>
        <div class="values-grid">
            <div class="value-item">
                <div class="value-icon"><i class="fas fa-handshake"></i></div>
                <div class="value-title">Confiance</div>
                <p class="value-desc">Nous bâtissons des relations durables fondées sur la transparence et l'intégrité avec chacun de nos clients.</p>
            </div>
            <div class="value-item">
                <div class="value-icon"><i class="fas fa-medal"></i></div>
                <div class="value-title">Excellence</div>
                <p class="value-desc">Chaque projet est traité avec le plus grand soin, du conseil initial jusqu'à la livraison finale.</p>
            </div>
            <div class="value-item">
                <div class="value-icon"><i class="fas fa-lightbulb"></i></div>
                <div class="value-title">Innovation</div>
                <p class="value-desc">Nous adoptons les meilleures pratiques et technologies pour offrir des solutions immobilières modernes.</p>
            </div>
        </div>
    </div>
</div>

<div class="container contact-section">

    {{-- ─── CONTACT ─── --}}
    <div class="contact-grid mb-5">

        {{-- Coordonnées --}}
        <div>
            <span class="section-eyebrow">Nous contacter</span>
            <h2 class="contact-title">Parlons de<br>votre projet</h2>
            <p class="contact-sub">Notre équipe est disponible pour répondre à toutes vos questions et vous accompagner dans vos démarches immobilières.</p>

            <div class="contact-items">

                @if($apropos->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $apropos->whatsapp) }}"
                   target="_blank" class="contact-item">
                    <div class="contact-item-icon" style="background:rgba(37,211,102,0.1);color:#25d366;">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <div class="contact-item-label">WhatsApp</div>
                        <div class="contact-item-val">{{ $apropos->whatsapp }}</div>
                    </div>
                </a>
                @endif

                @if($apropos->email)
                <a href="mailto:{{ $apropos->email }}" class="contact-item">
                    <div class="contact-item-icon" style="background:rgba(59,124,255,0.1);color:#3b7cff;">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div class="contact-item-label">Email</div>
                        <div class="contact-item-val">{{ $apropos->email }}</div>
                    </div>
                </a>
                @endif

            </div>

            @if($apropos->facebook || $apropos->instagram)
            <div class="socials-row">
                @if($apropos->facebook)
                <a href="{{ $apropos->facebook }}" target="_blank" class="social-btn">
                    <i class="fab fa-facebook"></i> Facebook
                </a>
                @endif
                @if($apropos->instagram)
                <a href="{{ $apropos->instagram }}" target="_blank" class="social-btn">
                    <i class="fab fa-instagram"></i> Instagram
                </a>
                @endif
            </div>
            @endif
        </div>

        {{-- Horaires --}}
        <div class="hours-box">
            <span class="hours-eyebrow">Disponibilité</span>
            <h3 class="hours-title">Nos horaires d'ouverture</h3>

            <div class="hours-always-open">
                <div class="hours-open-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="hours-open-label">Tous les jours</div>
                    <div class="hours-open-val">24h / 24</div>
                </div>
            </div>

            <div class="hours-always-open">
                <div class="hours-open-icon"><i class="fas fa-calendar-check"></i></div>
                <div>
                    <div class="hours-open-label">Toute la semaine</div>
                    <div class="hours-open-val">7j / 7</div>
                </div>
            </div>

            <div class="hours-open-badge">
                Toujours disponible
            </div>
        </div>

    </div>

</div>

@else

<div class="container text-center py-5">
    <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
    <h4 class="text-muted">La section À propos n'est pas encore configurée.</h4>
</div>

@endif

@endsection

@section('before_footer')
<style>
    .cta-strip { background: #0b1628; position: relative; overflow: hidden; }
    .cta-strip::before {
        content: ''; position: absolute; inset: 0;
        background: radial-gradient(ellipse at 30% 50%, rgba(201,168,76,0.1) 0%, transparent 60%);
        pointer-events: none;
    }
    .cta-strip-inner {
        max-width: 1320px; margin: 0 auto; padding: 0 40px;
        display: grid; grid-template-columns: 1fr auto;
        align-items: stretch; min-height: 160px; position: relative;
    }
    .cta-left {
        display: flex; flex-direction: column; justify-content: center;
        padding: 40px 60px 40px 0;
        border-right: 1px solid rgba(255,255,255,0.07); gap: 6px;
    }
    .cta-left-eyebrow {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem; font-weight: 500; letter-spacing: 4px;
        text-transform: uppercase; color: rgba(201,168,76,0.6);
    }
    .cta-left-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 800; color: white; line-height: 1.2; margin: 0;
    }
    .cta-left-sub { font-size: 0.85rem; color: rgba(255,255,255,0.35); margin: 0; font-weight: 300; }
    .cta-right { display: flex; align-items: stretch; }
    .cta-num-block {
        display: flex; flex-direction: column; justify-content: center;
        align-items: flex-start; padding: 0 40px; gap: 4px;
        border-right: 1px solid rgba(255,255,255,0.07);
        text-decoration: none; transition: background 0.25s; min-width: 220px;
    }
    .cta-num-block:last-child { border-right: none; padding-right: 0; }
    .cta-num-block:hover { background: rgba(201,168,76,0.06); }
    .cta-num-label {
        font-family: 'DM Mono', monospace;
        font-size: 0.58rem; letter-spacing: 3px;
        text-transform: uppercase; color: rgba(255,255,255,0.3);
    }
    .cta-num-val {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem; font-weight: 700; color: white;
        white-space: nowrap; display: flex; align-items: center; gap: 10px;
    }
    .cta-num-val i { color: #25d366; font-size: 1rem; }
    .cta-num-arrow {
        font-size: 0.6rem; color: rgba(201,168,76,0.5); margin-top: 2px;
        transition: transform 0.25s, color 0.25s;
    }
    .cta-num-block:hover .cta-num-arrow { transform: translateX(4px); color: #c9a84c; }
    @media (max-width: 992px) {
        .cta-strip-inner { grid-template-columns: 1fr; min-height: auto; }
        .cta-left { padding: 40px 0 30px; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.07); text-align: center; align-items: center; }
        .cta-right { flex-direction: column; }
        .cta-num-block { padding: 20px 0; border-right: none; border-bottom: 1px solid rgba(255,255,255,0.07); min-width: unset; align-items: center; }
        .cta-num-block:last-child { border-bottom: none; }
    }
</style>
<div class="cta-strip">
    <div class="cta-strip-inner">
        <div class="cta-left">
            <span class="cta-left-eyebrow">Parlons de votre projet</span>
            <h2 class="cta-left-title">Votre projet, notre expertise</h2>
            <p class="cta-left-sub">Confiez-nous la réalisation de votre bien immobilier de rêve</p>
        </div>
        <div class="cta-right">
            <a href="https://wa.me/22890713335" target="_blank" class="cta-num-block">
                <span class="cta-num-label">Ligne 1</span>
                <span class="cta-num-val"><i class="fab fa-whatsapp"></i> +228 90 71 33 35</span>
                <span class="cta-num-arrow"><i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="https://wa.me/22892028989" target="_blank" class="cta-num-block">
                <span class="cta-num-label">Ligne 2</span>
                <span class="cta-num-val"><i class="fab fa-whatsapp"></i> +228 92 02 89 89</span>
                <span class="cta-num-arrow"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</div>
@endsection