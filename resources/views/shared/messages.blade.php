@php
    use Illuminate\Support\Facades\Session;
@endphp

@if ($message = Session::get('success'))
    <div class="alert alert-success mt-2 alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">x</button>
        <strong> {{$message}}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger mt-2 alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">x</button>
        <strong> {{$message}}</strong>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning mt-2 alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">x</button>
        <strong> {{$message}}</strong>
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info mt-2 alert-block">
        <button type="button" class="close" data-bs-dismiss="alert">x</button>
        <strong> {{$message}}</strong>
    </div>
@endif
