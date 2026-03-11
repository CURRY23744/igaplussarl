@extends('admin.layouts.layout-admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- En-tête professionnel -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-semibold text-dark mb-1">
                <i class="fas fa-plus-circle me-2 text-primary"></i>
                Nouvelle réalisation
            </h1>
            <p class="text-secondary small mb-0">
                <i class="fas fa-clock me-1"></i>
                {{ now()->format('d F Y') }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.realisations.index') }}" class="btn btn-light border px-4 py-2 rounded-3">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-3 mb-4">
            <div class="d-flex">
                <i class="fas fa-exclamation-circle me-3 mt-1"></i>
                <div>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulaire -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Carte informations -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 px-4 py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informations générales
                    </h5>
                </div>
                <div class="card-body px-4">
                    <form action="{{ route('admin.realisations.store') }}" method="POST" enctype="multipart/form-data" id="realisationForm">
                        @csrf

                        <!-- Titre -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-secondary small text-uppercase mb-2">
                                Titre <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="titre"
                                   value="{{ old('titre') }}"
                                   class="form-control form-control-lg border-1 bg-light bg-opacity-25 rounded-3 @error('titre') is-invalid @enderror"
                                   placeholder="Ex: Rénovation complète d'un appartement"
                                   required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-medium text-secondary small text-uppercase mb-2">
                                Description
                            </label>
                            <textarea name="description"
                                      rows="5"
                                      class="form-control border-1 bg-light bg-opacity-25 rounded-3 @error('description') is-invalid @enderror"
                                      placeholder="Décrivez votre réalisation...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>

            <!-- Carte médias (images) -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 px-4 py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-image me-2 text-primary"></i>
                        Photos
                    </h5>
                </div>
                <div class="card-body px-4">
                    <div class="upload-area border rounded-4 p-5 text-center bg-light bg-opacity-25 mb-4" id="uploadArea">
                        <input type="file" name="images[]" id="images" multiple accept="image/*" class="d-none">
                        <i class="fas fa-cloud-upload-alt fa-3x text-primary opacity-50 mb-3"></i>
                        <h6 class="fw-semibold mb-2">Glissez vos images ici</h6>
                        <p class="small text-secondary mb-3">ou</p>
                        <button type="button" class="btn btn-primary px-4 py-2 rounded-3" id="browseBtn">
                            <i class="fas fa-folder-open me-2"></i>Parcourir
                        </button>
                        <p class="small text-secondary mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Formats acceptés : JPG, PNG, GIF (max 5 Mo par image)
                        </p>
                    </div>
                    <div id="previewContainer"></div>
                </div>
            </div>

            <!-- Carte documents -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 px-4 py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-paperclip me-2 text-primary"></i>
                        Documents associés
                    </h5>
                </div>
                <div class="card-body px-4">
                    <div class="upload-area border rounded-4 p-5 text-center bg-light bg-opacity-25 mb-3" id="docsUploadArea">
                        <input type="file" name="documents[]" id="documents" multiple class="d-none">
                        <i class="fas fa-file-upload fa-3x text-primary opacity-50 mb-3"></i>
                        <h6 class="fw-semibold mb-2">Glissez vos documents ici</h6>
                        <p class="small text-secondary mb-3">ou</p>
                        <button type="button" class="btn btn-primary px-4 py-2 rounded-3" id="docsBrowseBtn">
                            <i class="fas fa-folder-open me-2"></i>Parcourir
                        </button>
                        <p class="small text-secondary mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Tous types acceptés : PDF, Word, Excel, etc. (max 10 Mo par fichier)
                        </p>
                    </div>
                    <div id="docsPreviewContainer"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Carte résumé -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 sticky-top" style="top: 20px;">
                <div class="card-header bg-white border-0 px-4 py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-file-alt me-2 text-primary"></i>
                        Résumé
                    </h5>
                </div>
                <div class="card-body px-4">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-secondary">Titre</span>
                            <span class="small fw-medium text-dark" id="previewTitre">Non défini</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-secondary">Description</span>
                            <span class="small fw-medium text-dark" id="previewDesc">Non définie</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-secondary">Photos</span>
                            <span class="small fw-medium text-dark" id="previewCount">0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-secondary">Documents</span>
                            <span class="small fw-medium text-dark" id="previewDocsCount">0</span>
                        </div>
                    </div>

                    <hr class="my-3">

                    <button type="submit" form="realisationForm" class="btn btn-primary w-100 py-2 rounded-3 mb-2">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                    <a href="{{ route('admin.realisations.index') }}" class="btn btn-light w-100 py-2 rounded-3">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8f9fc;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .form-control, .form-select {
        border-color: #e9ecef;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }

    .upload-area {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px dashed #dee2e6 !important;
    }

    .upload-area:hover {
        border-color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.02) !important;
    }

    .upload-area.highlight {
        border-color: #0d6efd !important;
        background-color: rgba(13, 110, 253, 0.05) !important;
    }

    /* Grille de prévisualisation images */
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }

    .preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1;
        border: 1px solid #e9ecef;
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-item .remove-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        width: 20px;
        height: 20px;
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        color: #dc3545;
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .preview-item:hover .remove-btn { opacity: 1; }
    .preview-item .remove-btn:hover { background: #dc3545; color: white; }

    /* Liste documents */
    .docs-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 12px;
    }

    .doc-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8f9fc;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 10px 14px;
        transition: border-color 0.2s;
    }

    .doc-item:hover { border-color: #0d6efd; }

    .doc-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .doc-icon.pdf    { background: rgba(220, 53, 69, 0.1);  color: #dc3545; }
    .doc-icon.word   { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }
    .doc-icon.excel  { background: rgba(25, 135, 84, 0.1);  color: #198754; }
    .doc-icon.other  { background: rgba(108, 117, 125, 0.1); color: #6c757d; }
    .doc-icon.image  { background: rgba(13, 202, 240, 0.1); color: #0dcaf0; }

    .doc-info {
        flex: 1;
        min-width: 0;
    }

    .doc-name {
        font-size: 0.85rem;
        font-weight: 500;
        color: #212529;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .doc-size {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .doc-remove {
        background: none;
        border: none;
        color: #adb5bd;
        font-size: 0.85rem;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .doc-remove:hover { color: #dc3545; background: rgba(220, 53, 69, 0.08); }

    .sticky-top { top: 20px; z-index: 1020; }
    .alert-danger { border-left: 4px solid #dc3545 !important; }

    @media (max-width: 992px) {
        .sticky-top { position: static; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ── Résumé ── */
        const titreInput   = document.querySelector('input[name="titre"]');
        const descInput    = document.querySelector('textarea[name="description"]');
        const previewTitre = document.getElementById('previewTitre');
        const previewDesc  = document.getElementById('previewDesc');
        const previewCount = document.getElementById('previewCount');
        const previewDocsCount = document.getElementById('previewDocsCount');

        titreInput.addEventListener('input', function () {
            previewTitre.textContent = this.value || 'Non défini';
        });
        descInput.addEventListener('input', function () {
            const s = this.value;
            previewDesc.textContent = s.length > 30 ? s.substring(0, 30) + '…' : (s || 'Non définie');
        });

        /* ══════════════════════════════════════
           ZONE IMAGES
        ══════════════════════════════════════ */
        const uploadArea       = document.getElementById('uploadArea');
        const browseBtn        = document.getElementById('browseBtn');
        const imagesInput      = document.getElementById('images');
        const previewContainer = document.getElementById('previewContainer');

        function openImages() { imagesInput.click(); }
        uploadArea.addEventListener('click', openImages);
        browseBtn.addEventListener('click', function (e) { e.stopPropagation(); openImages(); });

        uploadArea.addEventListener('dragover',  (e) => { e.preventDefault(); uploadArea.classList.add('highlight'); });
        uploadArea.addEventListener('dragleave', ()  => { uploadArea.classList.remove('highlight'); });
        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('highlight');
            if (e.dataTransfer.files.length) {
                imagesInput.files = e.dataTransfer.files;
                handleImages(e.dataTransfer.files);
            }
        });
        imagesInput.addEventListener('change', function () { handleImages(this.files); });

        function handleImages(files) {
            previewContainer.innerHTML = '';
            if (!files.length) { previewCount.textContent = '0'; return; }

            previewCount.textContent = files.length;
            const grid = document.createElement('div');
            grid.className = 'preview-grid';

            Array.from(files).forEach((file, index) => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = function (e) {
                    const item = document.createElement('div');
                    item.className = 'preview-item';
                    item.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-btn" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </button>`;
                    grid.appendChild(item);

                    item.querySelector('.remove-btn').addEventListener('click', function (ev) {
                        ev.stopPropagation();
                        item.remove();
                        const newFiles = Array.from(imagesInput.files).filter((_, i) => i !== index);
                        const dt = new DataTransfer();
                        newFiles.forEach(f => dt.items.add(f));
                        imagesInput.files = dt.files;
                        previewCount.textContent = imagesInput.files.length;
                        if (!imagesInput.files.length) previewContainer.innerHTML = '';
                    });
                };
                reader.readAsDataURL(file);
            });

            previewContainer.appendChild(grid);
        }

        /* ══════════════════════════════════════
           ZONE DOCUMENTS
        ══════════════════════════════════════ */
        const docsUploadArea       = document.getElementById('docsUploadArea');
        const docsBrowseBtn        = document.getElementById('docsBrowseBtn');
        const documentsInput       = document.getElementById('documents');
        const docsPreviewContainer = document.getElementById('docsPreviewContainer');

        function openDocs() { documentsInput.click(); }
        docsUploadArea.addEventListener('click', openDocs);
        docsBrowseBtn.addEventListener('click', function (e) { e.stopPropagation(); openDocs(); });

        docsUploadArea.addEventListener('dragover',  (e) => { e.preventDefault(); docsUploadArea.classList.add('highlight'); });
        docsUploadArea.addEventListener('dragleave', ()  => { docsUploadArea.classList.remove('highlight'); });
        docsUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            docsUploadArea.classList.remove('highlight');
            if (e.dataTransfer.files.length) {
                documentsInput.files = e.dataTransfer.files;
                handleDocs(e.dataTransfer.files);
            }
        });
        documentsInput.addEventListener('change', function () { handleDocs(this.files); });

        /* Renvoie la classe d'icône + l'icône FA selon le type MIME */
        function getDocIcon(file) {
            const type = file.type;
            const name = file.name.toLowerCase();
            if (type === 'application/pdf')
                return { cls: 'pdf', icon: 'fa-file-pdf' };
            if (type.includes('word') || name.endsWith('.doc') || name.endsWith('.docx'))
                return { cls: 'word', icon: 'fa-file-word' };
            if (type.includes('excel') || type.includes('spreadsheet') || name.endsWith('.xls') || name.endsWith('.xlsx'))
                return { cls: 'excel', icon: 'fa-file-excel' };
            if (type.startsWith('image/'))
                return { cls: 'image', icon: 'fa-file-image' };
            return { cls: 'other', icon: 'fa-file-alt' };
        }

        /* Formate la taille */
        function formatSize(bytes) {
            if (bytes < 1024)       return bytes + ' o';
            if (bytes < 1048576)    return (bytes / 1024).toFixed(1) + ' Ko';
            return (bytes / 1048576).toFixed(1) + ' Mo';
        }

        let docsFiles = []; // tableau géré manuellement

        function handleDocs(files) {
            docsFiles = Array.from(files);
            renderDocs();
        }

        function renderDocs() {
            docsPreviewContainer.innerHTML = '';
            if (!docsFiles.length) { previewDocsCount.textContent = '0'; return; }

            previewDocsCount.textContent = docsFiles.length;

            const list = document.createElement('div');
            list.className = 'docs-list';

            docsFiles.forEach((file, index) => {
                const { cls, icon } = getDocIcon(file);
                const item = document.createElement('div');
                item.className = 'doc-item';
                item.innerHTML = `
                    <div class="doc-icon ${cls}">
                        <i class="fas ${icon}"></i>
                    </div>
                    <div class="doc-info">
                        <div class="doc-name" title="${file.name}">${file.name}</div>
                        <div class="doc-size">${formatSize(file.size)}</div>
                    </div>
                    <button type="button" class="doc-remove" title="Supprimer">
                        <i class="fas fa-times"></i>
                    </button>`;
                list.appendChild(item);

                item.querySelector('.doc-remove').addEventListener('click', function () {
                    docsFiles.splice(index, 1);
                    // Reconstruire le FileList sur l'input
                    const dt = new DataTransfer();
                    docsFiles.forEach(f => dt.items.add(f));
                    documentsInput.files = dt.files;
                    renderDocs();
                });
            });

            docsPreviewContainer.appendChild(list);
        }
    });
</script>
@endsection