@extends('layouts.app')

@section('content')
    <h2>Latest Posts</h2>

    @if($posts->count())
        <ul>
            @foreach($posts as $post)
                <li>
                    <h3><a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a></h3>
                    <p>{{ Str::limit($post->body, 150) }}</p>
                </li>
            @endforeach
        </ul>

        <!-- Pagination Links -->
        {{ $posts->links() }}
    @else
        <p>No posts available.</p>
    @endif
@endsection

