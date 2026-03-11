@extends('admin.layouts.layout-admin')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4 header-animation">
        <a href="{{ route('admin.biens.index') }}" class="btn btn-outline-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;"><i class="fas fa-arrow-left"></i></a>
        <div>
            <h1 class="display-6 fw-bold text-primary mb-0"><i class="fas fa-plus-circle me-2"></i>Ajouter un bien</h1>
            <p class="text-muted mt-2 mb-0"><i class="fas fa-home me-1"></i>Créez une nouvelle annonce immobilière</p>
        </div>
    </div>

    {{-- Affichage des erreurs de validation --}}
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <strong><i class="fas fa-exclamation-triangle me-2"></i>Erreurs de validation :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.biens.store') }}" method="POST" enctype="multipart/form-data" id="bienForm">
        @csrf

        <div class="form-container">

            {{-- Informations principales --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h5>Informations principales</h5>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-heading me-1 text-primary"></i>Titre</label>
                        <input type="text" name="titre" class="form-control" required placeholder="Ex: Villa moderne..." value="{{ old('titre') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><i class="fas fa-tag me-1 text-primary"></i>Type</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach(['Terrain','Maison','Appartement','Villa'] as $t)
                                <option value="{{ $t }}" {{ old('type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"><i class="fas fa-circle me-1 text-primary"></i>Statut</label>
                        <select name="statut" class="form-select" required>
                            <option value="À vendre" {{ old('statut') == 'À vendre' ? 'selected' : '' }}>À vendre</option>
                            <option value="À louer" {{ old('statut') == 'À louer' ? 'selected' : '' }}>À louer</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="fas fa-money-bill-wave me-1 text-primary"></i>Prix (F CFA)</label>
                        <div class="input-group">
                            <input type="number" name="prix" class="form-control" required value="{{ old('prix') }}">
                            <span class="input-group-text bg-light">F</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="fas fa-map-marker-alt me-1 text-primary"></i>Ville</label>
                        <input type="text" name="ville" class="form-control" required placeholder="Ex: Lomé" value="{{ old('ville') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><i class="fas fa-map-pin me-1 text-primary"></i>Quartier</label>
                        <input type="text" name="quartier" class="form-control" required placeholder="Ex: Bè" value="{{ old('quartier') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label"><i class="fas fa-align-left me-1 text-primary"></i>Description</label>
                        <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Contact + Caractéristiques --}}
            <div class="row g-4 mb-4">
                <div class="col-md-5">
                    <div class="form-section h-100 mb-0">
                        <div class="section-header">
                            <i class="fab fa-whatsapp text-success"></i>
                            <h5>Contact</h5>
                        </div>
                        <label class="form-label"><i class="fab fa-whatsapp me-1 text-success"></i>WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-phone-alt"></i></span>
                            <input type="text" name="contact_whatsapp" class="form-control" required placeholder="+228..." value="{{ old('contact_whatsapp') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-section h-100 mb-0">
                        <div class="section-header">
                            <i class="fas fa-chart-bar"></i>
                            <h5>Caractéristiques</h5>
                        </div>
                        <div class="row g-2" id="specificFields">
                            <div class="col-md-6 d-none" id="superficieDiv">
                                <label class="form-label small">Superficie (m²)</label>
                                <input type="number" name="superficie" class="form-control" value="{{ old('superficie') }}">
                            </div>
                            <div class="col-md-6 d-none" id="chambresDiv">
                                <label class="form-label small">Chambres</label>
                                <input type="number" name="nombre_chambres" class="form-control" value="{{ old('nombre_chambres') }}">
                            </div>
                            <div class="col-md-6 d-none" id="sallesBainDiv">
                                <label class="form-label small">Salles de bain</label>
                                <input type="number" name="nombre_salles_bain" class="form-control" value="{{ old('nombre_salles_bain') }}">
                            </div>
                            <div class="col-md-6 d-none" id="etageDiv">
                                <label class="form-label small">Étage</label>
                                <input type="number" name="etage" class="form-control" value="{{ old('etage') }}">
                            </div>
                            <div class="col-md-6 d-none" id="cuisineDiv">
                                <label class="form-label small">Cuisines</label>
                                <input type="number" name="nombre_cuisine" class="form-control" value="{{ old('nombre_cuisine') }}">
                            </div>
                            <div class="col-md-6 d-none" id="salonDiv">
                                <label class="form-label small">Salons</label>
                                <input type="number" name="nombre_salon" class="form-control" value="{{ old('nombre_salon') }}">
                            </div>
                        </div>
                        <div class="alert alert-info mt-3 small d-none" id="fieldHelp"></div>
                    </div>
                </div>
            </div>

            {{-- Médias --}}
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <h5>Médias</h5>
                </div>
                {{-- Zone de drop séparée du bouton submit --}}
                <div style="border: 2px dashed #cbd5e1; border-radius: 16px; padding: 30px; text-align: center; background: #f8fafc;">
                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                    <h6>Glissez-déposez vos fichiers ici</h6>
                    <label class="btn btn-outline-primary btn-sm mt-2" onclick="event.stopPropagation()">
                        Parcourir
                        <input type="file" name="medias[]" multiple class="d-none" id="fileInput" accept="image/*,video/mp4">
                    </label>
                </div>
                <div class="mt-3 d-flex flex-wrap gap-2" id="previewGrid"></div>
            </div>

            {{-- Boutons --}}
            <div class="d-flex gap-2 justify-content-end mt-4">
                <button type="reset" class="btn btn-reset px-4" onclick="document.getElementById('previewGrid').innerHTML=''">
                    <i class="fas fa-undo me-2"></i>Réinitialiser
                </button>
                <a href="{{ route('admin.biens.index') }}" class="btn btn-cancel px-4">
                    <i class="fas fa-times me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-submit px-5 text-white">
                    <i class="fas fa-plus-circle me-2"></i>Créer le bien
                </button>
            </div>

        </div>
    </form>
</div>

<style>
    .header-animation { animation: slideInDown 0.6s ease-out; }
    .form-section { background: white; border-radius: 20px; padding: 25px; margin-bottom: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; animation: fadeInUp 0.5s ease both; }
    .section-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e2e8f0; }
    .section-header i { width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; background: #e0f2fe; color: #0284c7; border-radius: 8px; }
    .form-control, .form-select { border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 10px; transition: 0.3s; }
    .btn-submit { background: linear-gradient(135deg, #0284c7, #0c4a6e); border-radius: 12px; font-weight: 600; border: none; }
    .btn-reset, .btn-cancel { background: #f1f5f9; border-radius: 12px; border: 1px solid #cbd5e1; font-weight: 600; }
    .preview-item { position: relative; width: 100px; height: 100px; border-radius: 10px; overflow: hidden; border: 1px solid #ddd; }
    .preview-item img { width: 100%; height: 100%; object-fit: cover; }
    .remove-btn { position: absolute; top: 5px; right: 5px; background: #ef4444; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; font-size: 12px; cursor: pointer; }
    @keyframes slideInDown { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    // ── Gestion des champs dynamiques selon le type ──
    const typeSelect = document.getElementById('type');
    const helpBox    = document.getElementById('fieldHelp');

    const displayMap = {
        'Terrain':     { ids: ['superficieDiv'],                              msg: 'Pour un terrain, seule la superficie est requise.' },
        'Maison':      { ids: ['chambresDiv', 'sallesBainDiv'],               msg: 'Pour une maison, renseignez les pièces principales.' },
        'Appartement': { ids: ['chambresDiv', 'sallesBainDiv', 'etageDiv'],   msg: "Pour un appartement, précisez l'étage." },
        'Villa':       { ids: ['chambresDiv', 'sallesBainDiv', 'cuisineDiv', 'salonDiv'], msg: 'Pour une villa, toutes les pièces sont importantes.' }
    };

    function applyType(val) {
        document.querySelectorAll('#specificFields > div').forEach(d => d.classList.add('d-none'));
        const config = displayMap[val];
        if (config) {
            config.ids.forEach(id => document.getElementById(id).classList.remove('d-none'));
            helpBox.innerText = config.msg;
            helpBox.classList.remove('d-none');
        } else {
            helpBox.classList.add('d-none');
        }
    }

    typeSelect.addEventListener('change', () => applyType(typeSelect.value));

    // Restaurer l'affichage si old('type') existe (après erreur de validation)
    const oldType = "{{ old('type') }}";
    if (oldType) applyType(oldType);

    // ── Prévisualisation des images ──
    const fileInput   = document.getElementById('fileInput');
    const previewGrid = document.getElementById('previewGrid');

    fileInput.addEventListener('change', () => {
        previewGrid.innerHTML = '';
        [...fileInput.files].forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `<img src="${e.target.result}" alt="preview"><button type="button" class="remove-btn" title="Supprimer">×</button>`;
                div.querySelector('.remove-btn').onclick = () => div.remove();
                previewGrid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection