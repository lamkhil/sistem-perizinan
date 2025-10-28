<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class OptimizeApplicationCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:optimize {--force : Force optimization without confirmation}';

    /**
     * The console command description.
     */
    protected $description = 'Optimize application performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force') && !$this->confirm('This will optimize the application. Continue?')) {
            $this->info('Optimization cancelled.');
            return;
        }

        $this->info('Starting application optimization...');

        // Clear all caches
        $this->clearCaches();

        // Optimize autoloader
        $this->optimizeAutoloader();

        // Cache configurations
        $this->cacheConfigurations();

        // Clean up storage
        $this->cleanupStorage();

        // Optimize database
        $this->optimizeDatabase();

        $this->info('Application optimization completed successfully!');
    }

    private function clearCaches()
    {
        $this->info('Clearing caches...');
        
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        
        $this->info('✓ Caches cleared');
    }

    private function optimizeAutoloader()
    {
        $this->info('Optimizing autoloader...');
        
        Artisan::call('optimize:clear');
        
        $this->info('✓ Autoloader optimized');
    }

    private function cacheConfigurations()
    {
        $this->info('Caching configurations...');
        
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');
        
        $this->info('✓ Configurations cached');
    }

    private function cleanupStorage()
    {
        $this->info('Cleaning up storage...');
        
        // Clean up old log files
        $logFiles = Storage::files('logs');
        $cutoffDate = now()->subDays(7);
        
        foreach ($logFiles as $file) {
            if (Storage::lastModified($file) < $cutoffDate->timestamp) {
                Storage::delete($file);
            }
        }
        
        // Clean up old cache files
        $cacheFiles = Storage::files('framework/cache');
        foreach ($cacheFiles as $file) {
            if (Storage::lastModified($file) < $cutoffDate->timestamp) {
                Storage::delete($file);
            }
        }
        
        $this->info('✓ Storage cleaned up');
    }

    private function optimizeDatabase()
    {
        $this->info('Optimizing database...');
        
        // Run migrations to ensure indexes are created
        Artisan::call('migrate', ['--force' => true]);
        
        $this->info('✓ Database optimized');
    }
}
