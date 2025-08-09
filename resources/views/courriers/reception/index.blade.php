@extends('adminlte::page')

@section('title', 'Courriers reçus')

@section('content_header')
    <h1>Liste des courriers de réception</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="form-inline mb-3" method="GET" action="{{ route('courriers.reception.index') }}">
        <div class="form-group mr-2 mb-2">
            <input type="text" name="num_enregistrement" class="form-control" placeholder="N° enregistrement"
                value="{{ request('num_enregistrement') }}">
        </div>
        <div class="form-group mr-2 mb-2">
            <input type="number" name="annee" class="form-control" placeholder="Année (ex: 2024)"
                value="{{ request('annee') }}" min="2000" max="{{ date('Y') }}">
        </div>
        <div class="form-group mr-2 mb-2">
            <select name="mois" class="form-control">
                <option value="">-- Mois --</option>
                @php
                    $mois = [
                        'janvier',
                        'février',
                        'mars',
                        'avril',
                        'mai',
                        'juin',
                        'juillet',
                        'août',
                        'septembre',
                        'octobre',
                        'novembre',
                        'décembre',
                    ];
                @endphp
                @foreach ($mois as $m)
                    <option value="{{ $m }}" {{ request('mois') === $m ? 'selected' : '' }}>{{ ucfirst($m) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mr-2 mb-2">
            <input type="text" name="expediteur" class="form-control" placeholder="Expéditeur"
                value="{{ request('expediteur') }}">
        </div>
        <div class="form-group mr-2 mb-2">
            <input type="text" name="destinataire" class="form-control" placeholder="Destinataire"
                value="{{ request('destinataire') }}">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Rechercher</button>
        <a href="{{ route('courriers.reception.index') }}" class="btn btn-secondary mb-2 ml-2">Réinitialiser</a>
    </form>

    <a href="{{ route('courriers.reception.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Nouveau courrier réception
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>N° enreg.</th>
                <th>Expéditeur</th>
                <th>Objet</th>
                <th>Destinataire</th>
                <th>Date réception</th>
                <th>Annexes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courriers as $courrier)
                <tr>
                    <td>{{ $courrier->num_enregistrement }}</td>
                    <td>{{ $courrier->nom_expediteur }}</td>
                    <td>{{ $courrier->concerne }}</td>
                    <td>{{ $courrier->destinataire }}</td>
                    <td>{{ $courrier->date_reception ? \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') : '-' }}
                    </td>
                    <td>{{ $courrier->nbre_annexe }}</td>
                    <td>
                        <a href="{{ route('courriers.reception.show', $courrier) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('courriers.reception.edit', $courrier) }}"
                            class="btn btn-warning btn-sm">Modifier</a>
                        <form method="POST" action="{{ route('courriers.reception.destroy', $courrier) }}"
                            style="display:inline-block" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                        <a href="{{ route('courriers.reception.print', $courrier) }}" target="_blank"
                            class="btn btn-secondary btn-sm">Imprimer</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Aucun courrier reçu trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $courriers->appends(request()->all())->links() }}
@stop
