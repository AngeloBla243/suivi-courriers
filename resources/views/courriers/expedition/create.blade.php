@extends('adminlte::page')

@section('title', 'Nouveau courrier expédition')

@section('content_header')
    <h1 class="fw-bold mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-paper-plane me-2"></i> Créer un courrier d'expédition
    </h1>
@stop

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
        }

        .card-form {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(31, 148, 210, 0.08);
            padding: 1.8rem 1.5rem;
            margin-bottom: 2rem;
        }

        .form-label {
            color: var(--main-blue);
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 0.69em;
            border: 1.7px solid #e4eef7;
            box-shadow: none;
            font-size: 1.05em;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--main-blue);
            box-shadow: 0 2px 8px rgba(31, 148, 210, 0.08);
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--main-yellow) 14%, var(--main-blue) 100%);
            color: #173853;
            border-radius: 25px;
            font-weight: 700;
            padding: 0.65em 2em;
            font-size: 1.07em;
            border: none;
            margin-right: .5em;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, var(--main-yellow) 6%, #1375a6 100%);
            color: #fff;
        }

        .btn-secondary {
            border-radius: 25px;
            font-weight: 600;
            background: #eaeaea;
            color: var(--main-blue);
        }

        @media (max-width:600px) {
            .card-form {
                padding: 1.2rem 0.8rem;
            }

            h1 {
                font-size: 1.3rem;
            }
        }
    </style>

    <div class="card-form">
        <form method="POST" action="{{ route('courriers.expedition.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Inclusion du formulaire commun --}}
            @include('courriers.expedition._form', ['submit_text' => 'Enregistrer'])
        </form>
    </div>
@stop
