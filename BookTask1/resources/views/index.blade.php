@extends('app')
@section('body_class', 'd-flex align-items-center justify-content-center')
@section('body_style', 'height: 100vh;')
@section('content')

<div class="text-center">
    <h1 class="mb-4 text-primary">Kitab İdarəetmə Sistemi</h1>
    <p class="lead mb-4 text-muted">Sistemi idarə etmək üçün zəhmət olmasa hesabınıza daxil olun və ya qeydiyyatdan keçin.</p>

    @auth
        <h4 class="mb-3">Xoş gəldiniz, {{ auth()->user()->name }}!</h4>
        <a href="{{ route('books.index') }}" class="btn btn-success btn-lg mx-2">İdarəetmə Panelinə Keç</a>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg mx-2">Giriş Et</a>
        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg mx-2">Qeydiyyat</a>
    @endauth
</div>

@endsection
