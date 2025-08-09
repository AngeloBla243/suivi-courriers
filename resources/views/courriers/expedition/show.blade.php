@extends('adminlte::page')

@section('title', 'Détail courrier expédition')

@section('content')
    <h3>{{ $courrier->concerne }}</h3>
    <p><strong>Destinataire:</strong> {{ $courrier->destinataire }}</p>
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($courrier->jour_trans)->format('d/m/Y') }}</p>
    <p><strong>Nombre annexes:</strong> {{ $courrier->nbre_annexe }}</p>

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

@stop
