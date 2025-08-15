@extends('adminlte::page')

@section('title', 'Liste des courriers')

@section('content_header')
    <h1 class="fw-bold text-primary mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-envelope me-2"></i> Liste des courriers
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

        /* Conteneur carte recherche */
        .custom-card {
            background: var(--main-grey);
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(31, 148, 210, 0.07);
            padding: 1.55rem 2rem 1.5rem 2rem;
            margin-bottom: 2.1rem;
            border: 1px solid #e7f1f6;
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            align-items: end;
        }

        .custom-card .form-control,
        .custom-card .btn {
            font-size: 1rem;
            border-radius: 8px;
            box-shadow: none;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--main-yellow) 40%, var(--main-blue) 90%);
            border: none;
            color: #163013;
            font-weight: 700;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #eae399 10%, #1f94d2 100%);
            color: #fff;
        }

        /* Tableau stylé */
        .stylish-table {
            background: #fff;
            border-radius: 13px;
            box-shadow: 0 2px 16px rgba(31, 148, 210, 0.06);
            overflow: hidden;
            border: none;
        }

        .stylish-table th {
            background: linear-gradient(90deg, var(--main-blue) 70%, var(--main-yellow) 100%);
            color: #1a1a1a;
            border: none;
            font-weight: 700;
            text-align: center;
            letter-spacing: 1px;
            font-size: 1.01rem;
            white-space: nowrap;
        }

        .stylish-table td {
            color: #144e6e;
            background: #fff;
            font-size: 1rem;
            vertical-align: middle;
            border-bottom: 1.7px solid #eaf2fa;
            white-space: normal;
        }

        .stylish-table tr:last-child td {
            border-bottom: none;
        }

        .stylish-table tr:hover td {
            background: #e8f2fc !important;
            color: var(--main-red);
            transition: 0.15s;
        }

        .table thead th,
        .table tbody td {
            text-align: center;
        }

        /* Responsive pour recherche */
        @media (max-width: 768px) {
            .custom-card {
                padding: .8rem 1rem;
                gap: 0.5rem;
            }

            .custom-card .form-control,
            .custom-card .btn {
                font-size: 0.95rem;
            }

            .stylish-table th,
            .stylish-table td {
                font-size: 0.92rem;
                padding: 0.35rem 0.5rem;
            }
        }

        /* Responsive tableau scroll horizontal */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>

    {{-- Recherche --}}
    <div class="custom-card">
        <form method="GET" action="{{ route('admin.courriers.index') }}"
            class="d-flex flex-wrap gap-2 align-items-end w-100">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Recherche (numéro, expéditeur...)" class="form-control me-2" style="max-width: 280px;">
            <input type="text" name="annee" value="{{ request('annee') }}" placeholder="Année"
                class="form-control me-2" style="width: 110px;">
            <input type="text" name="mois" value="{{ request('mois') }}" placeholder="Mois" class="form-control me-2"
                style="width: 110px;">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </form>
    </div>

    {{-- Tableau --}}
    <div class="table-responsive stylish-table mb-3">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Numéro d'enregistrement</th>
                    <th style="min-width: 150px;">Expéditeur</th>
                    <th style="min-width: 150px;">Destinataire</th>
                    <th style="min-width: 300px;">Objet</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courriers as $courrier)
                    <tr>
                        <td class="fw-bold">{{ $courrier->num_enregistrement }}</td>
                        <td>{{ $courrier->nom_expediteur }}</td>
                        <td>{{ $courrier->destinataire }}</td>
                        <td style="max-width:330px;word-break:break-word;">{{ $courrier->concerne }}</td>
                        <td>
                            <span class="badge"
                                style="background: var(--main-yellow); color: var(--main-blue); font-weight:700;">
                                {{ optional($courrier->date_reception ?? $courrier->jour_trans)->format('d/m/Y') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-secondary fst-italic">
                            <i class="far fa-envelope-open text-warning me-2"></i> Aucun courrier trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $courriers->onEachSide(1)->appends(request()->all())->links() }}
    </div>


@stop

@section('js')
    <script>
        // Possibilité JS moderne : focus 1er champ automatiquement
        document.querySelector('.form-search-courrier input[type="text"]')?.focus();
    </script>
@stop
