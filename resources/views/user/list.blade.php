@extends('layout.main')

@section('content')
    <h1>Users list</h1>
    <table>
        <thead>
            <tr>
                <th>Index</th>
                <th>Iteration</th>
                <th>Id</th>
                <th>Name</th>
                <th>Opcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                @if ($loop->first)
                    <tr><td>FIRST</td></tr>
                @endif
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>Link</td>
                </tr>
                @if ($loop->last)
                    <tr><td>LAST</td></tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <hr/>
    <hr/>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nick</th>
                <th>Opcje</th>
            </tr>
        </thead>
        <tbody>
                <tr><td colspan="3">EACH</td></tr>
                @each('user.listRow', $users, 'userData', 'user.emptyRow')

                <tr><td colspan="3">FOREACH</td></tr>
                @foreach ($users as $user)
                    @include('user.listRow', ['userData' => $user])
                @endforeach

                <tr><td colspan="3">FOR</td></tr>
                @for ($i = 0; $i < count($users); $i++)
                    @break($i == 1)
                    @include('user.listRow', ['userData' => $users[$i]])
                @endfor

                <tr><td colspan="3">FORELSE</td></tr>
                @forelse ($users as $user)
                    @include('user.listRow', ['userData' => $user])
                @empty
                    @include('user.emptyRow')
                @endforelse

                <tr><td colspan="3">WHILE</td></tr>
                @php
                    $j = 0;
                    $count = count($users);
                @endphp
                @while ($j < $count)
                    @include('user.listRow', ['userData' => $users[$j]])
                    @php
                        $j++;
                    @endphp
                @endwhile
        </tbody>
    </table>

    @switch($users)
        @case(1)

            @break
        @case(2)

            @break
        @default

    @endswitch
@endsection
