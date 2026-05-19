@extends('admin.layouts.layout-auth')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    :root {
        --marine-dark: #080c14;
        --marine-light: #1a6eff;
        --accent-blue: #4d8eff;
    }

    .page-wrap {
        min-height: 100vh;
        background: var(--marine-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'DM Sans', sans-serif;
        position: relative;
        overflow: hidden;
        padding: 40px 20px;
    }

    .bg-grid {
        position: absolute; inset: 0; z-index: 0;
        background-image:
            linear-gradient(rgba(26,110,255,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(26,110,255,0.04) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    .bg-glow {
        position: absolute;
        top: -80px; left: 50%;
        transform: translateX(-50%);
        width: 500px; height: 300px;
        background: radial-gradient(ellipse, rgba(26,110,255,0.12) 0%, transparent 70%);
        z-index: 0; pointer-events: none;
    }

    .login-wrapper {
        position: relative; z-index: 1;
        width: 100%; max-width: 420px;
    }

    .login-brand {
        text-align: center; margin-bottom: 32px;
    }

    .brand-icon {
        width: 56px; height: 56px;
        background: rgba(26,110,255,0.08);
        border: 1px solid rgba(26,110,255,0.35);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        font-size: 1.4rem; color: var(--accent-blue);
        position: relative;
    }
    .brand-icon::before {
        content: '';
        position: absolute; inset: -1px;
        border-radius: 15px;
        background: linear-gradient(135deg, rgba(26,110,255,0.3), transparent 60%);
        pointer-events: none;
    }

    .brand-name {
        font-family: 'DM Serif Display', serif;
        font-size: 1.75rem;
        color: #eef2ff;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
    }
    .brand-sub {
        font-size: 0.7rem; font-weight: 600;
        letter-spacing: 3px; text-transform: uppercase;
        color: var(--accent-blue);
    }

    .login-card {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.08);
        padding: 36px;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .login-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(26,110,255,0.4), transparent);
    }

    .card-hint {
        font-size: 0.82rem;
        color: rgba(140,165,220,0.6);
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .field-group { margin-bottom: 20px; }
    .field-label {
        display: block;
        font-size: 0.72rem; font-weight: 600;
        color: rgba(180,195,230,0.7); margin-bottom: 8px;
        text-transform: uppercase; letter-spacing: 1px;
    }
    .field-input-wrap { position: relative; }
    .field-icon {
        position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
        color: rgba(100,130,200,0.5); font-size: 0.85rem;
        transition: color 0.25s; pointer-events: none;
    }
    .field-input {
        width: 100%;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.09);
        color: #d4dff5;
        padding: 11px 16px 11px 38px;
        font-size: 0.92rem;
        font-family: 'DM Sans', sans-serif;
        border-radius: 10px;
        transition: all 0.25s;
        box-sizing: border-box;
    }
    .field-input::placeholder { color: rgba(120,145,200,0.35); }
    .field-input:focus {
        background: rgba(26,110,255,0.06);
        border-color: rgba(26,110,255,0.45);
        box-shadow: 0 0 0 3px rgba(26,110,255,0.08);
        color: #eef2ff;
        outline: none;
    }
    .field-input:focus ~ .field-icon { color: var(--accent-blue); }

    hr.card-divider {
        border: none;
        border-top: 1px solid rgba(255,255,255,0.06);
        margin: 24px 0;
    }

    .btn-login {
        width: 100%;
        background: var(--marine-light); border: none; color: white;
        padding: 13px; border-radius: 10px;
        font-size: 0.82rem; font-weight: 600;
        letter-spacing: 1.5px; text-transform: uppercase;
        font-family: 'DM Sans', sans-serif;
        cursor: pointer;
        position: relative; overflow: hidden;
        transition: all 0.25s;
    }
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 60%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
        transition: left 0.5s;
    }
    .btn-login:hover { background: #2d7aff; transform: translateY(-1px); }
    .btn-login:hover::before { left: 150%; }
    .btn-login:active { transform: translateY(0); }

    .link-return {
        display: block; text-align: center;
        margin-top: 20px;
        font-size: 0.8rem;
        color: rgba(120,150,210,0.7);
        text-decoration: none;
        transition: color 0.2s;
    }
    .link-return:hover { color: var(--accent-blue); }
    .link-return i { margin-right: 5px; }

    .login-footer {
        text-align: center; margin-top: 24px;
        font-size: 0.72rem; color: rgba(100,125,185,0.45);
        letter-spacing: 0.5px;
    }

    .alert-success-custom {
        background: rgba(40,140,80,0.12);
        border: 1px solid rgba(60,180,100,0.2);
        color: #4ade80;
        padding: 11px 13px; border-radius: 9px;
        font-size: 0.8rem; margin-bottom: 20px;
        display: flex; align-items: center; gap: 9px;
        line-height: 1.5;
    }
</style>

<div class="page-wrap">
    <div class="bg-grid"></div>
    <div class="bg-glow"></div>

    <div class="login-wrapper">
        <div class="login-brand">
            <div class="brand-icon"><i class="fas fa-shield-halved"></i></div>
            <div class="brand-name">IGA Plus Sarl</div>
            <div class="brand-sub">Administration</div>
        </div>

        <div class="login-card">
            @if(session('status'))
                <div class="alert-success-custom">
                    <i class="fas fa-circle-check"></i>
                    {{ session('status') }}
                </div>
            @endif

            <p class="card-hint">Saisissez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>

            <form action="{{ route('admin.forgot-password') }}" method="POST">
                @csrf
                <div class="field-group">
                    <label for="email" class="field-label">Adresse e-mail</label>
                    <div class="field-input-wrap">
                        <input type="email" name="email" id="email" class="field-input" placeholder="vous@exemple.com" required>
                        <i class="fas fa-envelope field-icon"></i>
                    </div>
                </div>

                <hr class="card-divider">

                <button type="submit" class="btn-login">Envoyer le lien de réinitialisation</button>
            </form>

            <a href="{{ route('admin.login') }}" class="link-return">
                <i class="fas fa-arrow-left"></i> Retour à la connexion
            </a>

            <div class="login-footer">
                © {{ date('Y') }} IGA Plus Sarl &nbsp;•&nbsp; Sécurisé
            </div>
        </div>
    </div>
</div>
@endsection