@extends('adminlte::page')

@section('title', 'Modifier utilisateur')

@section('content_header')
    <h1>Modifier {{ $user->name }}</h1>
@stop

@section('content')

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label>Photo (optionnel)</label>
            <input type="file" name="photo" class="form-control-file">
            @error('photo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            @if ($user->photo)
                <br>
                <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" width="100"
                    class="img-thumbnail rounded-circle mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>

@stop
