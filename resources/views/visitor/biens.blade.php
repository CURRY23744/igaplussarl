@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
    :root {
        --navy: #0b1628;
        --blue: #1a6eff;
        --gold: #c9a84c;
        --gold-light: #e4c97c;
        --muted: #8898b3;
        --off-white: #f8fafc;
        --border: #e8edf5;
    }

    body { font-family: 'Outfit', sans-serif; background-color: #fff; }

    /* ─── HEADER ────────────────────────────────── */
    .page-header-breakout {
        width: 100vw; position: relative; left: 50%; margin-left: -50vw;
        margin-top: calc(-40px - 3rem); margin-bottom: 2rem;
    }
    .page-header {
        height: 300px; display: flex; align-items: center; justify-content: center;
        background: linear-gradient(rgba(11,22,40,0.6), rgba(11,22,40,0.6)), 
                    url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=2070') center/cover;
        text-align: center; color: white;
    }
    .page-header h1 { font-family: 'Cormorant Garamond', serif; font-size: 3.5rem; font-weight: 700; margin: 0; }

    /* ─── FILTRAGE ─────────────────────────────── */
    .filter-wrapper {
        max-width: 1100px; margin: -50px auto 40px; position: relative; z-index: 10;
        background: white; padding: 25px; border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08); border: 1px solid var(--border);
    }
    .filter-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: flex-end;
    }
    .filter-group label {
        display: block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 1px; color: var(--navy); margin-bottom: 8px;
    }
    .filter-control {
        width: 100%; padding: 10px 15px; border-radius: 8px; border: 1px solid var(--border);
        background: var(--off-white); font-size: 0.9rem; color: var(--navy); outline: none; transition: 0.3s;
    }
    .filter-control:focus { border-color: var(--gold); background: #fff; }
    
    .btn-search {
        background: var(--navy); color: white; border: none; padding: 12px;
        border-radius: 8px; font-weight: 600; transition: 0.3s; width: 100%; cursor: pointer;
    }
    .btn-search:hover { background: var(--gold); transform: translateY(-2px); }

    /* ─── SECTION NAVIGATION ────────────────────── */
    .cat-nav {
        display: flex; justify-content: center; gap: 0.8rem; margin-bottom: 4rem; flex-wrap: wrap;
    }
    .cat-nav-link {
        padding: 8px 20px; border-radius: 50px; background: white;
        color: var(--muted); text-decoration: none; font-weight: 600; font-size: 0.8rem;
        transition: 0.3s; border: 1px solid var(--border);
    }
    .cat-nav-link:hover { border-color: var(--navy); color: var(--navy); }

    /* ─── CATEGORY SECTIONS ──────────────────────── */
    .category-section { margin-bottom: 5rem; scroll-margin-top: 100px; }
    .category-header { display: flex; align-items: center; gap: 20px; margin-bottom: 2.5rem; }
    .category-header h2 {
        font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; font-weight: 700;
        color: var(--navy); margin: 0; white-space: nowrap;
    }
    .category-header .line { height: 1px; background: var(--border); width: 100%; }
    .category-header .count {
        background: var(--off-white); padding: 5px 15px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 600; color: var(--gold); border: 1px solid var(--border);
    }

    /* ─── GRID CARD ────────────────────────────── */
    .biens-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 2rem;
    }
    .card-bien {
        position: relative; height: 400px; border-radius: 15px; overflow: hidden;
        text-decoration: none; display: block;
    }
    .card-img { width: 100%; height: 100%; object-fit: cover; transition: 0.8s cubic-bezier(0.2, 1, 0.3, 1); }
    .card-bien:hover .card-img { transform: scale(1.08); }
    
    .card-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(11,22,40,0.9) 0%, rgba(11,22,40,0.2) 60%);
    }
    .card-content { position: absolute; bottom: 0; left: 0; padding: 2rem; width: 100%; }
    .card-title {
        font-family: 'Cormorant Garamond', serif; color: white; font-size: 1.7rem;
        font-weight: 700; margin-bottom: 0.5rem;
    }
    .card-meta { color: var(--gold-light); font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; }

    @media (max-width: 768px) {
        .filter-wrapper { margin: -30px 15px 30px; padding: 20px; }
        .biens-grid { grid-template-columns: 1fr; }
        .page-header h1 { font-size: 2.2rem; }
    }
