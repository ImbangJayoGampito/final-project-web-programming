@extends('layouts.app')

@section('content')

    <div class="container py-4 border border-dark rounded">
        <h2 class="mb-3 text-break">{{ $post->title }}</h2>

        <div class="mb-2 text-muted">
            <small class="d-block">
                Posted by
                @if (Auth::id() === $post->user_id)
                    you
                @else
                    {{ $post->user->name }}
                @endif
                &bull; {{ $post->created_at->format('M d, Y') }}
            </small>
        </div>

        <div class="mb-3">
            <span class="badge bg-secondary">
                {{ $post->category->name ?? 'Uncategorized' }}
            </span>
        </div>

        <div class="mb-4 text-break">
            <div class="ql-editor m-0 p-0">
                {!! $post->content !!}
            </div>



        </div>

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
        /* Hide the editor */
        .quill {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('quill/quill.js') }}"></script>
    <script src="{{ asset('quill/quill_editor.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const content = @json($post->content);

            const quill = initQuillEditor('#quill-container', {
                readOnly: true,
                modules: {
                    toolbar: false
                }
            });
        });
    </script>
@endpush
