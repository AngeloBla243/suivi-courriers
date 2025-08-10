@extends('adminlte::page')

@section('title', 'Liste des courriers')

@section('content_header')
    <h1 class="fw-bold text-primary mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-envelope me-2"></i> Liste des courriers
    </h1>
@stop

@section('content')
    <style>
        /* Couleurs principales inspirées du blason RDC Douanes : bleu, jaune, rouge */
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
            --main-red: #e53935;
            --main-grey: #f6fafd;
        }

        .custom-card {
            background: var(--main-grey);
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(31, 148, 210, 0.07);
            padding: 1.55rem 2rem 1.5rem 2rem;
            margin-bottom: 2.1rem;
            border: 1px solid #e7f1f6;
        }

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
        }

        .stylish-table td {
            color: #144e6e;
            background: #fff;
            font-size: 1rem;
            vertical-align: middle;
            border-bottom: 1.7px solid #eaf2fa;
        }

        .stylish-table tr:last-child td {
            border-bottom: none;
        }

        .stylish-table tr:hover td {
            background: #e8f2fc !important;
            color: #e53935;
            transition: 0.15s;
        }

        .table thead th,
        .table tbody td {
            text-align: center;
        }

        .form-search-courrier {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(31, 148, 210, 0.07);
            padding: 1.3rem 1rem;
            margin-bottom: 2.1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            align-items: end;
        }

        .form-search-courrier .form-control,
        .form-search-courrier .btn {
            font-size: 1rem;
            border-radius: 8px;
            box-shadow: none;
        }

        .form-search-courrier .btn-primary {
            background: linear-gradient(90deg, #ffe243 40%, var(--main-blue) 90%);
            border: none;
            color: #163013;
            font-weight: 700;
            transition: background 0.2s;
        }

        .form-search-courrier .btn-primary:hover {
            background: linear-gradient(90deg, #eae399 10%, #1f94d2 100%);
            color: #fff;
        }

        /* Pagination boost */
        .pagination .page-item.active .page-link {
            background-color: var(--main-blue);
            border-color: var(--main-yellow);
            color: #fff;
            font-weight: 600;
        }

        .pagination .page-link {
            color: var(--main-blue);
        }

        /* ---- Pagination compacte & harmonisée ---- */
        .pagination {
            margin-bottom: 0;
            --bs-pagination-bg: #fff;
            --bs-pagination-border-color: #1f94d2;
            --bs-pagination-hover-bg: #eaf4fb;
            --bs-pagination-active-bg: #1f94d2;
            --bs-pagination-active-border-color: #ffe243;
        }

        .pagination .page-item {
            margin: 0 3px;
        }

        .pagination .page-link {
            color: #1f94d2;
            border-radius: 8px !important;
            border: 1px solid #dce9f4;
            font-weight: 600;
            padding: 0.4em 0.85em;
            transition: all .2s ease;
        }

        .pagination .page-link:hover {
            background-color: #ffe243;
            color: #1f94d2;
            border-color: #ffe243;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(90deg, #ffe243 35%, #1f94d2 100%);
            color: #fff;
            border-color: #ffe243;
            font-weight: 700;
        }

        @media (max-width: 576px) {
            .pagination {
                flex-wrap: wrap;
                font-size: .9rem;
            }

            .pagination .page-link {
                padding: 0.3em 0.65em;
            }
        }


        /* Responsive */
        @media (max-width: 768px) {

            .custom-card,
            .stylish-table {
                padding: .2rem 0.2rem;
            }

            .stylish-table th,
            .stylish-table td {
                font-size: 0.92rem;
            }

            .form-search-courrier {
                flex-direction: column;
                gap: .5rem;
                padding: 1rem .5rem;
            }
        }
    </style>

    {{-- Carte Recherche --}}
    <div class="custom-card">
        <form method="GET" action="{{ route('admin.courriers.index') }}" class="form-search-courrier">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Recherche (numéro, expéditeur...)" class="form-control me-2 flex-grow-1"
                style="max-width:270px;">
            <input type="text" name="annee" value="{{ request('annee') }}" placeholder="Année"
                class="form-control me-2" style="width:120px;">
            <input type="text" name="mois" value="{{ request('mois') }}" placeholder="Mois" class="form-control me-2"
                style="width:120px;">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-search"></i> Rechercher
            </button>
        </form>
    </div>

    {{-- Tableau --}}
    <div class="table-responsive stylish-table mb-3">
        <table class="table stylish-table align-middle mb-0">
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
                        <td class="fw-bold">{{ $courrier->num_enregistrement }}</td>
                        <td>{{ $courrier->nom_expediteur }}</td>
                        <td>{{ $courrier->destinataire }}</td>
                        <td style="max-width:330px;word-break:break-word;">{{ $courrier->concerne }}</td>
                        <td>
                            <span class="badge" style="background:#ffe243;color:#1f94d2;font-weight:700;">
                                {{ optional($courrier->date_reception ?? $courrier->jour_trans)->format('d/m/Y') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <span class="text-secondary fst-italic">
                                <i class="far fa-envelope-open text-warning me-2"></i>
                                Aucun courrier trouvé.
                            </span>
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
