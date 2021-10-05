@extends('me.card')
@section('profile')
    <div class="card-body">
        <img src="/images/avatar.png" class="rounded mx-auto d-block">
        <ul>
            <li>Nazwa: {{$user->name}}</li>
            <li>Email: {{$user->email}}</li>
            <li>Telefon: {{$user->phone}}</li>
        </ul>
        <a href="{{route('me.edit')}}" class="btn btn-light">Edytuj dane</a>
    </div>
@endsection
