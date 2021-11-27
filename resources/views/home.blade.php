@extends('layouts.app')

@section('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        window.user = {!! json_encode(\Illuminate\Support\Facades\Auth::user()) !!};
    </script>
@endsection

@section('content')
    <div id="app"></div>
@endsection
