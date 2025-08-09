@extends('adminlte::page')

@section('title', 'Impression courrier réception')

@section('content_header')
    <h1>Impression courrier réception</h1>
@stop

@section('content')
    <p><strong>N° enregistrement :</strong> {{ $courrier->num_enregistrement }}</p>
    <p><strong>Expéditeur :</strong> {{ $courrier->nom_expediteur }}</p>
    <p><strong>Année réception :</strong> {{ $courrier->annee_reception }}</p>
    <p><strong>Mois réception :</strong> {{ $courrier->mois_reception }}</p>
    <p><strong>Date réception :</strong>
        {{ $courrier->date_reception ? \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') : '-' }}
    </p>
    <p><strong>Objet :</strong> {{ $courrier->concerne }}</p>
    <p><strong>Destinataire :</strong> {{ $courrier->destinataire }}</p>
    <p><strong>Observation :</strong> {{ $courrier->observation }}</p>
    <p><strong>Nombre d'annexes :</strong> {{ $courrier->nbre_annexe }}</p>

    <hr>
    <h3>Documents annexes PDF :</h3>

    @if ($courrier->annexes->count())
        @foreach ($courrier->annexes as $annexe)
            <h4>{{ $annexe->label ?? 'Annexe PDF' }}</h4>
            <a href="{{ asset('storage/' . $annexe->filename) }}" target="_blank">
                Télécharger {{ $annexe->label ?? 'Annexe PDF' }}
            </a>
            <br>
            <iframe src="{{ asset('storage/' . $annexe->filename) }}" width="100%" height="600px"
                style="border:1px solid #ddd; margin-top:10px;"></iframe>
            <hr>
        @endforeach
    @else
        <p><em>Aucune annexe PDF</em></p>
    @endif

@stop
