@extends('admin.layouts.layout-auth')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    :root {
        --marine-dark: #0b1628;
        --marine-light: #1a6eff; /* Bleu marine clair pour les accents */
        --bg-soft: #f4f7fa;
        --border-color: #e2e8f0;
    }

    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-soft);
    }

    /* ─── DÉCORATION ─── */
    .bg-grid {
        position: fixed; inset: 0; z-index: 0;
        background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.4;
    }

    /* ─── WRAPPER ─── */
    .login-wrapper {
        position: relative; z-index: 1;
        width: 100%; max-width: 420px;
        padding: 20px;
    }

    /* ─── BRAND ─── */
    .login-brand { text-align: center; margin-bottom: 30px; }
    
    .brand-icon {
        width: 60px; height: 60px;
        background: white;
        border: 2px solid var(--marine-dark);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 15px;
        font-size: 1.5rem; color: var(--marine-dark);
        box-shadow: 0 10px 15px rgba(0,0,0,0.05);
    }

    .brand-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem; font-weight: 800;
        color: var(--marine-dark); margin-bottom: 5px;
    }

    .brand-sub {
        font-size: 0.7rem; font-weight: 600;
        letter-spacing: 2px; text-transform: uppercase;
        color: var(--marine-light);
    }

    /* ─── CARTE ─── */
    .login-card {
        background: white;
        border: 1px solid var(--border-color);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* ─── CHAMPS ─── */
    .field-group { margin-bottom: 20px; }

    .field-label {
        display: block;
        font-size: 0.75rem; font-weight: 700;
        color: var(--marine-dark); margin-bottom: 8px;
        text-transform: uppercase; letter-spacing: 0.5px;
    }

    .field-input-wrap { position: relative; }

    .field-icon {
        position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 0.9rem; transition: color 0.3s;
    }

    .field-input {
        width: 100%;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        color: var(--marine-dark);
        padding: 12px 16px 12px 40px;
        font-size: 0.95rem;
        border-radius: 8px;
        transition: all 0.3s;
    }

    .field-input:focus {
        background: white;
        border-color: var(--marine-light);
        box-shadow: 0 0 0 4px rgba(26, 110, 255, 0.1);
        outline: none;
    }

    .field-input:focus ~ .field-icon { color: var(--marine-light); }

    .toggle-pw {
        position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
        background: none; border: none; color: #94a3b8; cursor: pointer;
    }

    .forgot-link {
        display: block; text-align: right;
        font-size: 0.8rem; color: var(--marine-light);
        text-decoration: none; margin-top: 10px; font-weight: 500;
    }

    /* ─── BOUTON ─── */
    .btn-login {
        width: 100%; margin-top: 25px;
        background: var(--marine-dark); border: none; color: white;
        padding: 14px; border-radius: 8px;
        font-size: 0.85rem; font-weight: 600;
        letter-spacing: 1px; text-transform: uppercase;
        transition: all 0.3s;
    }

    .btn-login:hover {
        background: #162a4d;
        transform: translateY(-1px);
        box-shadow: 0 10px 15px -3px rgba(11, 22, 40, 0.3);
    }

    .login-footer {
        text-align: center; margin-top: 25px;
        font-size: 0.75rem; color: #64748b;
    }

    /* Alertes */
    .alert-custom {
        background: #fef2f2; border: 1px solid #fee2e2;
        color: #b91c1c; padding: 12px; border-radius: 8px;
        font-size: 0.8rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;
    }
</style>

<div class="bg-grid"></div>

<div class="login-wrapper">

    <div class="login-brand">
        <div class="brand-icon"><i class="fas fa-shield-halved"></i></div>
        <div class="brand-name">IGA Plus Sarl</div>
        <div class="brand-sub">Administration</div>
    </div>

    <div class="login-card">

        @if(session('error'))
            <div class="alert-custom">
                <i class="fas fa-circle-exclamation"></i>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            <div class="field-group">
                <label class="field-label">Email</label>
                <div class="field-input-wrap">
                    <i class="fas fa-envelope field-icon"></i>
                    <input type="email" name="email" class="field-input" 
                           placeholder="nom@igaplus.tg" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="field-group">
                <label class="field-label">Mot de passe</label>
                <div class="field-input-wrap">
                    <i class="fas fa-lock field-icon"></i>
                    <input type="password" name="password" id="password" 
                           class="field-input" placeholder="••••••••" required>
                    <button type="button" class="toggle-pw" onclick="togglePw()">
                        <i class="fas fa-eye" id="pwIcon"></i>
                    </button>
                </div>
                <a href="{{ route('admin.forgot-password') }}" class="forgot-link">Oublié ?</a>
            </div>

            <button type="submit" class="btn-login">
                Se connecter
            </button>
        </form>

        <div class="login-footer">
            © {{ date('Y') }} IGA Plus Sarl • Sécurisé
        </div>
    </div>
</div>

<script>
    function togglePw() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('pwIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

@endsection