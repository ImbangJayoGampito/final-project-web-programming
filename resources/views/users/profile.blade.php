@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">


                    @if (isset($user))
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">{{ $user->name }}'s Profile</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Name:</strong> {{ $user->name }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Email:</strong> {{ $user->email }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Email Verified:</strong>
                                    {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : '❌ Not verified' }}
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Profile does not exist.</h4>
                        </div>
                        <div class="card-body">
                            <p>The profile you've requested does not exist. Maybe search for another?</p>
                        </div>
                    @endif
                </div>
                {{-- Profile Card --}}



            </div>
        </div>
    </div>
@endsection
