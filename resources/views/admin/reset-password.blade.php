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

    .pw-strength {
        display: flex; gap: 4px;
        margin-top: 8px;
    }
    .pw-bar {
        flex: 1; height: 3px;
        background: rgba(255,255,255,0.07);
        border-radius: 2px;
        transition: background 0.3s;
    }
    .pw-bar.weak   { background: #e2534b; }
    .pw-bar.fair   { background: #e2904b; }
    .pw-bar.good   { background: #4b8ee2; }
    .pw-bar.strong { background: #3bb87a; }

    .pw-strength-label {
        font-size: 0.72rem;
        color: rgba(130,155,200,0.6);
        margin-top: 6px;
        min-height: 14px;
        transition: color 0.3s;
    }

    .pw-match-label {
        font-size: 0.72rem;
        margin-top: 6px;
        min-height: 14px;
    }

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

    .alert-custom {
        background: rgba(180,40,40,0.12);
        border: 1px solid rgba(200,60,60,0.2);
        color: #f87272;
        padding: 11px 13px; border-radius: 9px;
        font-size: 0.8rem; margin-bottom: 20px;
        display: flex; align-items: flex-start; gap: 9px;
        line-height: 1.5;
    }
    .alert-custom ul { margin: 0; padding-left: 16px; }

    .alert-success-custom {
        background: rgba(40,140,80,0.12);
        border: 1px solid rgba(60,180,100,0.2);
        color: #4ade80;
        padding: 11px 13px; border-radius: 9px;
        font-size: 0.8rem; margin-bottom: 20px;
        display: flex; align-items: center; gap: 9px;
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
            @if(session('error'))
                <div class="alert-custom">
                    <i class="fas fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert-success-custom">
                    <i class="fas fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert-custom">
                    <i class="fas fa-circle-exclamation"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.reset-password.post') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token ?? '' }}">

                <div class="field-group">
                    <label class="field-label" for="password">Nouveau mot de passe</label>
                    <div class="field-input-wrap">
                        <input type="password" name="password" id="password" class="field-input" placeholder="••••••••" required oninput="checkStrength(this.value)">
                        <i class="fas fa-lock field-icon"></i>
                    </div>
                    <div class="pw-strength">
                        <div class="pw-bar" id="bar1"></div>
                        <div class="pw-bar" id="bar2"></div>
                        <div class="pw-bar" id="bar3"></div>
                        <div class="pw-bar" id="bar4"></div>
                    </div>
                    <div class="pw-strength-label" id="strength-label"></div>
                </div>

                <div class="field-group" style="margin-bottom:0">
                    <label class="field-label" for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="field-input-wrap">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="field-input" placeholder="••••••••" required oninput="checkMatch()">
                        <i class="fas fa-lock field-icon"></i>
                    </div>
                    <div class="pw-match-label" id="match-label"></div>
                </div>

                <hr class="card-divider">

                <button type="submit" class="btn-login">Réinitialiser le mot de passe</button>
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

<script>
function checkStrength(val) {
    var score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    var bars = ['bar1', 'bar2', 'bar3', 'bar4'];
    var classes = ['', 'weak', 'fair', 'good', 'strong'];
    var labels = ['', 'Faible', 'Moyen', 'Bon', 'Fort'];
    var colors = ['', '#e2534b', '#e2904b', '#4b8ee2', '#3bb87a'];

    bars.forEach(function(id, i) {
        var el = document.getElementById(id);
        el.className = 'pw-bar';
        if (i < score) el.classList.add(classes[score]);
    });

    var lbl = document.getElementById('strength-label');
    lbl.textContent = val.length ? (labels[score] || 'Fort') : '';
    lbl.style.color = colors[score] || '#3bb87a';

    checkMatch();
}

function checkMatch() {
    var p = document.getElementById('password').value;
    var c = document.getElementById('password_confirmation').value;
    var lbl = document.getElementById('match-label');
    if (!c) { lbl.textContent = ''; return; }
    if (p === c) {
        lbl.textContent = 'Les mots de passe correspondent ✓';
        lbl.style.color = '#3bb87a';
    } else {
        lbl.textContent = 'Les mots de passe ne correspondent pas';
        lbl.style.color = '#e2534b';
    }
}
</script>
@endsection