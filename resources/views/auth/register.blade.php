@extends('layouts.auth')

@section('title', __('auth.register'))

@section('content')
    <h2 class="text-center mb-4">{{ __('auth.register') }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="first_name" class="form-label">{{ __('auth.first_name') }}</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                   id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus>
            @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">{{ __('auth.last_name') }}</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                   id="last_name" name="last_name" value="{{ old('last_name') }}" required>
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('auth.email') }}</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('auth.password') }}</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                   id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('auth.confirm_password') }}</label>
            <input type="password" class="form-control" 
                   id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">{{ __('auth.register') }}</button>
        </div>
    </form>

    <div class="text-center mt-3">
        <p class="mb-0">{{ __('auth.has_account') }} <a href="{{ route('login') }}">{{ __('auth.login') }}</a></p>
    </div>
@endsection 