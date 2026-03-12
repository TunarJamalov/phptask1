@extends('app')

@section('content')
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
                            <label class="form-label">Kateqoriya</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled>-- Kateqoriya Seçin --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
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
@endsection
