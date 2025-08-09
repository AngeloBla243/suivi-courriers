@extends('adminlte::page')

@section('title', 'Courriers Expédition')

@section('content_header')
    <h1>Liste des courriers d'expédition</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('courriers.expedition.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nouveau courrier
    </a>

    @include('courriers._filters')

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Réf</th>
                <th>Objet</th>
                <th>Destinataire</th>
                <th>Date</th>
                <th>Annexes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courriers as $courrier)
                <tr>
                    <td>{{ $courrier->num_reference }}</td>
                    <td>{{ $courrier->concerne }}</td>
                    <td>{{ $courrier->destinataire }}</td>
                    <td>{{ \Carbon\Carbon::parse($courrier->jour_trans)->format('d/m/Y') }}</td>
                    <td>{{ $courrier->nbre_annexe }}</td>
                    <td>
                        <a href="{{ route('courriers.expedition.show', $courrier) }}" class="btn btn-info btn-sm">Voir</a>
                        <a href="{{ route('courriers.expedition.edit', $courrier) }}"
                            class="btn btn-warning btn-sm">Modifier</a>
                        <a href="{{ route('courriers.expedition.print', $courrier) }}" target="_blank"
                            class="btn btn-secondary btn-sm">Print</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucun courrier trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $courriers->links() }}
@stop
