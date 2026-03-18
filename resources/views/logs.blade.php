@extends('app')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                @role('admin')
                <a href="{{ route('books.index') }}" class="btn btn-outline-primary">Kitablar Paneli</a>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Kateqoriyalar Paneli</a>
                <a href="{{ route('logs.index') }}" class="btn btn-primary">
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
        <h2>Sistem Qeydləri (Activity Logs)</h2>
        <table class="table table-bordered">
            <tr>
                <th>Tarix</th>
                <th>İstifadəçi</th>
                <th>Əməliyyat</th>
                <th>Bölmə</th>
                <th>Detal</th>
            </tr>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $log->user->name ?? 'Sistem' }}</td>
                    <td><span class="badge bg-primary">{{ $log->action }}</span></td>
                    <td>{{ $log->model_type }}</td>
                    <td>{{ $log->details }}</td>
                </tr>
            @endforeach
        </table>




        </div>


@endsection
