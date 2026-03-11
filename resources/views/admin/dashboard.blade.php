@extends('admin.layouts.layout-admin')

@section('content')
<style>
    :root { --primary: #0284c7; --primary-light: #38bdf8; --primary-dark: #0c4a6e; --success: #10b981; --dark: #0f172a; --gray: #64748b; }
    
    /* Animations & Keyframes */
    .fade-in { animation: fadeIn 1s ease; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }

    /* Header avec effet de rotation */
    .dashboard-header { background: linear-gradient(135deg, white, #f0f9ff); border-radius: 30px; padding: 30px; border: 1px solid rgba(2, 132, 199, 0.1); box-shadow: 0 10px 30px rgba(2, 132, 199, 0.1); animation: slideUp 0.6s ease; position: relative; overflow: hidden; }
    .dashboard-header::before { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(2, 132, 199, 0.05) 0%, transparent 70%); animation: rotate 20s linear infinite; }
    .dashboard-header h2 { font-size: 2.5rem; font-weight: 700; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; position: relative; }

    /* Stat Cards */
    .stat-card { border-radius: 25px; padding: 25px; color: white; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); position: relative; overflow: hidden; animation: slideUp 0.6s ease both; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); cursor: default; }
    .stat-card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2); }
    .stat-card::after { content: ''; position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%); opacity: 0; transition: 0.4s; }
    .stat-card:hover::after { opacity: 1; animation: rotate 10s linear infinite; }
    
    .gradient-1 { background: linear-gradient(135deg, #3b82f6, #8b5cf6); }
    .gradient-2 { background: linear-gradient(135deg, #f97316, #ef4444); }
    .gradient-3 { background: linear-gradient(135deg, #06b6d4, #3b82f6); }
    .gradient-4 { background: linear-gradient(135deg, #10b981, #06b6d4); }

    .counter { font-size: 2.8rem; font-weight: 800; text-shadow: 2px 2px 4px rgba(0,0,0,0.1); position: relative; }
    .ring-chart { position: absolute; top: 20px; right: 20px; width: 80px; height: 80px; border-radius: 50%; background: conic-gradient(var(--primary) 0deg 120deg, var(--primary-light) 120deg 240deg, var(--primary-dark) 240deg 360deg); opacity: 0.1; animation: rotate 20s linear infinite; }

    /* Quick Access */
    .quick-access-card { background: white; border-radius: 30px; border: 1px solid rgba(2, 132, 199, 0.1); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05); animation: slideUp 0.6s ease 0.5s both; overflow: hidden; transition: 0.3s; }
    .quick-access-card:hover { border-color: var(--primary); transform: translateY(-3px); }
    
    .quick-btn { padding: 12px 25px; border-radius: 50px; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s; position: relative; overflow: hidden; text-decoration: none; }
    .quick-btn::before { content: ''; position: absolute; top: 50%; left: 50%; width: 0; height: 0; border-radius: 50%; background: rgba(255, 255, 255, 0.3); transform: translate(-50%, -50%); transition: width 0.6s, height 0.6s; }
    .quick-btn:hover::before { width: 300px; height: 300px; }

    .btn-primary-custom { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; box-shadow: 0 4px 15px rgba(2,132,199,0.3); }
    .btn-outline-custom { background: white; color: var(--dark); border: 2px solid #e2e8f0; }
    .btn-outline-custom:hover { background: var(--primary); color: white; border-color: var(--primary); }

    .activity-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--success); animation: pulse 2s infinite; }
</style>

<div class="container fade-in py-4">
    <div class="dashboard-header mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-1"><i class="fas fa-hand-wave me-2" style="color: var(--primary);"></i>Bon retour parmi nous !</h2>
                <p class="text-muted mb-0"><i class="fas fa-calendar-alt me-2"></i>{{ now()->format('l d F Y') }} · Temps réel</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-primary bg-opacity-10 text-primary p-3 rounded-pill"><i class="fas fa-sync-alt me-2"></i>Tableau de bord actif</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @php
            $cards = [
                ['Total Biens', $totalBiens, $biensSemaine.' nouveaux', 'fa-building', 'gradient-1', 0.1],
                ['Total Réalisations', $totalRealisations, $realisationsSemaine.' nouvelles', 'fa-images', 'gradient-2', 0.2],
                ['Biens en base', $totalBiens, 'Données enregistrées', 'fa-database', 'gradient-3', 0.3],
                ['Activité récente', ($biensSemaine + $realisationsSemaine), 'Ajouts sur 7 jours', 'fa-chart-line', 'gradient-4', 0.4]
            ];
        @endphp
        @foreach($cards as $c)
        <div class="col-md-3">
            <div class="stat-card {{ $c[4] }}" style="animation-delay: {{ $c[5] }}s">
                <h6 class="mb-3"><i class="fas {{ $c[3] }} me-2"></i>{{ $c[0] }}</h6>
                <div class="counter" data-target="{{ $c[1] }}">0</div>
                <small class="d-flex align-items-center gap-1 mt-2"><i class="fas fa-arrow-up"></i>{{ $c[2] }}</small>
                <div class="ring-chart"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="quick-access-card mt-5">
        <div class="bg-light p-4 border-bottom">
            <h5 class="mb-0 fw-bold"><i class="fas fa-bolt text-primary me-2"></i>Actions rapides</h5>
        </div>
        <div class="p-4">
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('admin.biens.create') }}" class="quick-btn btn-primary-custom"><i class="fas fa-plus-circle"></i>Nouveau bien</a>
                <a href="{{ route('admin.realisations.create') }}" class="quick-btn btn-outline-custom"><i class="fas fa-plus-circle"></i>Nouvelle réalisation</a>
                <a href="{{ route('admin.biens.index') }}" class="quick-btn btn-outline-custom"><i class="fas fa-list"></i>Liste des biens</a>
                <a href="{{ route('admin.realisations.index') }}" class="quick-btn btn-outline-custom"><i class="fas fa-images"></i>Liste des réalisations</a>
            </div>
            <div class="mt-4 pt-3 border-top d-flex align-items-center gap-3">
                <div class="activity-dot"></div>
                <small class="text-muted"><i class="fas fa-circle-info me-1"></i>Toutes les actions sont enregistrées en temps réel</small>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.counter').forEach(el => {
            const target = +el.getAttribute('data-target');
            let current = 0;
            const update = () => {
                current += target / 40;
                if (current < target) { el.innerText = Math.ceil(current); requestAnimationFrame(update); }
                else el.innerText = target;
            };
            update();
        });
    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection