@extends('layouts.main')

@section('content')
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
        <h2>Музыка</h2>

        <a href="/">
            <button class="btn btn-primary">На главную</button>
        </a>
    </div>

    <form action="/parse/url" method="post">
        @csrf
        <input type="text" class="form-control mb-3" name="url" placeholder="Ссылка (https://soundcloud.com/lakeyinspired/tracks)">
        <button type="submit" class="btn btn-primary mb-5">Начать парсинг</button>
    </form>
@endsection
