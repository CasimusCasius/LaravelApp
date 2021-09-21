@extends('layout.main')

@section('sidebar')
    @parent
@endsection

@section('content')
    <hr>
    <h3>Lista Gier</h3>
    <table>
        <thead>
            <th>Id</th>
            <th>Nazwa</th>
            <th>Rok Produkcji</th>
            <th>Opcje</th>
        </thead>
        <tbody>
            @foreach ($games as $game)

            <tr>
                <td>{{$game['index']}}</td>
                <td>{{$game['gameName']}}</td>
                <td>{{$game['productionYear']}}</td>
                <td><a href="{{route('games.show',[
                    'game'=>$game['index'],
                    'gameDetail'=>$game
                    ])
                    }}">Szczegóły</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
