@extends('layouts.app')

@section('content')
    <div class="container py-4">
        @include('layouts.alerts')
        <h2 class="mb-4">
            {{ request('mine') ? 'Your Posts' : 'All Posts' }}
        </h2>

        <div class="mb-4">
            <a href="{{ request('mine') ? route('posts.index') : route('posts.index', ['mine' => 1]) }}"
                class="btn btn-outline-secondary ">
                {{ request('mine') ? 'Show All Posts' : 'Show Only My Posts' }}
            </a>
            <a href="{{ route('posts.create') }}" class="btn btn-outline-primary">Create Post</a>
        </div>

        @forelse ($posts as $post)
            <div class="mb-4 p-3 border rounded shadow bg-white">
                <h5>{{ $post->title }}</h5>
                <p class="text-muted">
                    {{ Str::limit(strip_tags(html_entity_decode($post->content)), 200) }}
                </p>
                <small class="d-block text-secondary mb-2">
                    @if (Auth::id() === $post->user_id)
                        Posted by you
                    @else
                        Posted by {{ $post->user->name }}
                    @endif
                    &nbsp;&nbsp;|&nbsp;&nbsp;{{ $post->category->name ?? 'Uncategorized' }}
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    Posted at {{ $post->created_at->format('M d, Y') }}

                </small>

                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div class="d-flex">
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                        @if (Auth::id() === $post->user_id)
                            <a href="{{ route('posts.edit', $post->id) }}"
                                class="btn btn-sm btn-outline-success ms-2">Edit</a>
                        @endif
                    </div>

                    @if (Auth::id() === $post->user_id)
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="mb-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Are you sure you want to delete this post?')">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        @empty
            <p>{{ request('mine') ? 'You haven’t posted anything yet.' : 'No posts found.' }}</p>
        @endforelse

        <div class="mt-4 d-flex text-center justify-content-center pagination">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
