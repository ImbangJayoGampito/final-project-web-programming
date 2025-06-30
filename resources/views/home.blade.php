@extends('layouts.app')

@section('content')
    <div class="container">

        @include('layouts.alerts')

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h1 class="fw-bold">Welcome, {{ Auth::user()->name }}</h1>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p class="lead">You have successfully logged in. Here are some options for you:</p>
                        <ul class="list-group mb-3">
                            <li class="list-group-item"><a
                                    class="btn btn-primary"href="{{ route('user.show', auth()->id()) }}">View Profile</a>
                            </li>

                            <li class="list-group-item">
                                <a class="btn btn-success" href="{{ route('user.edit', auth()->id()) }}">
                                    Account Settings
                                </a>
                            </li>
                            <li class="list-group-item"><a
                                    class="btn btn-secondary"href="{{ route('settings.edit', auth()->id()) }}">Settings</a>
                            </li>

                        </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
