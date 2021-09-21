@extends('layout.main')

@section('title', 'Użytkownik')

@section('sidebar')
    @parent
    DZIECKO
    Sidebar z dziecka

    @auth
        <ul>
            <li>LINK</li>
        </ul>
    @endauth
@endsection

@section('content')
    <hr/>
    <h3>Informacje o użytkowniku</h3>

    @guest
        Użytkownik nie jest zalogowany
    @endguest

    <ul>
        <li>Id: {{ $user['id'] }}</li>
        <li>Imię: {{ $user['firstName'] }}</li>
        <li>Nazwisko: {{ $user['lastName'] }}</li>
        <li>Miasto: {{ $user['city'] }}</li>

        <li>
            Wiek: {{ $user['age']}}
            @if ($user['age'] >= 18)
                <div>Osoba dorosła</div>
            @elseif ($user['age'] >= 16)
                <div>Prawie dorosła</div>
            @else
                <div>Nastolatek</div>
            @endif
        </li>
    </ul>

    <hr/>
    <div>
        @isset($nick)
            ISSET - true
        @else
            ISSET - false
        @endisset

        @empty($nick)
            EMPTY - true
        @else
            EMPTY - false
        @endempty
    </div>
    <hr/>

    <div>
        {{ $user['html'] }}
    </div>

    <hr>
@endsection
