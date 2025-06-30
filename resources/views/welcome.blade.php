@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8"> <!-- Made the column wider -->
                <div class="card shadow-lg" style="min-height: 400px;"> <!-- Added shadow and min-height -->
                    <div class="card-body p-5"> <!-- Increased padding -->
                        <h1 class="card-title mb-4 text-center fw-bold display-4">Register</h1> <!-- Larger title -->
                        <div class="container d-flex flex-column justify-content-center align-items-center"
                            style="min-height: 60vh;">
                            <div class="text-center">
                                <h1 class="display-3 fw-bold mb-4">Welcome to {{ config('app.name', 'Laravel') }}!</h1>
                                <p class="lead mb-4">Introduce yourself! Speak your mind! Tell your opinion to the world!
                                </p>
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login</a>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
