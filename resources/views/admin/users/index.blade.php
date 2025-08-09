@extends('adminlte::page')

@section('title', 'Liste des utilisateurs')

@section('content_header')
    <h1>Utilisateurs</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.users') }}" class="mb-3">
        <div class="input-group">
            <input type="search" name="search" class="form-control" placeholder="Rechercher par nom ou email"
                value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-primary">Rechercher</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
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
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td>
                        @if ($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" width="50" height="50"
                                class="img-thumbnail rounded-circle">
                        @else
                            <span>Aucune photo</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Modifier</a>

                        <form action="{{ route('admin.users.delete', $user) }}" method="POST" style="display:inline-block"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Aucun utilisateur trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}

@stop
