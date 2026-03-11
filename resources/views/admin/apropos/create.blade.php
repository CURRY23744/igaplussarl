@extends('admin.layouts.layout-admin')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.apropos.index') }}"
           class="btn btn-outline-primary rounded-circle me-3 d-flex align-items-center justify-content-center"
           style="width:45px;height:45px;">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="display-6 fw-bold text-primary mb-0">
                <i class="fas fa-plus-circle me-2"></i>Créer la section À propos
            </h1>
            <p class="text-muted mt-1 mb-0">Présentez votre entreprise aux visiteurs</p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.apropos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Informations générales --}}
        <div style="background:white;border-radius:20px;padding:30px;box-shadow:0 5px 20px rgba(0,0,0,0.05);border:1px solid #e2e8f0;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid #e2e8f0;">
                <i class="fas fa-info-circle text-primary"></i>
                <h5 class="mb-0 fw-bold">Informations générales</h5>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Titre <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="titre" class="form-control"
                           style="border-radius:12px;border:1.5px solid #e2e8f0;padding:10px;"
                           value="{{ old('titre') }}" required
                           placeholder="Ex: À propos d'IGA Plus Sarl">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Description <span class="text-danger">*</span>
                    </label>
                    <textarea name="description" rows="6" class="form-control"
                              style="border-radius:12px;border:1.5px solid #e2e8f0;padding:10px;"
                              required
                              placeholder="Présentez votre entreprise, vos valeurs, votre histoire...">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div style="background:white;border-radius:20px;padding:30px;box-shadow:0 5px 20px rgba(0,0,0,0.05);border:1px solid #e2e8f0;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid #e2e8f0;">
                <i class="fas fa-address-book text-primary"></i>
                <h5 class="mb-0 fw-bold">Contact</h5>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light" style="border-radius:12px 0 0 12px;">
                            <i class="fas fa-envelope text-primary"></i>
                        </span>
                        <input type="email" name="email" class="form-control"
                               style="border-radius:0 12px 12px 0;border:1.5px solid #e2e8f0;padding:10px;"
                               value="{{ old('email') }}" placeholder="contact@igaplus.tg">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">WhatsApp</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light" style="border-radius:12px 0 0 12px;">
                            <i class="fab fa-whatsapp text-success"></i>
                        </span>
                        <input type="text" name="whatsapp" class="form-control"
                               style="border-radius:0 12px 12px 0;border:1.5px solid #e2e8f0;padding:10px;"
                               value="{{ old('whatsapp') }}" placeholder="+228 90 71 33 35">
                    </div>
                </div>
            </div>
        </div>

        {{-- Réseaux sociaux --}}
        <div style="background:white;border-radius:20px;padding:30px;box-shadow:0 5px 20px rgba(0,0,0,0.05);border:1px solid #e2e8f0;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid #e2e8f0;">
                <i class="fas fa-share-alt" style="color:#8b5cf6;"></i>
                <h5 class="mb-0 fw-bold">Réseaux sociaux</h5>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Facebook</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light" style="border-radius:12px 0 0 12px;">
                            <i class="fab fa-facebook text-primary"></i>
                        </span>
                        <input type="url" name="facebook" class="form-control"
                               style="border-radius:0 12px 12px 0;border:1.5px solid #e2e8f0;padding:10px;"
                               value="{{ old('facebook') }}" placeholder="https://facebook.com/igaplus">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Instagram</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light" style="border-radius:12px 0 0 12px;">
                            <i class="fab fa-instagram" style="color:#e1306c;"></i>
                        </span>
                        <input type="url" name="instagram" class="form-control"
                               style="border-radius:0 12px 12px 0;border:1.5px solid #e2e8f0;padding:10px;"
                               value="{{ old('instagram') }}" placeholder="https://instagram.com/igaplus">
                    </div>
                </div>
            </div>
        </div>

        {{-- Image --}}
        <div style="background:white;border-radius:20px;padding:30px;box-shadow:0 5px 20px rgba(0,0,0,0.05);border:1px solid #e2e8f0;margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid #e2e8f0;">
                <i class="fas fa-image text-primary"></i>
                <h5 class="mb-0 fw-bold">Image / Logo</h5>
            </div>
            <div style="border:2px dashed #cbd5e1;border-radius:16px;padding:30px;text-align:center;background:#f8fafc;">
                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                <h6>Photo de présentation ou logo</h6>
                <p class="text-muted small mb-3">JPG, PNG — max 5 Mo</p>
                <label class="btn btn-outline-primary btn-sm">
                    Parcourir
                    <input type="file" name="image" class="d-none" id="imageInput" accept="image/*">
                </label>
            </div>
            <div id="imagePreview" class="mt-3 text-center d-none">
                <img id="previewImg" src=""
                     style="max-height:160px;border-radius:12px;border:1px solid #e2e8f0;"
                     alt="Aperçu">
            </div>
        </div>

        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.apropos.index') }}" class="btn btn-light px-4 rounded-pill">
                <i class="fas fa-times me-2"></i>Annuler
            </a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill">
                <i class="fas fa-save me-2"></i>Enregistrer
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection