<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion Immobilière</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #e0f2fe; --sidebar-hover: #bae6fd; --primary-color: #0284c7;
            --text-light: #0c4a6e; --text-muted: #0369a1; --main-bg: #f1f5f9;
            --sidebar-width: 260px; --sidebar-collapsed-width: 75px; --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        body { font-family: 'Inter', sans-serif; background: var(--main-bg); margin: 0; overflow-x: hidden; }

        .sidebar { width: var(--sidebar-width); height: 100vh; background: var(--sidebar-bg); position: fixed; z-index: 1000; transition: width var(--transition); display: flex; flex-direction: column; box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }
        .sidebar-header { height: 70px; padding: 0 20px; display: flex; align-items: center; border-bottom: 1px solid rgba(2,132,199,0.2); white-space: nowrap; }

        .nav-link { color: var(--text-muted); padding: 12px 25px; display: flex; align-items: center; text-decoration: none; transition: all var(--transition); font-weight: 500; position: relative; }
        .nav-link:hover { color: var(--text-light); background: var(--sidebar-hover); transform: translateX(8px); }
        .nav-link.active { color: white; background: var(--primary-color); box-shadow: 0 4px 15px rgba(2,132,199,0.4); }
        .nav-link i { min-width: 28px; font-size: 1.2rem; }

        .sidebar.collapsed .sidebar-header h5 span, .sidebar.collapsed .nav-link span, .sidebar.collapsed .ms-auto, .sidebar.collapsed .submenu { display: none !important; }
        .sidebar.collapsed .nav-link { justify-content: center; padding: 15px 0; }
        .submenu { background: rgba(2,132,199,0.05); list-style: none; padding: 0; }
        .submenu .nav-link { padding-left: 55px; font-size: 0.85rem; }
        .rotate { transition: transform var(--transition); font-size: 0.8rem !important; }
        .nav-link:not(.collapsed) .rotate { transform: rotate(90deg); }

        .main-wrapper { margin-left: var(--sidebar-width); transition: margin-left var(--transition); min-height: 100vh; }
        .main-wrapper.expanded { margin-left: var(--sidebar-collapsed-width); }
        .header-nav { background: #fff; height: 70px; display: flex; align-items: center; justify-content: space-between; padding: 0 30px; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 999; }
        .toggle-btn { background: #f8fafc; border: 1px solid #e2e8f0; width: 40px; height: 40px; border-radius: 8px; cursor: pointer; transition: all var(--transition); }
        .toggle-btn:hover { background: var(--primary-color); color: white; box-shadow: 0 4px 12px rgba(2,132,199,0.3); }

        .btn-logout { color: #ef4444; background: #fff1f2; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; }
        .btn-logout:hover { background: #ef4444; color: white; box-shadow: 0 4px 12px rgba(239,68,68,0.2); }
        .card-container { background: white; border-radius: 12px; padding: 30px; border: 1px solid #e2e8f0; animation: fadeInUp 0.5s ease both; }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 768px) { .sidebar { left: -100%; } .sidebar.show { left: 0; width: var(--sidebar-width) !important; } .main-wrapper { margin-left: 0 !important; } }
    </style>
</head>
<body>

@php $apropos = \App\Models\APropos::first(); @endphp

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h5 class="mb-0 fw-bold">
            <i class="fas fa-building me-2" style="color: #0284c7;"></i><span>ADMIN</span>
        </h5>
    </div>
    <div class="nav-list py-3">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i><span>Dashboard</span>
        </a>

        {{-- Biens --}}
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#m-biens">
            <i class="fas fa-house-user"></i><span>Biens</span>
            <i class="fas fa-chevron-right ms-auto rotate"></i>
        </a>
        <div class="collapse {{ request()->is('admin/biens*') ? 'show' : '' }}" id="m-biens">
            <div class="submenu">
                <a href="{{ route('admin.biens.index') }}" class="nav-link {{ request()->routeIs('admin.biens.index') ? 'active' : '' }}">
                    <i class="fas fa-list-ul me-2"></i>Liste
                </a>
                <a href="{{ route('admin.biens.create') }}" class="nav-link {{ request()->routeIs('admin.biens.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle me-2"></i>Ajouter
                </a>
            </div>
        </div>

        {{-- Réalisations --}}
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#m-real">
            <i class="fas fa-images"></i><span>Réalisations</span>
            <i class="fas fa-chevron-right ms-auto rotate"></i>
        </a>
        <div class="collapse {{ request()->is('admin/realisations*') ? 'show' : '' }}" id="m-real">
            <div class="submenu">
                <a href="{{ route('admin.realisations.index') }}" class="nav-link {{ request()->routeIs('admin.realisations.index') ? 'active' : '' }}">
                    <i class="fas fa-list-ul me-2"></i>Liste
                </a>
                <a href="{{ route('admin.realisations.create') }}" class="nav-link {{ request()->routeIs('admin.realisations.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-circle me-2"></i>Créer
                </a>
            </div>
        </div>

        {{-- À propos --}}
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#m-apropos">
            <i class="fas fa-info-circle"></i><span>À propos</span>
            <i class="fas fa-chevron-right ms-auto rotate"></i>
        </a>
        <div class="collapse {{ request()->is('admin/apropos*') ? 'show' : '' }}" id="m-apropos">
            <div class="submenu">
                <a href="{{ route('admin.apropos.index') }}"
                   class="nav-link {{ request()->routeIs('admin.apropos.index') ? 'active' : '' }}">
                    <i class="fas fa-list-ul me-2"></i>Liste
                </a>
                @if($apropos)
                    <a href="{{ route('admin.apropos.edit', $apropos->id) }}"
                       class="nav-link {{ request()->routeIs('admin.apropos.edit') ? 'active' : '' }}">
                        <i class="fas fa-pen me-2"></i>Modifier
                    </a>
                @else
                    <a href="{{ route('admin.apropos.create') }}"
                       class="nav-link {{ request()->routeIs('admin.apropos.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle me-2"></i>Créer
                    </a>
                @endif
            </div>
        </div>

    </div>
</aside>

<div class="main-wrapper" id="mainWrapper">
    <header class="header-nav">
        <button class="toggle-btn" id="btnToggle"><i class="fas fa-bars-staggered"></i></button>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="btn-logout"><i class="fas fa-sign-out-alt"></i> <span>Quitter</span></button>
        </form>
    </header>
    <main class="p-4"><div class="card-container">@yield('content')</div></main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const side = document.getElementById('sidebar'), wrap = document.getElementById('mainWrapper'), btn = document.getElementById('btnToggle');
    btn.onclick = () => {
        if (window.innerWidth > 768) {
            if (!side.classList.contains('collapsed')) document.querySelectorAll('.collapse.show').forEach(m => bootstrap.Collapse.getOrCreateInstance(m).hide());
            side.classList.toggle('collapsed'); wrap.classList.toggle('expanded');
        } else side.classList.toggle('show');
    };
    document.onclick = (e) => { if (window.innerWidth <= 768 && !side.contains(e.target) && !btn.contains(e.target)) side.classList.remove('show'); };
</script>
</body>
</html>