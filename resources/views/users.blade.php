@extends('app')

@section('content')

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                @role('admin')
                <a href="{{ route('books.index') }}" class="btn btn-outline-primary">Kitablar Paneli</a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Kateqoriyalar Paneli</a>
                <a href="{{ route('logs.index') }}" class="btn btn-outline-primary">
                    Activity Logs (Tarixçə)
                </a>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Istifadeci siyahı</a>
                @endrole
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Çıxış Et ({{ auth()->user()->name }})</button>
            </form>
        </div>
<h2>İstifadəçilər Siyahısı</h2>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Adı</th>
        <th>Email</th>
        <th>Yaranma Tarixi</th>
        <th>Status</th>
        <th>Əməliyyat</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
            <td>
                @if($user->is_active)
                    <span class="badge bg-success">Aktiv</span>
                @else
                    <span class="badge bg-danger">Bloklanıb</span>
                @endif
            </td>
            <td>
                @if(auth()->id() !== $user->id)
                    <form action="{{ route('users.toggle-status', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                            {{ $user->is_active ? 'Blokla' : 'Aktiv Et' }}
                        </button>
                    </form>
                @else
                    <span class="text-muted">Sizsiniz</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>

@endsection
