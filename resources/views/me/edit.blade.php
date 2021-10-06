@extends('me.card')
@section('profile')
<div class="card-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>

                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('me.update') }}" enctype="multipart/form-data">
    @csrf
        @if ($user->avatar)
            <img src="{{asset('storage/'.$user->avatar)}}" class="rounded mx-auto d-block user-avatar" >
        @else
            <img src="/images/avatar.png" class="rounded mx-auto d-block">
        @endif

        <div class="form-group">
            <label for="avatar" class="col-md-1 col-form-label text-md-right">Wybierz avatar...</label>
            <input
                type="file"
                class="form-control-file"
                id="name"
                name="avatar">

                @error('avatar')
                    <div class="invalid-feedback d-block">{{$message}}</div>
                @enderror
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-1 col-form-label text-md-right">Nazwa</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus
                value="{{old('name',$user->name)}}">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-1 col-form-label text-md-right">E-mail</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email"
                value="{{old('email',$user->email)}}">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="phone" class="col-md-1 col-form-label text-md-right">Telefon</label>

            <div class="col-md-6">
                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required autocomplete="phone" autofocus
                value="{{old('phone',$user->phone)}}">

                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-1">
                <button type="submit" class="btn btn-primary">
                    Zapisz dane
                </button>
            </div>
        </div>

    </form>
</div>
@endsection
