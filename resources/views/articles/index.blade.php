@extends('layouts.app')

@section('content')
    <h1>글목록</h1>
    <ul>
        @foreach($articles as $article)
            <li>{{ $article->body }}</li>
        @endforeach
    </ul>
@endsection
