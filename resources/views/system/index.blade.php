@extends('layouts.app')

@section('title', 'System Information')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="fas fa-server me-2"></i>
            System Information
        </h1>
    </div>

    <!-- Weather Info -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-cloud me-2"></i>
                    Weather Information
                </h5>
            </div>
            <div class="card-body">
                @if($weatherInfo)
                    <div class="text-center mb-4">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $weatherInfo['city'] }}, {{ $weatherInfo['country'] }}
                        </h6>
                        <i class="fas {{ $weatherService->getWeatherIcon($weatherInfo['icon']) }} fa-3x text-warning mb-3"></i>
                        <h2 class="mb-0">{{ $weatherInfo['temperature'] }}°C</h2>
                        <p class="text-muted">{{ $weatherInfo['description'] }}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-temperature-high me-2"></i> Feels Like</span>
                            <span class="badge bg-primary">{{ $weatherInfo['feels_like'] }}°C</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-tint me-2"></i> Humidity</span>
                            <span class="badge bg-info">{{ $weatherInfo['humidity'] }}%</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-wind me-2"></i> Wind Speed</span>
                            <span class="badge bg-success">{{ $weatherInfo['wind_speed'] }} km/h</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-compress-alt me-2"></i> Pressure</span>
                            <span class="badge bg-warning">{{ $weatherInfo['pressure'] }} hPa</span>
                        </li>
                    </ul>
                @else
                    <div class="text-center">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                        <p>Weather information is currently unavailable</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Application Info -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Application Information
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        PHP Version
                        <span class="badge bg-primary">{{ $phpVersion }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Laravel Version
                        <span class="badge bg-primary">{{ $laravelVersion }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Database Info -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-database me-2"></i>
                    Database Information
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Database Name
                        <span class="badge bg-info">{{ $databaseInfo['name'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Driver
                        <span class="badge bg-info">{{ $databaseInfo['driver'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Tables Count
                        <span class="badge bg-info">{{ $databaseInfo['tables'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Database Size
                        <span class="badge bg-info">{{ $databaseInfo['size'] }} MB</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Server Info -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-hdd me-2"></i>
                    Server Information
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($serverInfo as $key => $value)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ ucwords(str_replace('_', ' ', $key)) }}
                        <span class="badge bg-secondary">{{ $value }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Storage Info -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-hard-drive me-2"></i>
                    Storage Information
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Space
                        <span class="badge bg-success">{{ $storageInfo['total_space'] }} GB</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Used Space
                        <span class="badge bg-warning">{{ $storageInfo['used_space'] }} GB</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Free Space
                        <span class="badge bg-info">{{ $storageInfo['free_space'] }} GB</span>
                    </li>
                </ul>
                <div class="progress mt-3">
                    @php
                        $usedPercentage = ($storageInfo['used_space'] / $storageInfo['total_space']) * 100;
                    @endphp
                    <div class="progress-bar bg-warning" role="progressbar" 
                         style="width: {{ $usedPercentage }}%"
                         aria-valuenow="{{ $usedPercentage }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                        {{ round($usedPercentage) }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cache & Session Info -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-memory me-2"></i>
                    Cache & Session
                </h5>
            </div>
            <div class="card-body">
                <h6 class="border-bottom pb-2">Cache Information</h6>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Driver
                        <span class="badge bg-primary">{{ $cacheInfo['driver'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Path
                        <span class="badge bg-primary">{{ $cacheInfo['path'] }}</span>
                    </li>
                </ul>

                <h6 class="border-bottom pb-2">Session Information</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Driver
                        <span class="badge bg-primary">{{ $sessionInfo['driver'] }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Lifetime
                        <span class="badge bg-primary">{{ $sessionInfo['lifetime'] }} minutes</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .list-group-item {
        background-color: transparent;
        border-color: rgba(255, 255, 255, 0.1);
    }
</style>
@endpush 