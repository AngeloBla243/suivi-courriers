@extends('adminlte::page')

@section('title', 'Détail courrier réception')

@section('content_header')
    <h1>Détail du courrier réception</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>N° enregistrement :</strong> {{ $courrier->num_enregistrement }}</p>
            <p><strong>Expéditeur :</strong> {{ $courrier->nom_expediteur }}</p>
            <p><strong>Année réception :</strong> {{ $courrier->annee_reception }}</p>
            <p><strong>Mois réception :</strong> {{ $courrier->mois_reception }}</p>
            <p><strong>Date réception :</strong>
                {{ $courrier->date_reception ? \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') : '-' }}
            </p>
            <p><strong>Objet :</strong> {{ $courrier->concerne }}</p>
            <p><strong>Destinataire :</strong> {{ $courrier->destinataire }}</p>
            <p><strong>Nombre annexes :</strong> {{ $courrier->nbre_annexe }}</p>
            <p><strong>Observation :</strong> {{ $courrier->observation }}</p>

            {{-- Liste des PDFs --}}
            <h4>Documents annexes :</h4>
            @if ($courrier->annexes->count())
                <ul>
                    @foreach ($courrier->annexes as $annexe)
                        <li>
                            <a href="{{ asset('storage/' . $annexe->filename) }}" target="_blank">
                                {{ $annexe->label ?? basename($annexe->filename) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p><em>Aucune annexe</em></p>
            @endif

        </div>
    </div>

    <a href="{{ route('courriers.reception.edit', $courrier) }}" class="btn btn-warning">Modifier</a>
    <a href="{{ route('courriers.reception.index') }}" class="btn btn-secondary">Retour à la liste</a>
    <a href="{{ route('courriers.reception.print', $courrier) }}" target="_blank" class="btn btn-info">Imprimer</a>
@stop
