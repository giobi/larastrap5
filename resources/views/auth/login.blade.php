@extends('layouts.auth')

@section('title', __('auth.login'))

@section('content')
    <h2 class="text-center mb-4">{{ __('auth.login') }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('auth.email') }}</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" value="{{ old('email') }}" required autofocus>
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

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">{{ __('auth.remember_me') }}</label>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">{{ __('auth.login') }}</button>
        </div>
    </form>

    <div class="text-center mt-3">
        <p class="mb-0">{{ __('auth.no_account') }} <a href="{{ route('register') }}">{{ __('auth.register') }}</a></p>
    </div>
@endsection 