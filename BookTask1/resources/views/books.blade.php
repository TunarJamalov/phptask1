@extends('app')

@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('books.index') }}" class="btn btn-primary">Kitablar Paneli</a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Kateqoriyalar Paneli</a>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Çıxış Et ({{ auth()->user()->name }})</button>
        </form>
    </div>
    <h2 class="mb-4 text-center">Kitablar</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Yeni Kitab Əlavə Et
                </div>
                <div class="card-body">
                    <form action="{{ route('books.store') }}" method="POST">
                        @csrf <div class="mb-3">
                            <label class="form-label">Kitabın Adı</label>
                            <input type="text" name="title" class="form-control" placeholder="Kitab adi yazin" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kateqoriya</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>-- Kateqoriya Seçin --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Qiymət</label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="Kitabin qiymeti yazin" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Əlavə Et</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('books.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group shadow-sm">
                                    <input type="text" name="search" class="form-control" placeholder="Kitab adı ilə axtar..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">🔍 Axtar</button>

                                    @if(request('search'))
                                        <a href="{{ route('books.index') }}" class="btn btn-outline-danger">✖ Təmizlə</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>No:</th>
                            <th>Kitabın Adı</th>
                            <th>Kateqoriya</th>
                            <th>Qiymət</th>
                            <th>Tarix</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->category->name ?? 'Kategoriyasiz' }}</td>
                                <td>{{ $book->price }} ₼</td>
                                <td>{{ $book->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="{{route('books.edit', $book->id)}}" class="btn btn-sm btn-warning">Duzelt</a>

                                    <form action="{{route('books.destroy',$book->id)}}" method="POST" class="d-inline" onsubmit="return confirm('Eminsiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Kitab yoxdur.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">{{$books->links('pagination::bootstrap-5')}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
