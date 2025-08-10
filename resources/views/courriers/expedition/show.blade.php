@extends('adminlte::page')

@section('title', 'Détail courrier expédition')

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
            --main-red: #e53935;
        }

        .card-detail {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(31, 148, 210, 0.08);
            padding: 1.8rem 1.5rem;
            margin-bottom: 2rem;
        }

        .card-detail h3 {
            color: var(--main-blue);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .info-row {
            margin-bottom: 0.8rem;
            font-size: 1.05em;
        }

        .info-label {
            font-weight: 600;
            color: #444;
        }

        .badge-blue {
            background-color: var(--main-blue);
            font-weight: 600;
            color: #fff;
            font-size: .9em;
            border-radius: .4em;
            padding: .45em .7em;
        }

        .badge-yellow {
            background-color: var(--main-yellow);
            font-weight: 700;
            color: var(--main-blue);
            font-size: .9em;
            border-radius: .4em;
            padding: .45em .7em;
        }

        /* Annexes */
        .annex-list {
            list-style: none;
            padding-left: 0;
        }

        .annex-list li {
            margin-bottom: 0.5rem;
            padding: 0.5rem 0.75rem;
            border: 1px solid #eaeaea;
            border-radius: .5em;
            background: #f9fbfd;
            transition: all .15s ease;
            display: flex;
            align-items: center;
            gap: .6em;
        }

        .annex-list li:hover {
            background: #e9f3fb;
            border-color: var(--main-blue);
        }

        .annex-list i {
            font-size: 1.2em;
            color: var(--main-blue);
        }

        .annex-list a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            flex-grow: 1;
        }

        .annex-list a:hover {
            text-decoration: underline;
            color: var(--main-blue);
        }
    </style>

    <div class="card-detail">
        <h3><i class="fas fa-paper-plane me-2"></i>{{ $courrier->concerne }}</h3>

        <div class="info-row">
            <span class="info-label"><i class="fas fa-user me-1 text-secondary"></i>Destinataire :</span>
            <span class="ms-1">{{ $courrier->destinataire }}</span>
        </div>

        <div class="info-row">
            <span class="info-label"><i class="fas fa-calendar-alt me-1 text-secondary"></i>Date :</span>
            <span class="badge-blue">{{ \Carbon\Carbon::parse($courrier->jour_trans)->format('d/m/Y') }}</span>
        </div>

        <div class="info-row">
            <span class="info-label"><i class="fas fa-paperclip me-1 text-secondary"></i>Nombre annexes :</span>
            <span class="badge-yellow">{{ $courrier->nbre_annexe }}</span>
        </div>

        {{-- Liste des PDFs --}}
        <div class="mt-4">
            <h5 class="fw-bold mb-3 text-primary">
                <i class="fas fa-file-pdf me-2"></i>Documents annexes
            </h5>
            @if ($courrier->annexes->count())
                <ul class="annex-list">
                    @foreach ($courrier->annexes as $annexe)
                        <li>
                            <i class="fas fa-file-pdf"></i>
                            <a href="{{ asset('storage/' . $annexe->filename) }}" target="_blank">
                                {{ $annexe->label ?? basename($annexe->filename) }}
                            </a>
                            <a href="{{ asset('storage/' . $annexe->filename) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm" title="Ouvrir">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted fst-italic"><i class="fas fa-info-circle me-1"></i>Aucune annexe</p>
            @endif
        </div>
    </div>
@stop
