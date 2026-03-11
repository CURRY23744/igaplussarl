@extends('admin.layouts.layout-auth')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Mot de passe oublié</h4>
                </div>
                <div class="card-body">

                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form action="{{ route('admin.forgot-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Envoyer le lien de réinitialisation</button>
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
