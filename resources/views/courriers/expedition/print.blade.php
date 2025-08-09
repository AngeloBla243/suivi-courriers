@extends('adminlte::page')

@section('title', 'Impression courrier expédition')

@section('content')
    <h2>{{ $courrier->concerne }}</h2>
    <p><strong>Destinataire :</strong> {{ $courrier->destinataire }}</p>
    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($courrier->jour_trans)->format('d/m/Y') }}</p>
    <p><strong>Référence :</strong> {{ $courrier->num_reference }}</p>
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
