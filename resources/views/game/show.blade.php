@extends('layout.main')

@section('sidebar')
    @parent
@endsection

@section('content')
<hr>
    <h3>Lista Gier</h3>

    {{$gameId}}
    @php

        dd($gameDetail)
    @endphp

@endsection

