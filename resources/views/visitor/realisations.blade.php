@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,600&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
    .hero-stat {
        display: inline-flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(201,168,76,0.2);
        border-radius: 50px; padding: 10px 25px; margin-top: 30px;
        color: rgba(255,255,255,0.7); font-size: 0.85rem;
    }
    .hero-stat strong { color: var(--gold); font-size: 1.1rem; }

    /* ─── LISTE ÉDITORIALE ─── */
    .list-header {
        display: grid;
        grid-template-columns: 60px 1fr 180px 120px 140px;
        padding: 0 0 12px 0;
        border-bottom: 2px solid var(--navy);
        gap: 24px;
    }
    .list-header span {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem; font-weight: 500;
        letter-spacing: 3px; text-transform: uppercase;
        color: var(--text-muted);
    }

    .proj-row {
        display: grid;
        grid-template-columns: 60px 1fr 180px 120px 140px;
        gap: 24px;
        align-items: center;
        padding: 24px 0;
        border-bottom: 1px solid var(--border);
        cursor: pointer;
        transition: background 0.3s;
        text-decoration: none;
        color: inherit;
    }
    .proj-row:hover { background: rgba(11,22,40,0.02); }

    .proj-num {
        font-family: 'DM Mono', monospace;
        font-size: 0.75rem; color: rgba(201,168,76,0.5);
        font-weight: 500; letter-spacing: 1px;
    }
    .proj-row:hover .proj-num { color: var(--gold); }

    .proj-main { display: flex; flex-direction: column; gap: 6px; }
    .proj-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.55rem; font-weight: 700;
        color: var(--navy); line-height: 1.2; transition: color 0.3s;
    }
    .proj-row:hover .proj-name { color: #000; }
    .proj-excerpt {
        font-size: 0.82rem; color: var(--text-muted); line-height: 1.5;
        display: -webkit-box; -webkit-line-clamp: 1;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .proj-doc-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 0.7rem; color: var(--gold);
        font-family: 'DM Mono', monospace;
        margin-top: 4px;
    }

    .proj-thumb-placeholder {
        width: 180px; height: 110px;
        background: #e8edf4;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border);
    }
    .proj-thumb-placeholder i { color: #b0bec5; font-size: 1.5rem; }
    .proj-thumb { width: 180px; height: 110px; object-fit: cover; border: none; }

    .proj-year {
        font-family: 'DM Mono', monospace;
        font-size: 0.78rem; color: var(--text-muted); font-weight: 400;
    }

    .proj-cta {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 0.62rem; font-weight: 700;
        letter-spacing: 1px; text-transform: uppercase;
        color: var(--navy); background: transparent;
        border: 1.5px solid var(--navy); padding: 8px 12px;
        transition: background 0.25s, color 0.25s, border-color 0.25s;
        white-space: nowrap; width: fit-content;
    }
    .proj-row:hover .proj-cta {
        background: var(--gold); border-color: var(--gold); color: var(--navy);
    }
    .proj-cta i { transition: transform 0.3s; }
    .proj-row:hover .proj-cta i { transform: translateX(4px); }

    /* ─── MODAL ─── */
    .modal-luxe .modal-content {
        border: none;
        border-radius: 0;
        overflow: hidden;
    }
    .modal-luxe .modal-dialog {
        max-width: 1100px;
        margin: 10px auto;
    }
    .modal-gallery-col {
        background: #0f1e35;
        padding: 0;
        position: relative;
    }
    .main-photo { width: 100%; height: 420px; object-fit: cover; display: block; }

    .modal-no-photo {
        width: 100%; height: 420px;
        background: #152238;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 12px;
    }
    .modal-no-photo i { color: rgba(255,255,255,0.1); font-size: 3rem; }
    .modal-no-photo span { color: rgba(255,255,255,0.2); font-size: 0.75rem; letter-spacing: 2px; text-transform: uppercase; }

    .thumbs-row { display: flex; gap: 4px; padding: 4px; background: #0b1628; }
    .thumbs-row img {
        flex: 1; height: 80px; object-fit: cover; cursor: pointer;
        opacity: 0.55; transition: opacity 0.2s; border: 2px solid transparent;
    }
    .thumbs-row img.active, .thumbs-row img:hover { opacity: 1; border-color: var(--gold); }

    .modal-info-col {
        padding: 50px 45px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: white;
        overflow-y: auto;
    }
    .modal-tag {
        font-size: 0.62rem; font-weight: 700; letter-spacing: 4px;
        text-transform: uppercase; color: var(--gold); margin-bottom: 12px; display: block;
    }
    .modal-big-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem; font-weight: 800; color: var(--navy); line-height: 1.2; margin-bottom: 20px;
    }
    .modal-divider { width: 40px; height: 3px; background: var(--gold); margin-bottom: 24px; }
    .modal-desc { font-size: 0.9rem; color: var(--text-muted); line-height: 1.85; }
    .modal-meta { display: flex; flex-wrap: wrap; gap: 10px; margin: 20px 0; }
    .meta-pill {
        display: inline-flex; align-items: center; gap: 7px;
        background: var(--off-white); border: 1px solid var(--border);
        border-radius: 50px; padding: 7px 16px;
        font-size: 0.75rem; font-weight: 600; color: var(--navy);
    }
    .meta-pill i { color: var(--gold); font-size: 0.7rem; }

    /* ─── DOCUMENTS DANS LA MODAL ─── */
    .modal-docs-section { margin: 20px 0; }
    .modal-docs-title {
        font-family: 'DM Mono', monospace;
        font-size: 0.6rem; font-weight: 500; letter-spacing: 3px;
        text-transform: uppercase; color: var(--text-muted);
        margin-bottom: 10px; display: flex; align-items: center; gap: 8px;
    }
    .modal-docs-title::after {
        content: ''; flex: 1; height: 1px; background: var(--border);
    }
    .modal-doc-list { display: flex; flex-direction: column; gap: 6px; }
    .modal-doc-item {
        display: flex; align-items: center; gap: 10px;
        background: var(--off-white); border: 1px solid var(--border);
        border-radius: 6px; padding: 9px 12px;
        text-decoration: none; color: var(--navy);
        transition: border-color 0.2s, background 0.2s;
        font-size: 0.8rem;
    }
    .modal-doc-item:hover {
        border-color: var(--gold);
        background: rgba(201,168,76,0.04);
        color: var(--navy);
    }
    .modal-doc-icon {
        width: 30px; height: 30px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; flex-shrink: 0;
    }
    .modal-doc-icon.pdf   { background: rgba(220,53,69,0.1);   color: #dc3545; }
    .modal-doc-icon.word  { background: rgba(13,110,253,0.1);  color: #0d6efd; }
    .modal-doc-icon.excel { background: rgba(25,135,84,0.1);   color: #198754; }
    .modal-doc-icon.image { background: rgba(13,202,240,0.1);  color: #0dcaf0; }
    .modal-doc-icon.other { background: rgba(108,117,125,0.1); color: #6c757d; }
    .modal-doc-name {
        flex: 1; font-weight: 500; white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
    }
    .modal-doc-size { font-size: 0.7rem; color: var(--text-muted); flex-shrink: 0; }
    .modal-doc-dl {
        font-size: 0.7rem; color: var(--gold); flex-shrink: 0;
        transition: transform 0.2s;
    }
    .modal-doc-item:hover .modal-doc-dl { transform: translateY(-1px); }

    .btn-whatsapp {
        display: inline-flex; align-items: center; gap: 10px;
        background: #25d366; color: white; font-size: 0.75rem; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase; padding: 14px 28px;
        border-radius: 0; text-decoration: none; transition: background 0.2s, transform 0.2s;
    }
    .btn-whatsapp:hover { background: #1ebe5d; color: white; transform: translateY(-2px); }
    .btn-close-luxe {
        position: absolute; top: 16px; right: 16px; z-index: 10;
        width: 36px; height: 36px; border-radius: 50%;
        background: rgba(0,0,0,0.45); border: none; color: white; font-size: 0.85rem;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
    }
    .btn-close-luxe:hover { background: rgba(0,0,0,0.7); }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 992px) {
        .list-header { display: none; }
        .proj-row { grid-template-columns: 36px 1fr auto; gap: 12px 16px; }
        .proj-thumb, .proj-thumb-placeholder { display: none; }
        .proj-year { display: none; }

        /* Modal : empilement vertical + scroll complet */
        .modal-luxe .modal-dialog {
            margin: 0;
            max-width: 100%;
            min-height: 100vh;
        }
        .modal-luxe .modal-content {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .modal-luxe .row.g-0 {
            flex-direction: column;
            flex: 1;
        }
        .modal-gallery-col {
            width: 100% !important;
            max-width: 100% !important;
            flex: none;
        }
        /* Photo plus petite sur mobile */
        .main-photo,
        .modal-no-photo {
            height: 220px;
        }
        .thumbs-row img {
            height: 55px;
        }
        /* Zone info : prend tout l'espace restant et scroll */
        .modal-info-col {
            width: 100% !important;
            max-width: 100% !important;
            flex: 1;
            padding: 24px 20px 32px;
            overflow-y: auto;
            max-height: none;
        }
        .modal-big-title { font-size: 1.5rem; }
    }

    @media (max-width: 576px) {
        .proj-name { font-size: 1.15rem; }
    }
</style>

{{-- ─── HERO ─── --}}
<div class="hero-header">
    <div class="hero-bg-pattern"></div>
    <div class="hero-grid-lines"></div>
    <div class="hero-content">
        <div class="hero-eyebrow">IGA Plus Immobilier</div>
        <h1 class="hero-title">Nos <span>Réalisations</span></h1>
        <p class="hero-subtitle">Chaque projet, une histoire d'excellence</p>
        <div class="hero-stat">
            <strong>{{ $realisations->count() }}</strong> projets réalisés avec passion
        </div>
    </div>
</div>

{{-- ─── EN-TÊTE COLONNES ─── --}}
<div class="list-header">
    <span>N°</span>
    <span>Projet</span>
    <span>Aperçu</span>
    <span>Année</span>
    <span>Action</span>
</div>

{{-- ─── LISTE ─── --}}
@foreach($realisations as $index => $realisation)
    @php
        $firstImg   = $realisation->images->first();
        $hasPhoto   = $firstImg !== null;
        $imgUrl     = $hasPhoto ? asset('storage/' . $firstImg->image_path) : null;
        $hasDocs    = $realisation->documents && $realisation->documents->isNotEmpty();
    @endphp

    <div class="proj-row" data-modal-id="modal{{ $realisation->id }}">
        <div class="proj-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>

        <div class="proj-main">
            <div class="proj-name">{{ $realisation->titre }}</div>
            <div class="proj-excerpt">{{ $realisation->description }}</div>
            @if($hasDocs)
                <div class="proj-doc-badge">
                    <i class="fas fa-paperclip"></i>
                    {{ $realisation->documents->count() }} document{{ $realisation->documents->count() > 1 ? 's' : '' }} disponible{{ $realisation->documents->count() > 1 ? 's' : '' }}
                </div>
            @endif
        </div>

        @if($hasPhoto)
            <img src="{{ $imgUrl }}" class="proj-thumb" alt="{{ $realisation->titre }}">
        @else
            <div class="proj-thumb-placeholder">
                <i class="fas fa-image"></i>
            </div>
        @endif

        <div class="proj-year">{{ $realisation->created_at->format('Y') }}</div>
        <div class="proj-cta">Voir le projet <i class="fas fa-arrow-right"></i></div>
    </div>

    {{-- ─── MODAL ─── --}}
    <div class="modal fade modal-luxe" id="modal{{ $realisation->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="row g-0">

                    <div class="col-lg-7 modal-gallery-col">
                        <button class="btn-close-luxe" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>

                        @if($hasPhoto)
                            <img src="{{ $imgUrl }}"
                                 class="main-photo" id="mainPhoto{{ $realisation->id }}" alt="{{ $realisation->titre }}">
                            @if($realisation->images->count() > 1)
                                <div class="thumbs-row">
                                    @foreach($realisation->images->take(5) as $i => $img)
                                        <img src="{{ asset('storage/' . $img->image_path) }}"
                                             class="{{ $i === 0 ? 'active' : '' }}" alt="thumb"
                                             onclick="
                                                document.getElementById('mainPhoto{{ $realisation->id }}').src=this.src;
                                                this.closest('.thumbs-row').querySelectorAll('img').forEach(t=>t.classList.remove('active'));
                                                this.classList.add('active');">
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="modal-no-photo">
                                <i class="fas fa-image"></i>
                                <span>Aucune photo disponible</span>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-5 modal-info-col">
                        <div>
                            <span class="modal-tag">Projet réalisé · {{ $realisation->created_at->format('Y') }}</span>
                            <h2 class="modal-big-title">{{ $realisation->titre }}</h2>
                            <div class="modal-divider"></div>
                            <p class="modal-desc">{{ $realisation->description }}</p>

                            <div class="modal-meta">
                                <span class="meta-pill"><i class="fas fa-check-circle"></i> Projet terminé</span>
                                <span class="meta-pill"><i class="fas fa-calendar-alt"></i> {{ $realisation->created_at->format('M Y') }}</span>
                                <span class="meta-pill">
                                    <i class="fas fa-images"></i>
                                    {{ $realisation->images->count() }} photo{{ $realisation->images->count() > 1 ? 's' : '' }}
                                </span>
                                @if($hasDocs)
                                    <span class="meta-pill">
                                        <i class="fas fa-paperclip"></i>
                                        {{ $realisation->documents->count() }} doc{{ $realisation->documents->count() > 1 ? 's' : '' }}
                                    </span>
                                @endif
                            </div>

                            @if($hasDocs)
                                <div class="modal-docs-section">
                                    <div class="modal-docs-title">Documents</div>
                                    <div class="modal-doc-list">
                                        @foreach($realisation->documents as $doc)
                                            @php
                                                $mime    = $doc->file_type ?? '';
                                                $fname   = $doc->file_name ?? basename($doc->file_path);
                                                $ext     = strtolower(pathinfo($fname, PATHINFO_EXTENSION));

                                                if ($mime === 'application/pdf' || $ext === 'pdf') {
                                                    $dCls = 'pdf'; $dIco = 'fa-file-pdf';
                                                } elseif (str_contains($mime, 'word') || in_array($ext, ['doc','docx'])) {
                                                    $dCls = 'word'; $dIco = 'fa-file-word';
                                                } elseif (str_contains($mime, 'excel') || str_contains($mime, 'spreadsheet') || in_array($ext, ['xls','xlsx'])) {
                                                    $dCls = 'excel'; $dIco = 'fa-file-excel';
                                                } elseif (str_starts_with($mime, 'image/')) {
                                                    $dCls = 'image'; $dIco = 'fa-file-image';
                                                } else {
                                                    $dCls = 'other'; $dIco = 'fa-file-alt';
                                                }

                                                $dSize = $doc->file_size
                                                    ? ($doc->file_size < 1048576
                                                        ? round($doc->file_size / 1024, 1) . ' Ko'
                                                        : round($doc->file_size / 1048576, 1) . ' Mo')
                                                    : '';
                                            @endphp
                                            <a href="{{ asset('storage/' . $doc->file_path) }}"
                                               target="_blank"
                                               class="modal-doc-item"
                                               onclick="event.stopPropagation()">
                                                <div class="modal-doc-icon {{ $dCls }}">
                                                    <i class="fas {{ $dIco }}"></i>
                                                </div>
                                                <span class="modal-doc-name" title="{{ $fname }}">{{ $fname }}</span>
                                                @if($dSize)
                                                    <span class="modal-doc-size">{{ $dSize }}</span>
                                                @endif
                                                <span class="modal-doc-dl">
                                                    <i class="fas fa-download"></i>
                                                </span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-column gap-2 mt-3">
                            <a href="https://wa.me/22890713335" target="_blank" class="btn-whatsapp">
                                <i class="fab fa-whatsapp fa-lg"></i> +228 90 71 33 35
                            </a>
                            <a href="https://wa.me/22892028989" target="_blank" class="btn-whatsapp">
                                <i class="fab fa-whatsapp fa-lg"></i> +228 92 02 89 89
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection

{{-- ─── CTA COLLÉ AU FOOTER — pleine largeur ─── --}}
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
    .cta-num-block:hover .cta-num-arrow { transform: translateX(4px); color: var(--gold); }

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.proj-row').forEach(function (row) {
        row.addEventListener('click', function () {
            const id = row.getAttribute('data-modal-id');
            const el = document.getElementById(id);
            if (el) new bootstrap.Modal(el).show();
        });
    });
</script>

@endsection