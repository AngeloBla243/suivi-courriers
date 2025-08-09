@extends('adminlte::page')

@section('title', 'Nouveau courrier expédition')

@section('content_header')
    <h1>Créer un courrier d'expédition</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('courriers.expedition.store') }}" enctype="multipart/form-data">
        @csrf
        @include('courriers.expedition._form', ['submit_text' => 'Enregistrer'])

    </form>
@stop
