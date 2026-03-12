<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <title>Sistemə Giriş</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

<div class="card shadow-sm" style="width: 400px;">
    <div class="card-body">
        <h3 class="text-center mb-4">Giriş</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Ünvanı</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Şifrə</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Daxil Ol</button>
        </form>

        <div class="text-center mt-3">
            Hesabınız yoxdur? <a href="{{ route('register') }}">Qeydiyyatdan keçin</a>
        </div>
    </div>
</div>

</body>
</html>
