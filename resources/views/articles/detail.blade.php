@extends('layouts.app')

@section('content')
    <div class="container">
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
                {{-- {{ $article->created_at->diffForHumans() }} --}}
                
                @can('delete-article', $article)
                    <a href="{{ url("/articles/delete/$article->id") }}" class="btn btn-warning float-end">Delete</a>
                @endcan

                @can('edit-article', $article)
                    <a href="{{ url("/articles/edit/$article->id") }}" class="btn btn-info float-end mx-1">Edit</a>
               @endcan
               
            </div>
        </div>

        <ul class="list-group mb-2">
            <li>
                Comments ({{ count($article->comments) }})
            </li>
            @foreach ($article->comments as $comment)
                <li class="list-group-item">
                    <a href="{{ url("/comments/delete/$comment->id") }}" class="btn-close float-end"></a>
                    <b>{{ $comment->user->name }}:</b>
                    {{ $comment->content }}
                    <div class="small mt-2">
                        By <b>{{ $comment->user->name }}</b>,
                        {{ $comment->created_at->diffForHumans() }}
                    </div>
                </li>
            @endforeach
        </ul>

        @auth
        <form method="post" action="{{ url('/comments/add') }}">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <textarea name="content" class="w-100 from-control mt-2"></textarea>
            <input type="submit" value="Add Comment" class="btn btn-primary">
        </form>
        @endauth
        
    </div>
@endsection
