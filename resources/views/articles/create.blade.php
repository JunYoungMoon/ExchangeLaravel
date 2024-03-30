@extends('layouts.app')

@section('content')
    <!-- Validation Errors -->
    <form method="POST" action="{{ route('api.articles.create') }}">
        <h1>글쓰기</h1>
        @csrf
        <div>
            <label for="body">글내용</label>
            <input id="body" type="text" name="body" value="{{ old('body') }}" autofocus>
        </div>
        @error('body')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div>
            <button type="submit">저장하기</button>
        </div>
    </form>
@endsection
