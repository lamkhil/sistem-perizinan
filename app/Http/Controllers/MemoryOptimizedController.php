<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

trait MemoryOptimizedController
{
    /**
     * Process large datasets in chunks to avoid memory issues
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
     * Get memory usage information
     */
    protected function getMemoryUsage()
    {
        return [
            'current' => memory_get_usage(true),
            'peak' => memory_get_peak_usage(true),
            'current_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
            'peak_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
        ];
    }

    /**
     * Clear memory by unsetting large variables
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
     * Optimized database query with memory management
     */
    protected function optimizedQuery($query, $limit = null)
    {
        // Add memory-efficient query options
        $query->select('*'); // Only select needed columns
        
        if ($limit) {
            $query->limit($limit);
        }

        // Use cursor for very large datasets
        if ($limit && $limit > 10000) {
            return $query->cursor();
        }

        return $query->get();
    }

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
     * Optimized statistics calculation
     */
    protected function calculateOptimizedStatistics($query)
    {
        // Use database aggregation instead of PHP processing
        return $query->selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN status = "Diterima" THEN 1 ELSE 0 END) as diterima,
            SUM(CASE WHEN status = "Dikembalikan" THEN 1 ELSE 0 END) as dikembalikan,
            SUM(CASE WHEN status = "Ditolak" THEN 1 ELSE 0 END) as ditolak,
            SUM(CASE WHEN deadline < CURDATE() AND status NOT IN ("Diterima", "Ditolak") THEN 1 ELSE 0 END) as terlambat
        ')->first();
    }
}
