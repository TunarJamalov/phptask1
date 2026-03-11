<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <title>Kitab edit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning">Kitabi Duzelt: <strong>{{ $book->title }}</strong></div>
                <div class="card-body">
                    <form action="{{ route('books.update', $book->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label>Kitabın Adı</label>
                            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Kateqoriya</label>
                            <input type="text" name="category" class="form-control" value="{{ $book->category }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Qiymət</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ $book->price }}" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Yenilə</button>
                        <a href="{{ route('books.index') }}" class="btn btn-secondary w-100 mt-2">Geri Qayıt</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
