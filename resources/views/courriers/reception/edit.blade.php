@extends('adminlte::page')

@section('title', 'Modifier courrier réception')

@section('content_header')
    <h1>Modifier courrier : {{ $courrier->num_enregistrement }}</h1>
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

    <form method="POST" action="{{ route('courriers.reception.update', $courrier) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('courriers.reception._form', ['submit_text' => 'Mettre à jour'])
    </form>
@stop
