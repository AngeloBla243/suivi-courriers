@extends('adminlte::page')

@section('title', 'Liste des courriers')

@section('content_header')
    <h1>Liste des courriers</h1>
@stop

@section('content')
    <form method="GET" action="{{ route('admin.courriers.index') }}" class="form-inline mb-3">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Recherche (num enregistrement, expéditeur...)" class="form-control mr-2">
        <input type="text" name="annee" value="{{ request('annee') }}" placeholder="Année" class="form-control mr-2"
            style="width:100px;">
        <input type="text" name="mois" value="{{ request('mois') }}" placeholder="Mois" class="form-control mr-2"
            style="width:120px;">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Numéro d'enregistrement</th>
                <th>Expéditeur</th>
                <th>Destinataire</th>
                <th>Objet</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courriers as $courrier)
                <tr>
                    <td>{{ $courrier->num_enregistrement }}</td>
                    <td>{{ $courrier->nom_expediteur }}</td>
                    <td>{{ $courrier->destinataire }}</td>
                    <td>{{ $courrier->concerne }}</td>
                    <td>{{ optional($courrier->date_reception ?? $courrier->jour_trans)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucun courrier trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $courriers->appends(request()->all())->links() }}

@stop
