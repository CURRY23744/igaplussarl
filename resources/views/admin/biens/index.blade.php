@extends('admin.layouts.layout-admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-6 fw-bold text-primary">
            <i class="fas fa-building me-2"></i>Liste des biens
        </h1>
        <a href="{{ route('admin.biens.create') }}" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus-circle me-2"></i>Ajouter un bien
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Stats rapides -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card">
                <div class="stats-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $biens->count() }}</h3>
                    <p>Total biens</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #10b981;">
                <div class="stats-icon" style="background: #10b98120; color: #10b981;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $biens->where('statut', 'Disponible')->count() }}</h3>
                    <p>Disponibles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #f59e0b;">
                <div class="stats-icon" style="background: #f59e0b20; color: #f59e0b;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $biens->where('statut', 'Loué')->count() }}</h3>
                    <p>Loués</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="border-left-color: #ef4444;">
                <div class="stats-icon" style="background: #ef444420; color: #ef4444;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stats-info">
                    <h3>{{ $biens->where('statut', 'Vendu')->count() }}</h3>
                    <p>Vendus</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Accordéon avec images -->
    <div class="accordion" id="propertyAccordion">
        @foreach($biens as $bien)
            <div class="accordion-item mb-3">
                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                    <button class="accordion-button collapsed" type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapse{{ $loop->index }}" 
                            aria-expanded="false" 
                            aria-controls="collapse{{ $loop->index }}">
                        
                        <!-- Image miniature dans le header -->
                        <div class="accordion-image">
                            @if($bien->mainImage)
                                <img src="{{ asset('storage/' . $bien->mainImage->media_path) }}" 
                                     alt="Miniature">
                            @elseif($bien->medias->first())
                                <img src="{{ asset('storage/' . $bien->medias->first()->media_path) }}" 
                                     alt="Miniature">
                            @else
                                <div class="no-image-small">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Infos rapides -->
                        <div class="accordion-info">
                            <span class="info-title">{{ $bien->titre }}</span>
                            <span class="info-location">
                                <i class="fas fa-map-marker-alt"></i> {{ $bien->ville }}
                            </span>
                        </div>
                        
                        <!-- Badges -->
                        <div class="accordion-badges">
                            <span class="badge-type">{{ $bien->type }}</span>
                            <span class="badge-statut {{ strtolower($bien->statut) }}">{{ $bien->statut }}</span>
                            <span class="badge-price">{{ number_format($bien->prix, 0, ',', ' ') }} F</span>
                        </div>
                    </button>
                </h2>

                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" 
                     aria-labelledby="heading{{ $loop->index }}" 
                     data-bs-parent="#propertyAccordion">
                    <div class="accordion-body">
                        <!-- Galerie d'images -->
                        @if($bien->medias->count() > 0)
                            <div class="property-gallery">
                                <div class="gallery-main">
                                    @if($bien->mainImage)
                                        <img src="{{ asset('storage/' . $bien->mainImage->media_path) }}" 
                                             alt="Image principale" 
                                             class="gallery-main-img">
                                    @else
                                        <img src="{{ asset('storage/' . $bien->medias->first()->media_path) }}" 
                                             alt="Image principale" 
                                             class="gallery-main-img">
                                    @endif
                                </div>
                                
                                @if($bien->medias->count() > 1)
                                    <div class="gallery-thumbs">
                                        @foreach($bien->medias as $media)
                                            <img src="{{ asset('storage/' . $media->media_path) }}" 
                                                 alt="Image {{ $loop->iteration }}" 
                                                 class="gallery-thumb"
                                                 onclick="this.parentElement.previousElementSibling.firstElementChild.src = this.src">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Grille d'informations -->
                        <div class="property-details-grid">
                            <div class="detail-section">
                                <h5><i class="fas fa-info-circle"></i> Description</h5>
                                <p>{{ $bien->description }}</p>
                                <p><strong>Quartier:</strong> {{ $bien->quartier }}</p>
                            </div>

                            <div class="detail-section">
                                <h5><i class="fas fa-chart-bar"></i> Caractéristiques</h5>
                                <table class="detail-table">
                                    <tr>
                                        <td>Superficie</td>
                                        <td><strong>{{ $bien->superficie ?? '-' }} m²</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Chambres</td>
                                        <td><strong>{{ $bien->nombre_chambres ?? '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Salles de bain</td>
                                        <td><strong>{{ $bien->nombre_salles_bain ?? '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Cuisines</td>
                                        <td><strong>{{ $bien->nombre_cuisine ?? '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Salons</td>
                                        <td><strong>{{ $bien->nombre_salon ?? '-' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Étage</td>
                                        <td><strong>{{ $bien->etage ?? '-' }}</strong></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="detail-section">
                                <h5><i class="fas fa-cogs"></i> Actions</h5>
                                <div class="action-group">
                                    <a href="{{ route('admin.biens.edit', $bien->id) }}" class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i> Modifier le bien
                                    </a>
                                    <form action="{{ route('admin.biens.destroy', $bien->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn delete-btn" 
                                                onclick="return confirm('Supprimer ce bien ?')">
                                            <i class="fas fa-trash-alt"></i> Supprimer le bien
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    /* Stats Cards */
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border-left: 4px solid #0284c7;
        animation: statsPulse 1s ease;
    }

    @keyframes statsPulse {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(2, 132, 199, 0.15);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        background: #0284c720;
        color: #0284c7;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stats-info h3 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: #0f172a;
    }

    .stats-info p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    /* Accordéon */
    .accordion-item {
        border: none;
        border-radius: 20px !important;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: all 0.3s;
        animation: slideUp 0.5s ease;
        animation-fill-mode: both;
    }

    @foreach($biens as $index => $bien)
        .accordion-item:nth-child({{ $loop->iteration }}) {
            animation-delay: {{ $loop->iteration * 0.1 }}s;
        }
    @endforeach

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .accordion-item:hover {
        box-shadow: 0 10px 30px rgba(2, 132, 199, 0.15);
    }

    .accordion-button {
        padding: 20px;
        background: white;
        border: none;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, #f0f9ff, white);
        color: #0284c7;
    }

    .accordion-button::after {
        display: none;
    }

    .accordion-image {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .accordion-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .accordion-button:hover .accordion-image img {
        transform: scale(1.1);
    }

    .no-image-small {
        width: 100%;
        height: 100%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .accordion-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .info-title {
        font-weight: 700;
        color: #0f172a;
        font-size: 1.1rem;
    }

    .info-location {
        font-size: 0.85rem;
        color: #64748b;
    }

    .accordion-badges {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .badge-type {
        background: #e0f2fe;
        color: #0284c7;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-statut {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        color: white;
    }

    .badge-statut.disponible { background: #10b981; }
    .badge-statut.vendu { background: #ef4444; }
    .badge-statut.loué { background: #f59e0b; }

    .badge-price {
        background: #0284c7;
        color: white;
        padding: 4px 15px;
        border-radius: 20px;
        font-weight: 700;
    }

    /* Galerie d'images */
    .property-gallery {
        margin-bottom: 30px;
    }

    .gallery-main {
        width: 100%;
        height: 300px;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .gallery-main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .gallery-main-img:hover {
        transform: scale(1.05);
    }

    .gallery-thumbs {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding: 5px 0;
    }

    .gallery-thumb {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .gallery-thumb:hover {
        transform: scale(1.1);
        border-color: #0284c7;
        box-shadow: 0 5px 15px rgba(2, 132, 199, 0.3);
    }

    /* Détails */
    .property-details-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .detail-section {
        padding: 20px;
        background: #f8fafc;
        border-radius: 15px;
    }

    .detail-section h5 {
        color: #0284c7;
        margin-bottom: 15px;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-table {
        width: 100%;
    }

    .detail-table td {
        padding: 8px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .detail-table td:first-child {
        color: #64748b;
    }

    .detail-table td:last-child {
        text-align: right;
        color: #0f172a;
    }

    .action-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .action-btn {
        display: block;
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: none;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
        cursor: pointer;
        font-weight: 600;
    }

    .edit-btn {
        background: #fef3c7;
        color: #d97706;
    }
    .edit-btn:hover {
        background: #d97706;
        color: white;
        transform: translateX(5px);
    }

    .delete-btn {
        background: #fee2e2;
        color: #dc2626;
    }
    .delete-btn:hover {
        background: #dc2626;
        color: white;
        transform: translateX(5px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .property-details-grid {
            grid-template-columns: 1fr;
        }

        .accordion-button {
            flex-wrap: wrap;
        }

        .accordion-badges {
            width: 100%;
            justify-content: center;
        }

        .gallery-main {
            height: 200px;
        }
    }
</style>
@endsection