@extends('adminlte::page')

@section('title', 'Impression courrier réception')

@section('content_header')
    <h1 class="fw-bold mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-print me-2"></i> Impression courrier réception
    </h1>
@stop

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
            --main-red: #e53935;
        }

        .print-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 3px 18px rgba(31, 148, 210, 0.08);
            padding: 2rem;
        }

        .info-row {
            margin-bottom: 0.6rem;
            font-size: 1.05em;
        }

        .info-label {
            font-weight: 600;
            color: #333;
        }

        .badge-blue {
            background-color: var(--main-blue);
            font-weight: 600;
            color: #fff;
            padding: .4em .7em;
            border-radius: 0.4em;
        }

        .badge-yellow {
            background-color: var(--main-yellow);
            font-weight: 700;
            color: var(--main-blue);
            padding: .4em .7em;
            border-radius: 0.4em;
        }

        .pdf-container {
            margin-top: 1.2rem;
            margin-bottom: 2rem;
        }

        .pdf-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--main-blue);
            margin-bottom: 0.3rem;
        }

        .pdf-link {
            display: inline-block;
            margin-bottom: 0.6rem;
            text-decoration: none;
            font-weight: 500;
            color: var(--main-blue);
        }

        .pdf-link:hover {
            text-decoration: underline;
            color: #125e88;
        }

        iframe {
            border: 1px solid #ddd;
            border-radius: 0.5em;
        }

        @media print {

            .btn,
            .content-header,
            .main-header,
            .main-sidebar {
                display: none !important;
            }

            .print-card {
                box-shadow: none;
                border: none;
            }
        }
    </style>

    <div class="print-card">
        <div class="info-row">
            <span class="info-label"><i class="fas fa-hashtag me-1"></i>N° enregistrement :</span>
            {{ $courrier->num_enregistrement }}
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-user me-1"></i>Expéditeur :</span>
            {{ $courrier->nom_expediteur }}
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-calendar-alt me-1"></i>Année réception :</span>
            <span class="badge-blue">{{ $courrier->annee_reception }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-calendar me-1"></i>Mois réception :</span>
            <span class="badge-yellow">{{ ucfirst($courrier->mois_reception) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-calendar-day me-1"></i>Date réception :</span>
            {{ $courrier->date_reception ? \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') : '-' }}
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-tag me-1"></i>Objet :</span>
            {{ $courrier->concerne }}
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-user-tie me-1"></i>Destinataire :</span>
            {{ $courrier->destinataire }}
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-sticky-note me-1"></i>Observation :</span>
            {{ $courrier->observation ?? '-' }}
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-paperclip me-1"></i>Nombre d'annexes :</span>
            <span class="badge-yellow">{{ $courrier->nbre_annexe }}</span>
        </div>

        <hr class="my-4">
        <h4 class="fw-bold mb-3 text-primary">
            <i class="fas fa-file-pdf me-2"></i> Documents annexes PDF
        </h4>

        @if ($courrier->annexes->count())
            @foreach ($courrier->annexes as $annexe)
                <div class="pdf-container">
                    <div class="pdf-title">{{ $annexe->label ?? 'Annexe PDF' }}</div>
                    <a href="{{ asset('storage/' . $annexe->filename) }}" target="_blank" class="pdf-link">
                        <i class="fas fa-download me-1"></i> Télécharger le PDF
                    </a>
                    <iframe src="{{ asset('storage/' . $annexe->filename) }}" width="100%" height="550px"></iframe>
                </div>
            @endforeach
        @else
            <p class="text-muted fst-italic"><i class="fas fa-info-circle me-1"></i> Aucune annexe PDF</p>
        @endif
    </div>

    {{-- Bouton imprimer uniquement à l'écran --}}
    <div class="mt-4">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print me-1"></i> Imprimer
        </button>
    </div>
@stop
