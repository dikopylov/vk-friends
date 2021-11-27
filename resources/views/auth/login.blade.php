@extends('layouts.app')

@section('content')
    <div class="login">
        <div class="text-center">
            <img class="mb-4"
                 src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/21/VK.com-logo.svg/2000px-VK.com-logo.svg.png"
                 alt="VK" width="100" height="100">
            <h1 class="h3 mb-3 font-weight-normal">Вконтакте</h1>
            <form method="POST" action="{{ route('auth') }}">
                @csrf
                <button type="submit" class="btn btn-lg btn-block btn-primary">Войти</button>
            </form>

        </div>
    </div>
@endsection
