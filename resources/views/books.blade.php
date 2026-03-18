@extends('app')

@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            @role('admin')
            <a href="{{ route('books.index') }}" class="btn btn-primary">Kitablar Paneli</a>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Kateqoriyalar Paneli</a>
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
                    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label class="form-label">Etiketlər (Tags)</label>
                            <select name="tags[]" class="form-select" multiple>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Birdən çox seçmək üçün CTRL (və ya Mac-da CMD) düyməsini basılı saxlayın.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Qiymət</label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="Kitabin qiymeti yazin" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kitabın Şəkli</label>
                            <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
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
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Kitab adı ilə axtar..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="category_id" class="form-select">
                                    <option value="">-- Bütün Kateqoriyalar --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="tag_id" class="form-select">
                                    <option value="">-- Bütün Etiketlər --</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}" {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">🔍 Axtar / Filtr</button>
                                @if(request('search') || request('category_id') || request('tag_id'))
                                    <a href="{{ route('books.index') }}" class="btn btn-danger">✖ Clear</a>
                                @endif
                            </div>
                        </div>
                    </form>
                    <div class="mb-3">
                        <a href="{{ route('books.export') }}" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                                <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                            </svg>
                            Excel Yüklə
                        </a>
                    </div>
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>No:</th>
                            <th>Kitabın Adı</th>
                            @role('admin')
                            <th>İstifadəçi adı</th>
                            @endrole
                            <th>Kateqoriya</th>
                            <th>Qiymət</th>
                            <th>Tarix</th>
                            <th>Şəkil</th>
                            <th>Taglar</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $book->title }}</td>
                                @role('admin')
                                <td>{{ $book->user->name }}</td>
                                @endrole
                                <td>{{ $book->category->name ?? 'Kategoriyasiz' }}</td>
                                <td>{{ $book->price }} ₼</td>
                                <td>{{ $book->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    @if($book->image)
                                        <img src="{{ asset('storage/covers/' . $book->image) }}" width="50" height="70" style="object-fit: cover;" alt="ad">
                                    @else
                                        <span class="text-muted">Şəkil yoxdur</span>
                                    @endif
                                </td>
                                <td>
                                    @if($book->tags->isNotEmpty())
                                        {{ $book->tags->pluck('name')->implode(', ') }}
                                    @else
                                        <span class="text-muted">Tagsız</span>
                                    @endif
                                </td>
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
                                <td colspan="8" class="text-center text-muted">Kitab yoxdur.</td>
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
