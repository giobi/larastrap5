<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

class SystemController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        // Get PHP version
        $phpVersion = PHP_VERSION;

        // Get Laravel version
        $laravelVersion = app()->version();

        // Get database information
        $databaseInfo = [
            'name' => config('database.connections.'.config('database.default').'.database'),
            'driver' => config('database.default'),
            'tables' => count(DB::select('SHOW TABLES')),
        ];

        // Get database size
        $dbSize = DB::select('SELECT Round(Sum(data_length + index_length) / 1024 / 1024, 1) as size 
            FROM information_schema.tables 
            WHERE table_schema = ?
            GROUP BY table_schema', [config('database.connections.'.config('database.default').'.database')]);
        
        $databaseInfo['size'] = $dbSize[0]->size ?? 0;

        // Get server information
        $serverInfo = [
            'os' => PHP_OS,
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'server_name' => $_SERVER['SERVER_NAME'] ?? 'Unknown',
            'server_protocol' => $_SERVER['SERVER_PROTOCOL'] ?? 'Unknown',
            'document_root' => $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown',
            'server_addr' => $_SERVER['SERVER_ADDR'] ?? 'Unknown',
            'server_port' => $_SERVER['SERVER_PORT'] ?? 'Unknown',
        ];

        // Get storage information
        $storageInfo = [
            'total_space' => round(disk_total_space(storage_path()) / 1024 / 1024 / 1024, 2),
            'free_space' => round(disk_free_space(storage_path()) / 1024 / 1024 / 1024, 2),
        ];
        $storageInfo['used_space'] = round($storageInfo['total_space'] - $storageInfo['free_space'], 2);

        // Get weather information
        $weatherInfo = $this->weatherService->getWeatherData();

        // Get cache information
        $cacheInfo = [
            'driver' => config('cache.default'),
            'path' => config('cache.stores.file.path'),
        ];

        // Get session information
        $sessionInfo = [
            'driver' => config('session.driver'),
            'lifetime' => config('session.lifetime'),
        ];

        return view('system.index', compact(
            'phpVersion',
            'laravelVersion',
            'databaseInfo',
            'serverInfo',
            'storageInfo',
            'cacheInfo',
            'sessionInfo',
            'weatherInfo'
        ));
    }
} 