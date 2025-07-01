@extends('layouts.app')

@section('content')
    <div class="container py-4 border border-dark rounded">
        <h2 class="mb-3 text-break">{{ $post->title }}</h2>

        <div class="mb-2 text-muted">
            <small class="d-block">
                Posted by
                @if (Auth::id() === $post->user_id)
                    <a href="{{ route('user.show', Auth::id()) }}">you</a>
                @else
                    <a href="{{ route('user.show', $post->user_id) }}">{{ $post->user->name }}</a>
                @endif
                &bull; {{ $post->created_at->format('M d, Y') }}
            </small>
        </div>

        <div class="mb-3">
            <span class="badge bg-secondary">
                {{ $post->category->name ?? 'Uncategorized' }}
            </span>
        </div>

        <!-- Quill content container -->
        <div id="quill-container" class="mb-4 text-break"></div>

        @if ($post->tags->count())
            <div class="mb-4">
                <strong>Tags:</strong>
                <div class="mt-2 d-flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <span class="badge bg-light text-dark border text-break">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary">
            &larr; Back to Posts
        </a>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('quill/quill.snow.css') }}" rel="stylesheet">
    <style>
        .ql-syntax {
            background-color: #f8f9fa;
            padding: 0.75rem;
            border-radius: 5px;
            font-family: monospace;
            overflow-x: auto;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('quill/quill.js') }}"></script>
    <script src="{{ asset('quill/quill_editor.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const quill = initQuillEditor('#quill-container', {
                readOnly: true,
                modules: {
                    toolbar: false
                }
            });

            const content = @json($post->content);
            quill.root.innerHTML = content;
        });
    </script>
@endpush
