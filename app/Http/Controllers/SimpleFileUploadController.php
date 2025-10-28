<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

trait SimpleFileUploadController
{
    /**
     * Handle simple file upload with basic optimization
     */
    protected function handleSimpleFileUpload($file, $directory, $filename = null)
    {
        try {
            // Generate filename if not provided
            if (!$filename) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            }

            // Basic file validation
            $maxSize = config('optimization.file_upload.max_size', 10240) * 1024; // Convert to bytes
            if ($file->getSize() > $maxSize) {
                throw new \Exception('File size exceeds maximum allowed size');
            }

            // Check file type
            $allowedTypes = config('optimization.file_upload.allowed_types', ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);
            $extension = strtolower($file->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedTypes)) {
                throw new \Exception('File type not allowed');
            }

            // Store file
            $path = $file->storeAs($directory, $filename, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to store file');
            }

            Log::info("File uploaded successfully: {$path}");
            return $path;

        } catch (\Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get file size in human readable format
     */
    protected function getFileSize($file)
    {
        $bytes = $file->getSize();
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Clean up old files
     */
    protected function cleanupOldFiles($directory, $keepDays = 30)
    {
        try {
            $files = Storage::disk('public')->files($directory);
            $cutoffDate = now()->subDays($keepDays);

            foreach ($files as $file) {
                $lastModified = Storage::disk('public')->lastModified($file);
                if ($lastModified < $cutoffDate->timestamp) {
                    Storage::disk('public')->delete($file);
                    Log::info("Cleaned up old file: {$file}");
                }
            }
        } catch (\Exception $e) {
            Log::error('File cleanup failed: ' . $e->getMessage());
        }
    }

    /**
     * Validate file upload
     */
    protected function validateFileUpload($file, $rules = [])
    {
        $defaultRules = [
            'max_size' => 10240, // 10MB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'],
        ];

        $rules = array_merge($defaultRules, $rules);

        // Check file size
        if ($file->getSize() > ($rules['max_size'] * 1024)) {
            return ['valid' => false, 'error' => 'File size exceeds maximum allowed size'];
        }

        // Check file type
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $rules['allowed_types'])) {
            return ['valid' => false, 'error' => 'File type not allowed'];
        }

        return ['valid' => true];
    }
}
