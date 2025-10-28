<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait BasicOptimizationController
{
    /**
     * Cache expensive operations
     */
    protected function cacheExpensiveOperation($key, $callback, $ttl = 3600)
    {
        return Cache::remember($key, $ttl, function() use ($callback) {
            return $callback();
        });
    }

    /**
     * Get memory usage information
     */
    protected function getMemoryUsage()
    {
        return [
            'current_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
        ];
    }

    /**
     * Process large datasets in chunks
     */
    protected function processInChunks($query, $chunkSize = 1000, $callback = null)
    {
        $results = collect();
        
        $query->chunk($chunkSize, function ($chunk) use ($results, $callback) {
            if ($callback && is_callable($callback)) {
                $processedChunk = $callback($chunk);
                $results->push($processedChunk);
            } else {
                $results->push($chunk);
            }
        });

        return $results->flatten(1);
    }

    /**
     * Optimized statistics calculation using database aggregation
     */
    protected function calculateOptimizedStatistics($query)
    {
        return $query->selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = "Diterima" THEN 1 ELSE 0 END) as diterima,
            SUM(CASE WHEN status = "Dikembalikan" THEN 1 ELSE 0 END) as dikembalikan,
            SUM(CASE WHEN status = "Ditolak" THEN 1 ELSE 0 END) as ditolak,
            SUM(CASE WHEN deadline < CURDATE() AND status NOT IN ("Diterima", "Ditolak") THEN 1 ELSE 0 END) as terlambat
        ')->first();
    }

    /**
     * Clear memory by unsetting variables
     */
    protected function clearMemory(&$variables)
    {
        foreach ($variables as $variable) {
            unset($variable);
        }
        unset($variables);
        
        // Force garbage collection
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
    }

    /**
     * Batch database operations
     */
    protected function batchInsert($table, $data, $chunkSize = 500)
    {
        $chunks = array_chunk($data, $chunkSize);
        
        foreach ($chunks as $chunk) {
            DB::table($table)->insert($chunk);
        }
    }

    /**
     * Log performance metrics
     */
    protected function logPerformance($operation, $startTime, $memoryStart = null)
    {
        $executionTime = round((microtime(true) - $startTime) * 1000, 2);
        $memoryUsed = $memoryStart ? round((memory_get_usage(true) - $memoryStart) / 1024 / 1024, 2) : 0;
        
        Log::info("Performance: {$operation}", [
            'execution_time_ms' => $executionTime,
            'memory_used_mb' => $memoryUsed,
        ]);
    }
}
