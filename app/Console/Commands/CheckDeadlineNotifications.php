<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permohonan;
use App\Models\LogPermohonan;

class CheckDeadlineNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permohonan:check-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for overdue permohonan deadlines and create notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for overdue permohonan deadlines...');

        // Ambil semua permohonan yang memiliki deadline
        $permohonans = Permohonan::whereNotNull('deadline')->get();

        $overdueCount = 0;
        $dueTodayCount = 0;
        $dueSoonCount = 0;

        foreach ($permohonans as $permohonan) {
            $status = $permohonan->getDeadlineStatus();
            
            switch ($status) {
                case 'overdue':
                    // Cek apakah sudah ada notifikasi untuk permohonan ini
                    $existingNotification = LogPermohonan::where('permohonan_id', $permohonan->id)
                        ->where('action', 'deadline_overdue')
                        ->whereDate('created_at', now()->toDateString())
                        ->first();

                    if (!$existingNotification) {
                        // Auto-update status menggunakan method di model
                        $permohonan->updateStatusBasedOnDeadline();
                        
                        // Buat notifikasi tambahan
                        LogPermohonan::create([
                            'permohonan_id' => $permohonan->id,
                            'user_id' => 1, // System user
                            'status_sebelum' => $permohonan->status ?? 'Diterima',
                            'status_sesudah' => 'Terlambat',
                            'keterangan' => "⚠️ PERINGATAN: Permohonan telah melewati deadline ({$permohonan->deadline->format('d/m/Y')})",
                            'action' => 'deadline_overdue',
                            'old_data' => null,
                            'new_data' => json_encode(['deadline' => $permohonan->deadline->toDateString()])
                        ]);
                        $overdueCount++;
                    }
                    break;

                case 'due_today':
                    // Cek apakah sudah ada notifikasi untuk permohonan ini
                    $existingNotification = LogPermohonan::where('permohonan_id', $permohonan->id)
                        ->where('action', 'deadline_due_today')
                        ->whereDate('created_at', now()->toDateString())
                        ->first();

                    if (!$existingNotification) {
                        LogPermohonan::create([
                            'permohonan_id' => $permohonan->id,
                            'user_id' => 1, // System user
                            'status_sebelum' => $permohonan->status ?? 'Diterima',
                            'status_sesudah' => $permohonan->status ?? 'Diterima',
                            'keterangan' => "⏰ PERINGATAN: Permohonan deadline hari ini ({$permohonan->deadline->format('d/m/Y')})",
                            'action' => 'deadline_due_today',
                            'old_data' => null,
                            'new_data' => json_encode(['deadline' => $permohonan->deadline->toDateString()])
                        ]);
                        $dueTodayCount++;
                    }
                    break;

                case 'due_soon':
                    // Cek apakah sudah ada notifikasi untuk permohonan ini
                    // Hanya alert jika h-1 (1 hari sebelum deadline)
                    $daysLeft = now()->diffInDays($permohonan->deadline, false);
                    if ($daysLeft == 1) {
                        $existingNotification = LogPermohonan::where('permohonan_id', $permohonan->id)
                            ->where('action', 'deadline_due_soon')
                            ->whereDate('created_at', now()->toDateString())
                            ->first();

                        if (!$existingNotification) {
                            LogPermohonan::create([
                                'permohonan_id' => $permohonan->id,
                                'user_id' => 1, // System user
                                'status_sebelum' => $permohonan->status ?? 'Diterima',
                                'status_sesudah' => $permohonan->status ?? 'Diterima',
                                'keterangan' => "⏳ Mendekati jatuh tempo: Deadline besok ({$permohonan->deadline->format('d/m/Y')})",
                                'action' => 'deadline_due_soon',
                                'old_data' => null,
                                'new_data' => json_encode(['deadline' => $permohonan->deadline->toDateString()])
                            ]);
                            $dueSoonCount++;
                        }
                    }
                    break;
            }
        }

        $this->info("Deadline check completed:");
        $this->info("- Overdue notifications created: {$overdueCount}");
        $this->info("- Due today notifications created: {$dueTodayCount}");
        $this->info("- Due soon notifications created: {$dueSoonCount}");

        return 0;
    }
}