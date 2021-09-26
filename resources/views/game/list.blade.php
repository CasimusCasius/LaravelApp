@extends('layout.main')

@section('sidebar')
    @parent
@endsection

@section('content')
   <div class="row mt-3">
       <div class="card">
           <div class="card-header"><i = class="fas fa-table mr-1"></i>Gry</div>
           <div class="card-body">
               <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Lp</th>
                                <th>Tytuł</th>
                                <th>Ocena</th>
                                <th>Kategoria</th>
                                <th>Opcje</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Lp</th>
                                <th>Tytuł</th>
                                <th>Ocena</th>
                                <th>Kategoria</th>
                                <th>Opcje</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($games ?? []  as $game)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $game->title}}</td>
                                    <td>{{ $game->score}}</td>
                                    <td>{{ $game->genere_id}}</td>
                                    <td>
                                        <a href="{{route('games.show',['game'=>$game->id])}}">Szczegóły</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>



                    </table>
               </div>
           </div>
       </div>
   </div>
@endsection
