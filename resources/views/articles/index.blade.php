{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article - Home</title>
</head>
<body>
    <h1>Article List</h1>
    <ul>
        @foreach ($articles as $article)
            <li>{{ $article['title'] }}</li>
        @endforeach
    </ul>
</body>
</html> --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        {{ $articles->links() }}

        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        @foreach ($articles as $article)
            <div class="card mb-4">
                <div class="card-master">
                    <b>
                        <a href="{{ url("/articles/detail/$article->id") }}">
                            {{ $article->title }}
                        </a>
                    </b>
                </div>
                <div class="card-body">
                    {{ $article->body }}
                </div>
                <div class="card-footer">
                    <div>
                        <b>Author:</b>
                        {{ $article->user->name }}
                    </div>
                    <div>
                        <b>Category:</b> {{ $article->category->name }}
                    </div>
                    <div>
                        <b>Comments:</b>
                        {{ count($article->comments) }}
                    </div>
                    <div>
                        <b>Published at: </b>
                        {{ $article->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
