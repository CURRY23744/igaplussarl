@extends('admin.layouts.layout-auth')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Réinitialiser le mot de passe</h4>
                </div>
                <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('admin.reset-password') }}" method="POST">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token ?? '' }}">

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Réinitialiser le mot de passe</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('admin.login') }}">Retour à la connexion</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
