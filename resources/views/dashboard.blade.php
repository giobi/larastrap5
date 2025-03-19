@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('auth.welcome') }}, {{ Auth::user()->name }}!</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ __('auth.you_are_logged') }}</p>
                    <p class="card-text">{{ __('auth.your_email') }}: {{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 