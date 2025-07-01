@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2>User Settings</h2>

        @include('layouts.alerts')

        @php
            $settings = auth()->user()->settings;
        @endphp

        <form method="POST" action="{{ route('settings.update', $settings->id) }}">
            @csrf
            @method('PUT')

            {{-- Language --}}
            <div class="mb-3">
                <label for="language" class="form-label">Language</label>
                <select name="language" id="language" class="form-select @error('language') is-invalid @enderror">
                    <option value="en" {{ $settings->language === 'en' ? 'selected' : '' }}>English</option>
                    <option value="id" {{ $settings->language === 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                    <option value="fr" {{ $settings->language === 'fr' ? 'selected' : '' }}>Français</option>
                </select>
                @error('language')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Dark Mode --}}
            <div class="form-check mb-3">
                <input type="hidden" name="dark_mode" value="0">
                <input class="form-check-input @error('dark_mode') is-invalid @enderror" type="checkbox" name="dark_mode"
                    id="dark_mode" value="1" {{ $settings->dark_mode ? 'checked' : '' }}>
                <label class="form-check-label" for="dark_mode">Enable Dark Mode</label>
                @error('dark_mode')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Save Settings</button>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
        </form>
    </div>
@endsection
