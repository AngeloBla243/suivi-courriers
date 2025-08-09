@extends('adminlte::page')

@section('title', 'Modifier courrier expédition')

@section('content_header')
    <h1>Modifier courrier : {{ $courrier->num_reference }}</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('courriers.expedition.update', $courrier) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('courriers.expedition._form', ['submit_text' => 'Mettre à jour'])
    </form>
@stop
