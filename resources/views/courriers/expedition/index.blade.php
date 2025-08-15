@extends('adminlte::page')

@section('title', 'Courriers Expédition')

@section('content_header')
    <h1 class="fw-bold text-primary" style="color:#1f94d2!important;">
        <i class="fas fa-shipping-fast me-2"></i> Liste des courriers d'expédition
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

        /* Conteneur et style tableau */
        .table-custom {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(31, 148, 210, 0.08);
        }

        .table-custom thead th {
            background: linear-gradient(90deg, var(--main-blue) 70%, var(--main-yellow) 100%);
            color: #111;
            font-weight: 700;
            text-align: center;
            border: none;
            white-space: nowrap;
        }

        .table-custom tbody td {
            vertical-align: middle;
            color: #144e6e;
            background: #fff;
            font-size: 1rem;
            border-bottom: 1.7px solid #eaf2fa;
            white-space: normal;
            word-wrap: break-word;
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .table-custom tbody tr:hover {
            background-color: #e8f2fc;
            color: var(--main-red);
            transition: 0.2s;
        }

        /* Boutons actions */
        .btn-sm {
            border-radius: 8px;
            font-weight: 500;
            min-width: 72px;
            margin-right: 4px;
            white-space: nowrap;
            padding: 0.3em 0.6em;
        }

        /* Pagination */
        .pagination {
            --bs-pagination-hover-bg: #e8f2fc;
            --bs-pagination-active-bg: var(--main-blue);
            --bs-pagination-active-border-color: var(--main-yellow);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--main-blue);
            border-color: var(--main-yellow);
            color: #fff;
            font-weight: 700;
        }

        .pagination .page-link {
            color: var(--main-blue);
            border-radius: 6px !important;
        }

        .pagination .page-link:hover {
            background-color: var(--main-yellow);
            color: #000;
        }

        /* Responsive - table scroll horizontal */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Responsive - ajustements des tailles et paddings */
        @media (max-width: 991.98px) {

            .table-custom thead th,
            .table-custom tbody td {
                font-size: 0.9rem;
                padding: 0.4rem 0.7rem;
                white-space: normal;
            }

            .btn-sm {
                min-width: 60px;
                font-size: 0.9rem;
                padding: 0.25em 0.5em;
            }
        }

        @media (max-width: 575.98px) {

            .table-custom thead th,
            .table-custom tbody td {
                font-size: 0.85rem;
                padding: 0.3rem 0.5rem;
                white-space: normal;
                word-break: break-word;
            }

            .btn-sm {
                min-width: 48px;
                font-size: 0.8rem;
                padding: 0.2em 0.45em;
            }
        }
    </style>


    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    {{-- Bouton Nouveau --}}
    <a href="{{ route('courriers.expedition.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nouveau courrier
    </a>

    {{-- Filtres --}}
    @include('courriers._filters')

    <form action="{{ route('courriers.expedition.pdf') }}" method="GET" target="_blank" class="mb-3">
        <input type="hidden" name="num_reference" value="{{ request('num_reference') }}">
        <input type="hidden" name="annee" value="{{ request('annee') }}">
        <input type="hidden" name="mois" value="{{ request('mois') }}">
        <input type="hidden" name="expediteur" value="{{ request('expediteur') }}">
        <input type="hidden" name="destinataire" value="{{ request('destinataire') }}">

        <button type="submit" class="btn btn-secondary">
            <i class="fas fa-file-pdf"></i> Exporter en PDF
        </button>
    </form>


    {{-- Tableau --}}
    <div class="table-responsive table-custom">
        <table class="table table-bordered mb-0">
            <thead>
                <tr>
                    <th style="min-width: 300px;">Réf</th>
                    <th style="min-width: 300px;">Objet</th>
                    <th style="min-width: 300px;">Destinataire</th>
                    <th style="min-width: 300px;">Date</th>
                    <th style="min-width: 200px;">Annexes</th>
                    <th style="min-width: 300px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courriers as $courrier)
                    <tr>
                        <td class="fw-semibold text-center">{{ $courrier->num_reference }}</td>
                        <td>{{ $courrier->concerne }}</td>
                        <td>{{ $courrier->destinataire }}</td>
                        <td class="text-center">
                            <span class="badge"
                                style="background:var(--main-yellow);color:var(--main-blue);font-weight:700;">
                                {{ \Carbon\Carbon::parse($courrier->jour_trans)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td class="text-center">{{ $courrier->nbre_annexe }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('courriers.expedition.show', $courrier) }}"
                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('courriers.expedition.edit', $courrier) }}"
                                    class="btn btn-warning btn-sm text-white"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('courriers.expedition.print', $courrier) }}" target="_blank"
                                    class="btn btn-secondary btn-sm"><i class="fas fa-print"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3 fst-italic">Aucun courrier trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $courriers->onEachSide(1)->links() }}
    </div>
@stop
