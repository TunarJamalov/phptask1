<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <title>Kateqoriya edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">Kateqoriya edit</div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Kateqoriya Adı</label>
                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Yenile</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary w-100 mt-2">Geri Qayıt</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
