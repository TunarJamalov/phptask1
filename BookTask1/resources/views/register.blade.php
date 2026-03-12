@extends('app')
@section('body_class', 'd-flex align-items-center justify-content-center')
@section('body_style', 'height: 100vh;')
@section('content')

<div class="card shadow-sm" style="width: 400px;">
    <div class="card-body">
        <h3 class="text-center mb-4">Qeydiyyat</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Adınız</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Ünvanı</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Şifrə</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Şifrəni Təsdiqləyin</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Qeydiyyatdan Keç</button>
        </form>

        <div class="text-center mt-3">
            Hesabınız var? <a href="{{ route('login') }}">Giriş edin</a>
        </div>
    </div>
</div>

@endsection
