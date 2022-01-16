@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
        <h2>Музыка</h2>

        <a href="/form">
            <button class="btn btn-primary">Спарсить ещё</button>
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-0 mb-3">
            {{ session('success') }}
        </div>
    @endif

    @foreach($composers as $composer)
        <a href="/compositor/{{ $composer->id }}">
            <div class="item">
                {{ $composer->name }}
            </div>
        </a>
    @endforeach
@endsection
