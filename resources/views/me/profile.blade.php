@extends('me.card')
@section('profile')
    <div class="card-body">
        @if ($user->avatar)
            <img src="{{asset('storage/'.$user->avatar)}}" class="rounded mx-auto d-block user-avatar" >
        @else
            <img src="/images/avatar.png" class="rounded mx-auto d-block">
        @endif

        <ul>
            <li>Nazwa: {{$user->name}}</li>
            <li>Email: {{$user->email}}</li>
            <li>Telefon: {{$user->phone}}</li>
        </ul>
        <a href="{{route('me.edit')}}" class="btn btn-light">Edytuj dane</a>
    </div>
@endsection
