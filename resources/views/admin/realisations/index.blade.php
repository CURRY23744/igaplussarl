@extends('admin.layouts.layout-admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- En-tête professionnel -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-semibold text-dark mb-1">
                <i class="fas fa-images me-2 text-primary"></i>
                Réalisations
            </h1>
            <p class="text-secondary small mb-0">
                <i class="fas fa-folder me-1"></i>
                {{ $realisations->total() }} réalisation(s) au total
            </p>
        </div>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('admin.realisations.create') }}" class="btn btn-primary px-4 py-2 rounded-3">
                <i class="fas fa-plus-circle me-2"></i>Nouvelle réalisation
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10 text-success rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-3 fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card bg-white p-3 rounded-3 border">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 rounded-3 p-2 me-3">
                        <i class="fas fa-images text-primary"></i>
                    </div>
                    <div>
                        <span class="text-secondary small">Total</span>
                        <h3 class="fw-bold mb-0">{{ $realisations->total() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card bg-white p-3 rounded-3 border">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 rounded-3 p-2 me-3">
                        <i class="fas fa-check-circle text-success"></i>
                    </div>
                    <div>
                        <span class="text-secondary small">Publiées</span>
                        <h3 class="fw-bold mb-0">{{ $realisations->total() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card bg-white p-3 rounded-3 border">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 rounded-3 p-2 me-3">
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <div>
                        <span class="text-secondary small">Ce mois</span>
                        <h3 class="fw-bold mb-0">{{ $realisations->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card bg-white p-3 rounded-3 border">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 rounded-3 p-2 me-3">
                        <i class="fas fa-paperclip text-info"></i>
                    </div>
                    <div>
                        <span class="text-secondary small">Avec documents</span>
                        <h3 class="fw-bold mb-0">{{ $realisations->filter(fn($r) => $r->documents && $r->documents->isNotEmpty())->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="bg-white p-3 rounded-3 border mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0">
                        <i class="fas fa-search text-secondary"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Rechercher une réalisation..." id="searchInput">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="filterSort">
                    <option value="recent">Plus récentes</option>
                    <option value="ancien">Plus anciennes</option>
                    <option value="alpha">Ordre alphabétique</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary flex-fill active" id="viewGrid">
                        <i class="fas fa-th-large me-1"></i>Grille
                    </button>
                    <button class="btn btn-outline-secondary flex-fill" id="viewList">
                        <i class="fas fa-list me-1"></i>Liste
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vue en grille (par défaut) -->
    <div id="gridView" class="view-active">
        @if($realisations->isEmpty())
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-images fa-4x text-secondary opacity-50"></i>
                </div>
                <h5 class="fw-semibold text-dark">Aucune réalisation</h5>
                <p class="text-secondary small mb-4">Commencez par ajouter votre première réalisation</p>
                <a href="{{ route('admin.realisations.create') }}" class="btn btn-primary px-4">
                    <i class="fas fa-plus-circle me-2"></i>Ajouter
                </a>
            </div>
        @else
            <div class="row g-4" id="realisationsGrid">
                @foreach($realisations as $realisation)
                    <div class="col-sm-6 col-lg-4 col-xl-3 realisation-item"
                         data-title="{{ strtolower($realisation->titre) }}"
                         data-date="{{ $realisation->created_at }}"
                         data-id="{{ $realisation->id }}">
                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden realisation-card">
                            <!-- Image -->
                            <div class="card-img-wrapper position-relative" style="height: 180px; background: #f8f9fa;">
                                @if($realisation->images->first())
                                    <img src="{{ asset('storage/' . $realisation->images->first()->image_path) }}"
                                         alt="{{ $realisation->titre }}"
                                         class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-secondary opacity-25 mb-2"></i>
                                        <span class="small text-secondary">Aucune image</span>
                                    </div>
                                @endif

                                <!-- Badge images -->
                                @if($realisation->images->count() > 1)
                                    <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-50 rounded-pill">
                                        <i class="fas fa-camera me-1"></i>{{ $realisation->images->count() }}
                                    </span>
                                @endif

                                <!-- Badge documents -->
                                @if($realisation->documents && $realisation->documents->isNotEmpty())
                                    <span class="position-absolute top-0 start-0 m-2 badge bg-primary bg-opacity-75 rounded-pill">
                                        <i class="fas fa-paperclip me-1"></i>{{ $realisation->documents->count() }} doc{{ $realisation->documents->count() > 1 ? 's' : '' }}
                                    </span>
                                @endif
                            </div>

                            <!-- Contenu -->
                            <div class="card-body p-3">
                                <h6 class="card-title fw-semibold text-dark mb-2">{{ $realisation->titre }}</h6>
                                <p class="card-text small text-secondary mb-2" style="line-height: 1.4;">
                                    {{ \Illuminate\Support\Str::limit($realisation->description, 80) }}
                                </p>

                                <!-- Date -->
                                <div class="small text-secondary mb-3">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $realisation->created_at->format('d/m/Y') }}
                                </div>

                                <!-- Actions -->
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.realisations.edit', $realisation->id) }}"
                                       class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="fas fa-edit me-1"></i>Éditer
                                    </a>
                                    <form action="{{ route('admin.realisations.destroy', $realisation->id) }}"
                                          method="POST"
                                          class="d-inline flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger w-100"
                                                onclick="return confirm('Supprimer cette réalisation ?')">
                                            <i class="fas fa-trash-alt me-1"></i>Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Vue en liste (cachée par défaut) -->
    <div id="listView" style="display: none;">
        @if($realisations->isNotEmpty())
            <div class="bg-white rounded-3 border overflow-hidden" id="realisationsList">
                @foreach($realisations as $realisation)
                    <div class="list-item p-3 border-bottom realisation-item"
                         data-title="{{ strtolower($realisation->titre) }}"
                         data-date="{{ $realisation->created_at }}"
                         data-id="{{ $realisation->id }}">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="list-image" style="width: 60px; height: 60px; background: #f8f9fa; border-radius: 8px; overflow: hidden;">
                                    @if($realisation->images->first())
                                        <img src="{{ asset('storage/' . $realisation->images->first()->image_path) }}"
                                             alt="" class="w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image text-secondary opacity-25"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="fw-semibold mb-1">{{ $realisation->titre }}</h6>
                                <p class="small text-secondary mb-1">{{ \Illuminate\Support\Str::limit($realisation->description, 100) }}</p>
                                <!-- Badges docs + images en vue liste -->
                                <div class="d-flex gap-2">
                                    @if($realisation->images->count())
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill" style="font-size:0.7rem;">
                                            <i class="fas fa-camera me-1"></i>{{ $realisation->images->count() }} photo{{ $realisation->images->count() > 1 ? 's' : '' }}
                                        </span>
                                    @endif
                                    @if($realisation->documents && $realisation->documents->isNotEmpty())
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill" style="font-size:0.7rem;">
                                            <i class="fas fa-paperclip me-1"></i>{{ $realisation->documents->count() }} doc{{ $realisation->documents->count() > 1 ? 's' : '' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="small text-secondary mb-2">
                                    {{ $realisation->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.realisations.edit', $realisation->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.realisations.destroy', $realisation->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Supprimer cette réalisation ?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if(method_exists($realisations, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $realisations->links() }}
        </div>
    @endif
</div>

<style>
    body {
        background-color: #f8f9fc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .stat-card { transition: all 0.2s ease; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .stat-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; }
    .realisation-card { transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.05); }
    .realisation-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; border-color: rgba(13,110,253,0.2); }
    .card-img-wrapper { overflow: hidden; }
    .card-img-wrapper img { transition: transform 0.3s ease; }
    .realisation-card:hover .card-img-wrapper img { transform: scale(1.05); }
    .list-item { transition: all 0.2s ease; }
    .list-item:hover { background-color: rgba(13,110,253,0.02); }
    .list-image { border: 1px solid #dee2e6; }
    .view-active { animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .btn-outline-secondary.active { background-color: #e9ecef; color: #0d6efd; border-color: #0d6efd; }
    .object-fit-cover { object-fit: cover; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const filterSort  = document.getElementById('filterSort');
        const gridView    = document.getElementById('gridView');
        const listView    = document.getElementById('listView');
        const viewGrid    = document.getElementById('viewGrid');
        const viewList    = document.getElementById('viewList');
        const items       = document.querySelectorAll('.realisation-item');

        searchInput.addEventListener('input', function () {
            const term = this.value.toLowerCase();
            items.forEach(item => {
                item.style.display = item.dataset.title.includes(term) ? '' : 'none';
            });
        });

        filterSort.addEventListener('change', function () {
            const sortBy = this.value;
            const container     = document.getElementById('realisationsGrid');
            const listContainer = document.getElementById('realisationsList');
            const arr = Array.from(items);
            arr.sort((a, b) => {
                if (sortBy === 'recent') return new Date(b.dataset.date) - new Date(a.dataset.date);
                if (sortBy === 'ancien') return new Date(a.dataset.date) - new Date(b.dataset.date);
                return a.dataset.title.localeCompare(b.dataset.title);
            });
            if (container)     arr.forEach(i => { if (i.parentElement === container)     container.appendChild(i); });
            if (listContainer) arr.forEach(i => { if (i.parentElement === listContainer) listContainer.appendChild(i); });
        });

        viewGrid.addEventListener('click', function () {
            viewGrid.classList.add('active'); viewList.classList.remove('active');
            gridView.style.display = ''; listView.style.display = 'none';
        });
        viewList.addEventListener('click', function () {
            viewList.classList.add('active'); viewGrid.classList.remove('active');
            listView.style.display = ''; gridView.style.display = 'none';
        });

        items.forEach((item, i) => {
            item.style.animation = `fadeInUp 0.4s ease forwards ${i * 0.05}s`;
        });
    });
</script>
@endsection