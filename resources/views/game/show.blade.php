@extends('layout.main')

@section('content')
<div class="card">
    @if (!empty($game))
        <h5 class="card-header">{{$game->title}}</h5>
        <div class="card-body">
            <ul>
                <li>id: {{$game->id}}</li>
                <li>Nazwa: {{$game->title}}</li>
                <li>Wydawca: {{$game->publisher}}</li>
                <li>Kategoria: {{$game->genere_id}}</li>
                <li>
                    Opis:
                    <div>{{$game->description}}</div>
                </li>
            </ul>

            <a href="{{route('games.index')}}" class="btn btn-light">Lista Gier</a>
        </div>
    @else
    <h5 class="card-header">Brak danych do wyświetlenia</h5>
    @endif
</div>
@endsection

