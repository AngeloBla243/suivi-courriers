@extends('adminlte::page')

@section('title', 'Liste des utilisateurs')

@section('content_header')
    <h1 class="fw-bold mb-4" style="color:#1f94d2!important;">
        <i class="fas fa-users me-2"></i> Utilisateurs
    </h1>
@stop

@section('content')
    <style>
        :root {
            --main-blue: #1f94d2;
            --main-yellow: #ffe243;
        }

        /* Search input group */
        .user-search-group .form-control {
            border-radius: 7px 0 0 7px;
            border: 1.5px solid #e4eef7;
            font-size: 1.07rem;
            box-shadow: none;
        }

        .user-search-group .btn-outline-primary {
            border-radius: 0 7px 7px 0;
            border: 1.5px solid #1f94d2;
            color: var(--main-blue);
            font-weight: 600;
            background: #fff;
            transition: all .18s;
        }

        .user-search-group .btn-outline-primary:hover {
            background: var(--main-blue);
            color: #fff;
        }

        /* Tableau */
        .user-table {
            background: #fff;
            border-radius: 11px;
            box-shadow: 0 3px 14px rgba(31, 148, 210, 0.07);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .user-table th {
            background: linear-gradient(90deg, var(--main-blue) 75%, var(--main-yellow) 100%);
            color: #1b1b1b;
            font-weight: 700;
            border: none;
            text-align: center;
        }

        .user-table td {
            vertical-align: middle;
            text-align: center;
            color: #144e6e;
            border-bottom: 1.5px solid #f0f5fa;
            background: #fff;
        }

        .user-table tr:last-child td {
            border-bottom: none;
        }

        .user-table tbody tr:hover td {
            background: #e8f2fc !important;
            color: var(--main-blue);
            transition: 0.17s;
        }

        /* Photo ronde */
        .img-thumbnail.rounded-circle {
            border: 2.5px solid var(--main-blue);
            box-shadow: 0 1.5px 7px rgba(31, 148, 210, 0.08);
            object-fit: cover;
        }

        /* Boutons actions */
        .btn-sm {
            border-radius: 8px;
            font-weight: 500;
            min-width: 80px;
            margin-right: 2px;
        }

        .btn-warning {
            background: var(--main-yellow);
            color: #1f94d2;
            border: none;
        }

        .btn-warning:hover {
            background: #fff89a;
            color: #d15a1e;
        }

        .btn-danger {
            background: #e53935;
            border: none;
        }

        .btn-danger:hover {
            background: #ad1720;
        }

        /* Pagination compact */
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
            padding: 0.36em 0.85em;
            background: #fff;
            transition: all .18s;
            font-size: 1em;
        }

        .pagination .page-link:focus {
            color: #fff;
            background: var(--main-blue);
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

            .user-table th,
            .user-table td {
                font-size: .98em;
            }

            .btn-sm {
                min-width: 60px;
                font-size: .96em;
            }

            .pagination {
                font-size: .93em
            }
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <form method="GET" action="{{ route('admin.users') }}" class="mb-3">
        <div class="input-group user-search-group">
            <input type="search" name="search" class="form-control" placeholder="Rechercher par nom ou email"
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Rechercher</button>
        </div>
    </form>

    <div class="table-responsive user-table">
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge"
                                style="background:
                                 {{ $user->role === 'admin' ? '#1f94d2' : ($user->role === 'secretaire' ? '#ffe243' : '#ececec') }};
                                 color:{{ $user->role === 'secretaire' ? '#1f94d2' : '#fff' }}; font-weight:700;">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if ($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" width="48"
                                    height="48" class="img-thumbnail rounded-circle">
                            @else
                                <span class="text-muted fst-italic">Aucune photo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning"
                                title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.delete', $user) }}" method="POST"
                                style="display:inline-block"
                                onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted fst-italic py-3">
                            <i class="fas fa-user-times me-2"></i> Aucun utilisateur trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3 d-flex justify-content-center">
        {{ $users->onEachSide(1)->links() }}
    </div>
@stop
