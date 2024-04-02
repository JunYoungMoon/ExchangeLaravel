@extends('layouts.app')

@section('content')
    <!-- Validation Errors -->
    <form method="POST" action="{{ route('api.articles.update', ['article' => $article->id]) }}">
        <h1>글수정</h1>
        @csrf
        @method('PATCH')
        <div>
            <label for="body">글내용</label>
            <input id="body" type="text" name="body" value="{{ old('body') ?? $article->body }}" autofocus>
        </div>
        @error('body')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div>
            <button type="submit">저장하기</button>
        </div>
    </form>
@endsection
