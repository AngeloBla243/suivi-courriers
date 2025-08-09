@extends('adminlte::page')

@section('title', 'Nouveau courrier réception')

@section('content_header')
    <h1>Créer un courrier (Réception)</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('courriers.reception.store') }}" enctype="multipart/form-data">
        @csrf
        @include('courriers.reception._form', ['submit_text' => 'Enregistrer'])

    </form>
@stop