</style>

<div class="page-header-breakout">
    <div class="page-header">
        <div>
            <span style="letter-spacing: 3px; text-transform: uppercase; font-size: 0.7rem; color: var(--gold-light);">IGA Plus Immobilier</span>
            <h1>Catalogue Exclusif</h1>
        </div>
    </div>
</div>

<div class="container mb-5">
    
    {{-- BARRE DE FILTRE --}}
    <div class="filter-wrapper">
        <form action="{{ route('biens') }}" method="GET" class="filter-grid">
            <div class="filter-group">
                <label><i class="fas fa-search me-1"></i> Ville / Quartier</label>
                <input type="text" name="search" class="filter-control" placeholder="Où cherchez-vous ?" value="{{ request('search') }}">
            </div>
            
            <div class="filter-group">
                <label><i class="fas fa-home me-1"></i> Type</label>
                <select name="type" class="filter-control">
                    <option value="">Tous les types</option>
                    <option value="Terrain" {{ request('type') == 'Terrain' ? 'selected' : '' }}>Terrains</option>
                    <option value="Villa" {{ request('type') == 'Villa' ? 'selected' : '' }}>Villas</option>
                    <option value="Appartement" {{ request('type') == 'Appartement' ? 'selected' : '' }}>Appartements</option>
                    <option value="Maison" {{ request('type') == 'Maison' ? 'selected' : '' }}>Maisons</option>
                </select>
            </div>

            <div class="filter-group">
                <label><i class="fas fa-tag me-1"></i> Budget Max (FCFA)</label>
                <input type="number" name="prix_max" class="filter-control" placeholder="Ex: 50000000" value="{{ request('prix_max') }}">
            </div>

            <div class="filter-group">
                <button type="submit" class="btn-search">Filtrer</button>
            </div>
        </form>
        @if(request()->anyFilled(['search', 'type', 'prix_max']))
            <div class="text-center mt-3">
                <a href="{{ route('biens') }}" class="text-muted small text-decoration-none">
                    <i class="fas fa-times-circle"></i> Réinitialiser les filtres
                </a>
            </div>
        @endif
    </div>

    @php
        $groupedBiens = $biens->groupBy('type');
    @endphp

    {{-- Navigation rapide --}}
    @if(!$biens->isEmpty())
    <div class="cat-nav">
        @foreach($groupedBiens as $type => $items)
            <a href="#section-{{ Str::slug($type) }}" class="cat-nav-link">
                {{ $type }}s <span class="ms-1" style="opacity:0.6">({{ $items->count() }})</span>
            </a>
        @endforeach
    </div>
    @endif

    @if($biens->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
            <p class="text-muted">Aucun bien ne correspond à vos critères de recherche.</p>
            <a href="{{ route('biens') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4">Tout afficher</a>
        </div>
    @else

        @foreach($groupedBiens as $type => $items)
            <section class="category-section" id="section-{{ Str::slug($type) }}">
                <div class="category-header">
                    <h2>{{ $type }}s</h2>
                    <div class="line"></div>
                    <div class="count">{{ $items->count() }} offre{{ $items->count() > 1 ? 's' : '' }}</div>
                </div>

                <div class="biens-grid">
                    @foreach($items as $b)
                        @php
                            $m = $b->medias->where('is_main', true)->first() ?? $b->medias->first();
                            $img = $m ? asset('storage/' . $m->media_path) : 'https://via.placeholder.com/600x400';
                        @endphp
                        
                        <a href="{{ route('biens.show', $b->id) }}" class="card-bien">
                            <img class="card-img" src="{{ $img }}" alt="{{ $b->titre }}">
                            <div class="card-overlay"></div>
                            <div class="card-content">
                                <div class="card-meta">
                                    {{ $b->quartier }}, {{ $b->ville }} • {{ number_format($b->prix, 0, ',', ' ') }} FCFA
                                </div>
                                <div class="card-title">{{ $b->titre }}</div>
                                <div style="color: rgba(255,255,255,0.7); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; font-weight: 500;">
                                    Détails <i class="fas fa-arrow-right ms-2" style="font-size: 0.6rem;"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endforeach

    @endif

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection