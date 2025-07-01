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

        <h2 class="mb-4">Create a New Post</h2>

        <form action="{{ route('posts.store') }}" method="POST" id="post-form">
            @csrf

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title (Maximum 255 Characters)</label>
                <input type="text" name="title" id="title"
                    placeholder="Your title such as &quot;My First Blog!&quot;"
                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Content --}}
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                {{-- Hidden input for actual submission --}}
                <input type="hidden" name="content" id="content">

                {{-- Quill visual editor --}}
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                @php
                    $oldTags = old('tags');
                    $tagValue = is_array($oldTags) ? implode(', ', $oldTags) : $oldTags;
                @endphp

                <label for="tags" class="form-label">Tags (comma-separated)</label>
                <input type="text" id="kt_tagify_1" class="form-control mt-0 mb-0 @error('tags') is-invalid @enderror"
                    value="{{ $tagValue }}" placeholder="e.g. Laravel">


                @error('tags')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Publish Post</button>
            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('tagify/tagify.css') }}" rel="stylesheet">
    <style>

    </style>
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

            // Populate old Quill content (if any)
            @if (old('content'))
                quill.root.innerHTML = {!! json_encode(old('content')) !!};
            @endif

            // Store Quill content in hidden input on submit
            form?.addEventListener('submit', function() {
                contentInput.value = quill.root.innerHTML;
            });

            // Tagify Initialization
            const tagInputUI = document.querySelector('#kt_tagify_1');
            const tagsWrapper = document.createElement('div'); // Dynamic hidden inputs go here
            form?.appendChild(tagsWrapper); // Make sure it’s part of the form

            if (tagInputUI) {
                const tagify = new Tagify(tagInputUI);

                // Preload existing tags (if editing)
                const oldTags = @json(old('tags', []));
                if (Array.isArray(oldTags) && oldTags.length) {
                    tagify.addTags(oldTags);
                }

                // Inject one hidden input per tag
                form?.addEventListener('submit', () => {
                    tagsWrapper.innerHTML = ''; // Clear any existing inputs

                    const tagValues = tagify.value.map(tag => tag.value);
                    tagValues.forEach(tag => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'tags[]';
                        hiddenInput.value = tag;
                        tagsWrapper.appendChild(hiddenInput);
                    });
                });
            }
        });
    </script>

    <script></script>
@endpush
