<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PerformanceMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only monitor in non-production or when explicitly enabled
        if (config('app.env') === 'production' && !config('performance.monitoring.enabled', false)) {
            return $next($request);
        }

        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        $response = $next($request);

        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);

        $executionTime = round(($endTime - $startTime) * 1000, 2); // in milliseconds
        $memoryUsed = round(($endMemory - $startMemory) / 1024 / 1024, 2); // in MB

        // Log slow requests
        $slowThreshold = config('performance.monitoring.slow_query_threshold', 1000);
        if ($executionTime > $slowThreshold) {
            Log::warning('Slow request detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'execution_time' => $executionTime . 'ms',
                'memory_used' => $memoryUsed . 'MB',
                'user_id' => auth()->id(),
            ]);
        }

        // Add performance headers (only in development)
        if (config('app.debug')) {
            $response->headers->set('X-Execution-Time', $executionTime . 'ms');
            $response->headers->set('X-Memory-Used', $memoryUsed . 'MB');
        }

        return $response;
    }
}
