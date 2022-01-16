@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
        <div class="d-flex flex-column align-items-start">
            <h2>{{ $compositor->name }}</h2>
            <h6>{{ $compositor->city }}</h6>
            <a href="/">< К списку исполнителей</a>
        </div>
        <a href="/form">
            <button class="btn btn-primary">Спарсить ещё</button>
        </a>
    </div>

    @foreach($musics as $music)
        <div class="item mb-3">
            <div class="d-flex justify-content-between">
                <p class="mb-1">{{ $music->name }}</p>
                <p class="mb-1">{{ $music->duration }}</p>
            </div>
            <p class="mb-0">{{ $music->comments }} комментариев</p>
        </div>
    @endforeach
@endsection
