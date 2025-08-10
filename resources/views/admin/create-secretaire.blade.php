@extends('adminlte::page')

@section('title', 'Créer un Secrétaire')

@section('content_header')
    <h1 class="fw-bold mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-user-plus me-2"></i> Créer un utilisateur Secrétaire
    </h1>
@stop

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
        }

        .card-create {
            max-width: 500px;
            margin: 0 auto 2.3rem auto;
            border-radius: 1rem;
            box-shadow: 0 4px 18px rgba(31, 148, 210, 0.11);
            padding: 2.2rem 1.5rem 1.4rem 1.5rem;
            background: #fff;
            border: none;
        }

        .card-create label {
            color: var(--main-blue);
            font-weight: 600;
            margin-bottom: .35rem;
        }

        .card-create .form-control,
        .card-create .form-control-file {
            border-radius: 10px;
            border: 1.7px solid #e4eef7;
            font-size: 1.08em;
            margin-bottom: 0.4rem;
            box-shadow: none;
            transition: border-color 0.17s;
        }

        .card-create .form-control:focus {
            outline: none;
            border-color: var(--main-blue);
            box-shadow: 0 2px 12px rgba(31, 148, 210, 0.13);
        }

        .form-group {
            margin-bottom: 1.22rem;
        }

        .btn-primary {
            background-color: var(--main-blue);
            border-color: var(--main-blue);
            font-weight: 700;
            border-radius: 22px;
            padding: 0.68em 2.1em;
            font-size: 1.09em;
            transition: background 0.16s;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: #1668a7;
            border-color: #1668a7;
        }

        .text-danger {
            font-size: .95em;
            margin-top: 2px;
        }

        /* Success alert custom */
        .alert-success {
            border-radius: 9px;
            border-left: 5px solid var(--main-blue);
            background: #e8f7ff;
            color: #1668a7;
            font-weight: 600;
        }

        @media (max-width:600px) {
            .card-create {
                padding: 1.2rem 0.6rem 0.8rem 0.6rem;
            }

            h1 {
                font-size: 1.25rem;
            }
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="card-create mt-2">
        <form action="{{ route('admin.secretaire.store') }}" method="POST" enctype="multipart/form-data"
            autocomplete="off">
            @csrf
            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required autocomplete="new-password">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Confirmer mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Photo de profil <span class="text-secondary">(optionnel)</span></label>
                <input type="file" name="photo" class="form-control-file">
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-user-plus me-2"></i>Créer</button>
        </form>
    </div>
@stop
