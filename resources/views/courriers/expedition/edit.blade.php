@extends('adminlte::page')

@section('title', 'Modifier courrier expédition')

@section('content_header')
    <h1 class="fw-bold mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-edit me-2"></i>
        Modifier courrier : {{ $courrier->num_reference }}
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
            padding: 1.9rem 1.5rem;
            margin-bottom: 2.1rem;
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
            font-size: 1.06em;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--main-blue);
            box-shadow: 0 2px 8px rgba(31, 148, 210, 0.09);
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--main-yellow) 14%, var(--main-blue) 100%);
            color: #173853;
            border-radius: 25px;
            font-weight: 700;
            padding: 0.62em 2em;
            font-size: 1.07em;
            border: none;
            margin-right: .5em;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #ffe243 6%, #1f94d2 100%);
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
                padding: 1.02rem 0.5rem;
            }

            h1 {
                font-size: 1.2rem;
            }
        }
    </style>

    <div class="card-form">
        <form method="POST" action="{{ route('courriers.expedition.update', $courrier) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('courriers.expedition._form', ['submit_text' => 'Mettre à jour'])
        </form>
    </div>
@stop
