@extends('adminlte::page')

@section('title', 'Courriers reçus')

@section('content_header')
    <h1 class="fw-bold text-primary mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-inbox me-2"></i> Liste des courriers de réception
    </h1>
@stop

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
            --main-red: #e53935;
            --main-grey: #f6fafd;
        }

        /* Carte/form recherche */
        .form-research-courrier {
            background: #fff;
            border-radius: 13px;
            box-shadow: 0 2px 12px rgba(31, 148, 210, 0.07);
            padding: 1.2rem 1.3rem;
            margin-bottom: 1.7rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            align-items: flex-end;
        }

        .form-research-courrier .form-group {
            flex: 1 1 160px;
            min-width: 140px;
        }

        .form-research-courrier .form-control {
            border-radius: 7.5px;
            border: 1.5px solid #e4eef7;
        }

        .form-research-courrier .btn-primary {
            background: linear-gradient(90deg, #ffe243 35%, var(--main-blue) 100%);
            color: #13323c;
            font-weight: 700;
            border: none;
            border-radius: 7px;
            padding: 0.6em 1.5em;
        }

        .form-research-courrier .btn-primary:hover {
            background: linear-gradient(90deg, #fde77a 5%, #369ad0 100%);
            color: #185276;
        }

        .form-research-courrier .btn-secondary {
            background: #eaf2fc;
            color: #1f94d2;
            border-radius: 7px;
            border: none;
            font-weight: 600;
            margin-left: 0.3em;
            padding: 0.62em 1.1em;
        }

        .form-research-courrier .btn-secondary:hover {
            background: #e1eaff;
            color: #12537d;
        }

        /* Bouton nouveau courrier */
        .btn-success {
            background-color: #28b26e;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            padding: 0.52em 1.3em;
            margin-bottom: 1.2rem;
        }

        .btn-success:hover {
            background-color: #209055;
        }

        /* Tableau */
        .table-custom {
            background: #fff;
            border-radius: 13px;
            box-shadow: 0 2px 16px rgba(31, 148, 210, 0.09);
            overflow: hidden;
            border: none;
        }

        .table-custom th {
            background: linear-gradient(90deg, var(--main-blue) 77%, var(--main-yellow) 100%);
            color: #1a1a1a;
            border: none;
            font-weight: 700;
            text-align: center;
            letter-spacing: 1.1px;
            font-size: 1.01rem;
        }

        .table-custom td {
            color: #144e6e;
            background: #fff;
            font-size: 1rem;
            vertical-align: middle;
            border-bottom: 1.7px solid #eaf2fa;
            text-align: center;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        .table-custom tr:hover td {
            background: #e8f2fc !important;
            color: #e53935;
            transition: 0.15s;
        }

        /* Actions */
        .table-custom .btn-group .btn,
        .table-custom .btn {
            border-radius: 7px;
            font-weight: 500;
            margin-right: 0.2em;
        }

        .table-custom .btn-danger {
            background: #e53935 !important;
            border: none;
        }

        .table-custom .btn-danger:hover {
            background: #ad1720 !important;
        }

        .table-custom .btn-warning {
            background: #ffe243 !important;
            color: #1a2761 !important;
            border: none;
        }

        .table-custom .btn-warning:hover {
            background: #fff89a !important;
            color: #964b00 !important;
        }

        .table-custom .btn-info {
            background: #1f94d2 !important;
            color: #fff !important;
            border: none;
        }

        .table-custom .btn-info:hover {
            background: #115c85 !important;
        }

        /* Badges sur dates */
        .date-badge {
            background: var(--main-yellow);
            color: #1f94d2;
            font-weight: 600;
            border-radius: 8px;
            padding: 2px 13px;
            font-size: 1em;
            letter-spacing: 0.04em;
            box-shadow: 0 1.5px 7px rgba(255, 227, 67, 0.13);
            border: none;
            display: inline-block;
        }

        /* Pagination custom compact */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            color: var(--main-blue);
            border-radius: 8px !important;
            border: 1.5px solid #e4eefa;
            font-weight: 600;
            box-shadow: none;
            padding: 0.36em 0.85em;
            background: #fff;
            transition: all .18s;
            font-size: 1em;
        }

        .pagination .page-link:focus {
            color: #fff;
            background: #1f94d2;
            outline: none;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(90deg, #ffe243 60%, #1f94d2 95%);
            color: #144e6e;
            border-color: #ffe243;
            font-weight: 800;
        }

        .pagination .page-link:hover {
            background: #ffe243;
            color: #1f94d2;
            border-color: #ffe243;
        }

        @media (max-width: 768px) {
            .form-research-courrier {
                flex-direction: column;
                gap: .6rem;
                padding: 0.85rem 0.5rem;
            }

            .table-custom th,
            .table-custom td {
                font-size: 0.92rem;
            }

            .pagination {
                font-size: .92em
            }
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Barre de recherche --}}
    <form class="form-research-courrier" method="GET" action="{{ route('courriers.reception.index') }}">
        <div class="form-group">
            <input type="text" name="num_enregistrement" class="form-control" placeholder="N° enregistrement"
                value="{{ request('num_enregistrement') }}">
        </div>
        <div class="form-group">
            <input type="number" name="annee" class="form-control" placeholder="Année (ex: 2024)"
                value="{{ request('annee') }}" min="2000" max="{{ date('Y') }}">
        </div>
        <div class="form-group">
            <select name="mois" class="form-control">
                <option value="">-- Mois --</option>
                @php $mois = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre']; @endphp
                @foreach ($mois as $m)
                    <option value="{{ $m }}" {{ request('mois') === $m ? 'selected' : '' }}>{{ ucfirst($m) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="expediteur" class="form-control" placeholder="Expéditeur"
                value="{{ request('expediteur') }}">
        </div>
        <div class="form-group">
            <input type="text" name="destinataire" class="form-control" placeholder="Destinataire"
                value="{{ request('destinataire') }}">
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
        <a href="{{ route('courriers.reception.index') }}" class="btn btn-secondary">Réinitialiser</a>
    </form>


    {{-- Bouton nouveau courrier --}}
    <a href="{{ route('courriers.reception.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Nouveau courrier réception
    </a>
    <form action="{{ route('courriers.reception.pdf') }}" method="GET" target="_blank" class="mb-3">
        {{-- Reprend tous les inputs de filtre --}}

        <input type="hidden" name="num_enregistrement" value="{{ request('num_enregistrement') }}">
        <input type="hidden" name="annee" value="{{ request('annee') }}">
        <input type="hidden" name="mois" value="{{ request('mois') }}">
        <input type="hidden" name="expediteur" value="{{ request('expediteur') }}">
        <input type="hidden" name="destinataire" value="{{ request('destinataire') }}">

        <button type="submit" class="btn btn-secondary">
            <i class="fas fa-file-pdf"></i> Exporter en PDF
        </button>
    </form>
    {{-- Tableau --}}
    <div class="table-responsive table-custom mb-3">
        <table class="table table-bordered table-striped align-middle mb-0">
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
                        <td><strong>{{ $courrier->num_enregistrement }}</strong></td>
                        <td>{{ $courrier->nom_expediteur }}</td>
                        <td style="max-width:260px;word-break:break-word;">{{ $courrier->concerne }}</td>
                        <td>{{ $courrier->destinataire }}</td>
                        <td>
                            @if ($courrier->date_reception)
                                <span
                                    class="date-badge">{{ \Carbon\Carbon::parse($courrier->date_reception)->format('d/m/Y') }}</span>
                            @else
                                <span class="text-secondary">-</span>
                            @endif
                        </td>
                        <td>{{ $courrier->nbre_annexe }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('courriers.reception.show', $courrier) }}" class="btn btn-info btn-sm"
                                    title="Voir"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('courriers.reception.edit', $courrier) }}" class="btn btn-warning btn-sm"
                                    title="Modifier"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('courriers.reception.destroy', $courrier) }}"
                                    style="display:inline-block" onsubmit="return confirm('Confirmer la suppression ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Supprimer"><i
                                            class="fas fa-trash"></i></button>
                                </form>
                                <a href="{{ route('courriers.reception.print', $courrier) }}" target="_blank"
                                    class="btn btn-secondary btn-sm" title="Imprimer"><i class="fas fa-print"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-3 text-muted fst-italic">
                            <i class="fas fa-inbox-open text-warning me-2"></i>
                            Aucun courrier reçu trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination compacte --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $courriers->onEachSide(1)->appends(request()->all())->links() }}
    </div>
@stop
