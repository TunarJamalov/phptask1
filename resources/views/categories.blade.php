@extends('app')

@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            @role('admin')
            <a href="{{ route('books.index') }}" class="btn btn-outline-primary">Kitablar Paneli</a>
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Kateqoriyalar Paneli</a>
            <a href="{{ route('logs.index') }}" class="btn btn-outline-primary">
                Activity Logs (Tarixçə)
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Istifadeci siyahı</a>
            @endrole

        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Çıxış Et ({{ auth()->user()->name }})</button>
        </form>
    </div>

    <h2 class="mb-4 text-center">Kateqoriya edit</h2>
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
                <div class="card-header bg-success text-white">Yeni Kateqoriya</div>
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kateqoriya Adı</label>
                            <input type="text" name="name" class="form-control" placeholder="kateqoriya yaz" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Əlavə Et</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>No:</th>
                            <th>Kateqoriya Adı</th>
                            <th>Yaranma Tarixi</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Duzelt</a>

                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Eminsiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Sil</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">kateqoriya yoxdur.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
