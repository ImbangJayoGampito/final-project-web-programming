@extends('layouts.app')

@section('content')
    <div class="container py-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops! Please fix the following:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="mb-4">Edit Post</h2>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" id="post-form">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title"
                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}"
                    required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Content --}}
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <input type="hidden" name="content" id="content">
                <div id="quill-editor" style="height: 300px;"></div>
                @error('content')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror"
                    required>
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tags --}}
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <input type="text" id="kt_tagify_1" class="form-control mt-0 mb-0 @error('tags') is-invalid @enderror"
                    placeholder="e.g. Laravel">
                <div id="tags-wrapper"></div>
                @error('tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Update Post</button>
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('tagify/tagify.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('quill/quill.js') }}"></script>
    <script src="{{ asset('quill/quill_editor.js') }}"></script>
    <script src="{{ asset('tagify/tagify.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('post-form');
            const contentInput = document.getElementById('content');
            const quill = initQuillEditor('#quill-editor');

            // Set Quill content
            quill.root.innerHTML = {!! json_encode(old('content', $post->content)) !!};

            form?.addEventListener('submit', function() {
                contentInput.value = quill.root.innerHTML;
            });

            // Tagify
            const tagInput = document.querySelector('#kt_tagify_1');
            const tagsWrapper = document.createElement('div');
            form.appendChild(tagsWrapper);

            const tagify = new Tagify(tagInput);

            const tagNames = @json(old('tags', $post->tags->pluck('name')));
            if (Array.isArray(tagNames)) {
                tagify.addTags(tagNames);
            }

            form.addEventListener('submit', () => {
                tagsWrapper.innerHTML = '';
                tagify.value.map(tag => tag.value).forEach(name => {
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'tags[]';
                    hidden.value = name;
                    tagsWrapper.appendChild(hidden);
                });
            });
        });
    </script>
@endpush
