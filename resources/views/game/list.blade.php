@extends('layout.main')

@section('content')

    <div class="row mt-3">
        <div class="card">
        <div class="card-header"><i = class="fas fa-table mr-1"></i>Gry</div>
            <div class="card-body">

                <form class=" row-cols-lg-auto g-3" action="{{ route('games.list')}}">
                    <div class="row">
                        <label class= "my-1 me-2 col-auto"for="phrase">Szukana fraza:</label>
                        <div class="col-auto">
                            <input type="text" class="form-control" name="phrase" placeholder="" value="{{$phrase ?? ''}}">
                        </div>
                        @php
                        $type = $type ?? ''
                        @endphp
                        <div class="col-auto">
                            <select class="form-select  me-sm-2" name="type" >
                                <option @if ($type == 'all' ) selected @endif value="all">Wszystkie gry</option>
                                <option @if ($type == 'game') selected @endif value="game">Gry</option>
                                <option @if ($type == 'dlc') selected @endif value="dlc">DLC</option>
                                <option @if ($type == 'demo') selected @endif value="demo">Demo</option>
                                <option @if ($type == 'episode') selected @endif value="episode">Epizody</option>
                                <option @if ($type == 'mod') selected @endif value="mod">Mody</option>
                                <option @if ($type == 'movie') selected @endif value="movie">Filmy</option>
                                <option @if ($type == 'music') selected @endif value="music">Muzyka</option>
                                <option @if ($type == 'series') selected @endif value="series">Serie</option>
                                <option @if ($type == 'video') selected @endif value="video">Video</option>

                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mb-1 col-auto">Wyszukaj</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tytuł</th>
                                <th>Ocena</th>
                                <th>Typ</th>
                                <th>Kategoria</th>
                                <th>Opcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                               <th>Id</th>
                                <th>Tytuł</th>
                                <th>Ocena</th>
                                <th>Typ</th>
                                <th>Kategoria</th>
                                <th>Opcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($games ?? []  as $game)
                                <tr>
                                    <td>{{ $game->id}}</td>
                                    <td>{{ $game->name}}</td>
                                    <td>{{ $game->score}}</td>
                                    <td>{{ $game->type}}</td>
                                    <td>{{ $game->genres->implode ('name',', ')}}</td>
                                    <td>
                                        <a href="{{route('games.show',['game'=>$game->id])}}">Szczegóły</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
               </div>
            {{ $games->links() }}
           </div>
       </div>
   </div>
@endsection
