@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    :root { --accent: #b59461; --dark: #0f172a; --bg-soft: #f8fafc; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--dark); background: #fff; }
    h1 { font-family: 'Playfair Display', serif; }

    /* Galerie Bento */
    .gallery-grid { display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(2, 250px); gap: 12px; margin-bottom: 40px; }
    .gallery-item { border-radius: 16px; overflow: hidden; position: relative; cursor: pointer; }
    .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .gallery-item:hover img { transform: scale(1.05); }
    .main-img { grid-column: span 2; grid-row: span 2; }

    /* Modal Lightbox (Slider) */
    #lightbox { display: none; position: fixed; z-index: 9999; inset: 0; background: rgba(0,0,0,0.95); align-items: center; justify-content: center; }
    #lightbox-img { max-width: 90%; max-height: 80vh; border-radius: 8px; object-fit: contain; }
    .nav-btn { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(255,255,255,0.1); color: white; border: none; padding: 20px; cursor: pointer; border-radius: 50%; transition: 0.3s; }
    .nav-btn:hover { background: var(--accent); }
    .close-lightbox { position: absolute; top: 30px; right: 30px; color: white; font-size: 30px; cursor: pointer; }
    .img-counter { position: absolute; bottom: 30px; color: white; font-weight: 600; }

    /* Caractéristiques et Design */
    .status-badge { background: var(--dark); color: white; padding: 6px 16px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
    .location-text { color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
    .feature-tag { background: var(--bg-soft); padding: 15px; border-radius: 12px; border: 1px solid #f1f5f9; height: 100%; }
    .btn-wa { background: #000; color: #fff; width: 100%; padding: 18px; border-radius: 12px; display: flex; align-items: center; justify-content: center; gap: 10px; font-weight: 700; text-decoration: none; transition: 0.3s; }
    .btn-wa:hover { background: var(--accent); color: white; }
    .sticky-card { position: sticky; top: 100px; background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 32px; }

    @media (max-width: 768px) { .gallery-grid { grid-template-columns: 1fr; grid-template-rows: 300px; } .side-img { display: none; } }
</style>

<div class="container py-5">
    @php
        $medias = $bien->medias->map(fn($m) => asset('storage/'.$m->media_path));
    @endphp

    <div class="gallery-grid">
        @foreach($bien->medias->take(5) as $index => $media)
            <div class="gallery-item {{ $index == 0 ? 'main-img' : 'side-img' }}" onclick="openLightbox({{ $index }})">
                <img src="{{ asset('storage/'.$media->media_path) }}" alt="Image {{ $index }}">
                @if($index == 4 && $bien->medias->count() > 5)
                    <div class="position-absolute inset-0 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center text-white h4 fw-bold">
                        +{{ $bien->medias->count() - 5 }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="row g-5">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="status-badge">{{ $bien->statut }}</span>
                <div class="location-text"><i class="fas fa-map-marker-alt"></i> {{ $bien->ville }} — {{ $bien->quartier }}</div>
            </div>
            <h1 class="display-4 fw-bold mb-4">{{ $bien->titre }}</h1>
            <div class="h2 fw-light mb-5">{{ number_format($bien->prix, 0, ',', ' ') }} <small class="text-muted fs-5">FCFA</small></div>

            <div class="row g-3 mb-5">
                @foreach(['superficie' => 'm²', 'nombre_chambres' => 'Chambres', 'nombre_salles_bain' => 'Bains', 'etage' => 'Étage'] as $key => $label)
                    @if($bien->$key)
                        <div class="col-6 col-md-3">
                            <div class="feature-tag text-center">
                                <label class="text-muted small text-uppercase fw-bold d-block">{{ $label }}</label>
                                <span class="h5 fw-bold">{{ $bien->$key }} {{ $key == 'superficie' ? 'm²' : '' }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mb-5">
                <h4 class="fw-bold mb-4">Description</h4>
                <p class="text-secondary lh-lg fs-5">{{ $bien->description }}</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sticky-card shadow-sm">
                <h4 class="fw-bold mb-4">Intéressé ?</h4>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $bien->contact_whatsapp) }}" class="btn-wa">
                    <i class="fab fa-whatsapp fs-4"></i> CONTACTER SUR WHATSAPP
                </a>
            </div>
        </div>
    </div>
</div>

<div id="lightbox">
    <span class="close-lightbox" onclick="closeLightbox()">&times;</span>
    <button class="nav-btn" style="left: 20px;" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
    <img id="lightbox-img" src="" alt="">
    <button class="nav-btn" style="right: 20px;" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
    <div class="img-counter"><span id="current-idx">1</span> / {{ $bien->medias->count() }}</div>
</div>

<script>
    const images = @json($medias);
    let currentIndex = 0;

    function openLightbox(index) {
        currentIndex = index;
        updateLightbox();
        document.getElementById('lightbox').style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Empêche le scroll
    }

    function closeLightbox() {
        document.getElementById('lightbox').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function changeSlide(direction) {
        currentIndex += direction;
        if (currentIndex >= images.length) currentIndex = 0;
        if (currentIndex < 0) currentIndex = images.length - 1;
        updateLightbox();
    }

    function updateLightbox() {
        document.getElementById('lightbox-img').src = images[currentIndex];
        document.getElementById('current-idx').innerText = currentIndex + 1;
    }

    // Fermer avec la touche Echap
    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") closeLightbox();
        if (e.key === "ArrowRight") changeSlide(1);
        if (e.key === "ArrowLeft") changeSlide(-1);
    });
</script>

@endsection