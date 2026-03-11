@extends('admin.layouts.layout-admin')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4 header-animation">
        <a href="{{ route('admin.biens.index') }}" class="btn btn-outline-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fas fa-arrow-left"></i></a>
        <div>
            <h1 class="display-6 fw-bold text-primary mb-0"><i class="fas fa-edit me-2"></i>Éditer le bien</h1>
            <p class="text-muted mt-2 mb-0"><i class="fas fa-home me-1"></i>{{ $bien->titre }}</p>
        </div>
    </div>

    <form action="{{ route('admin.biens.update', $bien->id) }}" method="POST" enctype="multipart/form-data" class="form-container">
        @csrf @method('PUT')

        <div class="form-section">
            <div class="section-header"><i class="fas fa-info-circle"></i><h5>Informations principales</h5></div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fas fa-heading me-1 text-primary"></i>Titre</label>
                    <input type="text" name="titre" class="form-control @error('titre') is-invalid @enderror" required value="{{ old('titre', $bien->titre) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label"><i class="fas fa-tag me-1 text-primary"></i>Type</label>
                    <select name="type" id="type" class="form-select" required>
                        @foreach(['Terrain','Maison','Appartement','Villa'] as $t)
                            <option value="{{ $t }}" {{ $bien->type == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label"><i class="fas fa-circle me-1 text-primary"></i>Statut</label>
                    <select name="statut" class="form-select" required>
                        <option value="À vendre" {{ $bien->statut == 'À vendre' ? 'selected' : '' }}>À vendre</option>
                        <option value="À louer" {{ $bien->statut == 'À louer' ? 'selected' : '' }}>À louer</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fas fa-money-bill-wave me-1 text-primary"></i>Prix (F CFA)</label>
                    <div class="input-group"><input type="number" name="prix" class="form-control" required value="{{ old('prix', $bien->prix) }}"><span class="input-group-text">F</span></div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fas fa-map-marker-alt me-1 text-primary"></i>Ville</label>
                    <input type="text" name="ville" class="form-control" required value="{{ old('ville', $bien->ville) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label"><i class="fas fa-map-pin me-1 text-primary"></i>Quartier</label>
                    <input type="text" name="quartier" class="form-control" required value="{{ old('quartier', $bien->quartier) }}">
                </div>
            </div>
            <textarea name="description" class="form-control" rows="4" required placeholder="Description...">{{ old('description', $bien->description) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-section h-100">
                    <div class="section-header"><i class="fab fa-whatsapp text-success"></i><h5>Contact</h5></div>
                    <label class="form-label">WhatsApp</label>
                    <input type="text" name="contact_whatsapp" class="form-control" required value="{{ old('contact_whatsapp', $bien->contact_whatsapp) }}">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-section h-100">
                    <div class="section-header"><i class="fas fa-chart-bar"></i><h5>Caractéristiques</h5></div>
                    <div class="row" id="specificFields">
                        <div class="col-6 col-md-4 mb-2 d-none" id="superficieDiv"><label class="form-label">m²</label><input type="number" step="0.01" name="superficie" class="form-control" value="{{ $bien->superficie }}"></div>
                        <div class="col-6 col-md-4 mb-2 d-none" id="nombreChambresDiv"><label class="form-label">Chambres</label><input type="number" name="nombre_chambres" class="form-control" value="{{ $bien->nombre_chambres }}"></div>
                        <div class="col-6 col-md-4 mb-2 d-none" id="nombreSallesBainDiv"><label class="form-label">Salles de bain</label><input type="number" name="nombre_salles_bain" class="form-control" value="{{ $bien->nombre_salles_bain }}"></div>
                        <div class="col-6 col-md-4 mb-2 d-none" id="etageDiv"><label class="form-label">Étage</label><input type="number" name="etage" class="form-control" value="{{ $bien->etage }}"></div>
                        <div class="col-6 col-md-4 mb-2 d-none" id="nombreCuisineDiv"><label class="form-label">Cuisines</label><input type="number" name="nombre_cuisine" class="form-control" value="{{ $bien->nombre_cuisine }}"></div>
                        <div class="col-6 col-md-4 mb-2 d-none" id="nombreSalonDiv"><label class="form-label">Salons</label><input type="number" name="nombre_salon" class="form-control" value="{{ $bien->nombre_salon }}"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section mt-4">
            <div class="section-header"><i class="fas fa-images"></i><h5>Médias</h5></div>
            <div class="media-gallery mb-4">
                @foreach($bien->medias as $media)
                <div class="media-item" id="media-{{ $media->id }}">
                    @if(str_contains($media->media_type, 'image')) <img src="{{ asset('storage/' . $media->media_path) }}">
                    @else <div class="video-thumb"><i class="fas fa-video"></i></div> @endif
                    <div class="media-overlay"><button type="button" class="btn-delete-media" onclick="deleteMedia({{ $media->id }})"><i class="fas fa-trash"></i></button></div>
                    @if($bien->mainImage && $bien->mainImage->id == $media->id)<span class="main-badge">Principale</span>@endif
                </div>
                @endforeach
            </div>
            <div class="upload-area" id="uploadArea">
                <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                <h6>Déposez vos fichiers ou <span class="text-primary">Parcourir</span></h6>
                <input type="file" name="medias[]" multiple class="d-none" id="fileInput" accept="image/*,video/*">
                <div class="file-list mt-2" id="fileList"></div>
            </div>
        </div>

        <div class="action-buttons">
            <button type="submit" class="btn-submit"><i class="fas fa-save me-2"></i>Mettre à jour</button>
            <a href="{{ route('admin.biens.index') }}" class="btn-cancel">Annuler</a>
        </div>
    </form>
</div>

<form id="deleteMediaForm" method="POST" style="display: none;">@csrf @method('DELETE')</form>

<style>
    .header-animation { animation: slideInDown 0.6s ease-out; }
    .form-container { max-width: 1100px; margin: 0 auto; }
    .form-section { background: white; border-radius: 15px; padding: 20px; margin-bottom: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; transition: 0.3s; animation: fadeInUp 0.5s both; }
    .form-section:hover { border-color: #0284c7; }
    .section-header { display: flex; align-items: center; gap: 10px; margin-bottom: 15px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; }
    .section-header i { background: #e0f2fe; color: #0284c7; padding: 8px; border-radius: 8px; }
    .form-control, .form-select { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 8px 12px; }
    .media-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; }
    .media-item { position: relative; border-radius: 10px; overflow: hidden; aspect-ratio: 1; background: #f1f5f9; }
    .media-item img { width: 100%; height: 100%; object-fit: cover; }
    .media-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; opacity: 0; transition: 0.3s; }
    .media-item:hover .media-overlay { opacity: 1; }
    .btn-delete-media { background: #ef4444; color: white; border: none; width: 35px; height: 35px; border-radius: 50%; }
    .upload-area { border: 2px dashed #cbd5e1; border-radius: 12px; padding: 20px; text-align: center; background: #f8fafc; cursor: pointer; }
    .main-badge { position: absolute; top: 5px; left: 5px; background: #0284c7; color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 10px; }
    .action-buttons { display: flex; gap: 10px; justify-content: flex-end; }
    .btn-submit { background: #0284c7; color: white; padding: 10px 25px; border-radius: 10px; border: none; font-weight: 600; }
    .btn-cancel { background: #f1f5f9; color: #64748b; padding: 10px 25px; border-radius: 10px; text-decoration: none; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; } }
</style>

<script>
    const typeSelect = document.getElementById('type');
    const fields = { 
        'Terrain': ['superficieDiv'],
        'Appartement': ['nombreChambresDiv', 'sallesBainDiv', 'etageDiv'],
        'Villa': ['nombreChambresDiv', 'sallesBainDiv', 'nombreCuisineDiv', 'nombreSalonDiv'],
        'Maison': ['nombreChambresDiv', 'sallesBainDiv', 'nombreCuisineDiv', 'nombreSalonDiv']
    };

    function updateFields() {
        const val = typeSelect.value;
        document.querySelectorAll('#specificFields > div').forEach(d => d.classList.add('d-none'));
        if(fields[val]) fields[val].forEach(id => document.getElementById(id)?.classList.remove('d-none'));
        if(val !== 'Terrain') document.getElementById('superficieDiv').classList.remove('d-none');
    }

    typeSelect.onchange = updateFields; updateFields();

    const area = document.getElementById('uploadArea'), input = document.getElementById('fileInput');
    area.onclick = () => input.click();
    input.onchange = () => {
        document.getElementById('fileList').innerHTML = Array.from(input.files).map(f => `<div class="small text-muted"><i class="fas fa-file me-1"></i>${f.name}</div>`).join('');
    };

    function deleteMedia(id) {
        if (confirm('Supprimer ce média ?')) {
            const f = document.getElementById('deleteMediaForm');
            f.action = `/admin/biens/medias/${id}`; f.submit();
        }
    }
</script>
@endsection