@extends('admin.layouts.layout-admin')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="display-6 fw-bold text-primary mb-0">
                <i class="fas fa-info-circle me-2"></i>À propos
            </h1>
            <p class="text-muted mt-1 mb-0">Gérez la section de présentation de votre entreprise</p>
        </div>
        @if(!$apropos)
            <a href="{{ route('admin.apropos.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fas fa-plus me-2"></i>Créer
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 border-0 shadow-sm">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(!$apropos)
        <div class="text-center py-5"
             style="background:white;border-radius:20px;border:2px dashed #e2e8f0;">
            <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Aucune section À propos créée</h5>
            <a href="{{ route('admin.apropos.create') }}" class="btn btn-primary mt-3 rounded-pill px-4">
                <i class="fas fa-plus me-2"></i>Créer maintenant
            </a>
        </div>
    @else
        <div style="background:white;border-radius:20px;box-shadow:0 5px 20px rgba(0,0,0,0.05);border:1px solid #e2e8f0;overflow:hidden;">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#0b1628,#1a2e4a);padding:30px 35px;display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
                @if($apropos->image)
                    <img src="{{ asset('storage/' . $apropos->image) }}"
                         style="width:90px;height:90px;border-radius:50%;object-fit:cover;border:3px solid rgba(201,168,76,0.5);"
                         alt="Image">
                @else
                    <div style="width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-building fa-2x" style="color:rgba(255,255,255,0.3)"></i>
                    </div>
                @endif
                <div class="flex-grow-1">
                    <div style="font-size:0.65rem;letter-spacing:3px;text-transform:uppercase;color:rgba(201,168,76,0.8);margin-bottom:6px;">
                        Section active
                    </div>
                    <h2 style="font-size:1.6rem;font-weight:700;color:white;margin:0;">{{ $apropos->titre }}</h2>
                </div>
                <a href="{{ route('admin.apropos.edit', $apropos->id) }}"
                   class="btn btn-sm px-4"
                   style="background:rgba(201,168,76,0.15);border:1px solid rgba(201,168,76,0.3);color:#c9a84c;border-radius:50px;white-space:nowrap;">
                    <i class="fas fa-edit me-2"></i>Modifier
                </a>
            </div>

            {{-- Body --}}
            <div class="p-4 p-lg-5">
                <div class="row g-4">

                    {{-- Description --}}
                    <div class="col-12">
                        <div style="background:#f8fafc;border-radius:12px;padding:20px 24px;border-left:3px solid #c9a84c;">
                            <div class="text-uppercase fw-bold small text-muted mb-2"
                                 style="letter-spacing:2px;font-size:0.65rem;">Description</div>
                            <p class="mb-0" style="color:#374151;line-height:1.8;">{{ $apropos->description }}</p>
                        </div>
                    </div>

                    {{-- Contact --}}
                    <div class="col-md-6">
                        <div style="background:#f8fafc;border-radius:12px;padding:20px 24px;border-left:3px solid #3b7cff;height:100%;">
                            <div class="text-uppercase fw-bold small text-muted mb-3"
                                 style="letter-spacing:2px;font-size:0.65rem;">
                                <i class="fas fa-address-book me-1 text-primary"></i> Contact
                            </div>
                            @if($apropos->email)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="fas fa-envelope text-primary" style="width:16px;"></i>
                                    <span style="color:#374151;">{{ $apropos->email }}</span>
                                </div>
                            @endif
                            @if($apropos->whatsapp)
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fab fa-whatsapp text-success" style="width:16px;"></i>
                                    <span style="color:#374151;">{{ $apropos->whatsapp }}</span>
                                </div>
                            @endif
                            @if(!$apropos->email && !$apropos->whatsapp)
                                <span class="text-muted small">Non renseigné</span>
                            @endif
                        </div>
                    </div>

                    {{-- Réseaux sociaux --}}
                    <div class="col-md-6">
                        <div style="background:#f8fafc;border-radius:12px;padding:20px 24px;border-left:3px solid #8b5cf6;height:100%;">
                            <div class="text-uppercase fw-bold small text-muted mb-3"
                                 style="letter-spacing:2px;font-size:0.65rem;">
                                <i class="fas fa-share-alt me-1" style="color:#8b5cf6;"></i> Réseaux sociaux
                            </div>
                            @if($apropos->facebook)
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="fab fa-facebook text-primary" style="width:16px;"></i>
                                    <a href="{{ $apropos->facebook }}" target="_blank"
                                       class="text-decoration-none text-truncate"
                                       style="color:#374151;max-width:200px;">{{ $apropos->facebook }}</a>
                                </div>
                            @endif
                            @if($apropos->instagram)
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fab fa-instagram" style="width:16px;color:#e1306c;"></i>
                                    <a href="{{ $apropos->instagram }}" target="_blank"
                                       class="text-decoration-none text-truncate"
                                       style="color:#374151;max-width:200px;">{{ $apropos->instagram }}</a>
                                </div>
                            @endif
                            @if(!$apropos->facebook && !$apropos->instagram)
                                <span class="text-muted small">Non renseigné</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
</div>
@endsection