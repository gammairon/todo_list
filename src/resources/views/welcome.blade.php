@extends('layouts.app')

@section('content')
    <div class="container welcome">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                @if(Auth::check())
                    <h1 class="my-2">Чтобы начать работу перейдите в свой аккаунт</h1>
                    <div><a href="{{route('home')}}" class="btn btn-primary">Перейти в аккаунт</a></div>
                @else
                    <h2 class="my-2">Чтобы начать работу войдите в аккаунт</h2>
                    <div><a href="{{route('login')}}" class="btn btn-primary btn-lg">Login</a></div>
                    <h4 class="my-2">Если нет аккаунта зарегистрируйтесь</h4>
                    <div><a href="{{route('register')}}" class="btn btn-success btn-sm">Регистрация</a></div>
                @endif

            </div>
        </div>
    </div>
@endsection
