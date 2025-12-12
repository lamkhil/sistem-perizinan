<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('Masukkan email tujuan untuk test');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('❌ Email tidak valid!');
            return 1;
        }

        $this->info('📧 Mengirim test email ke: ' . $email);
        $this->info('⏳ Mohon tunggu...');

        try {
            Mail::raw('Ini adalah test email dari Sistem Perizinan DPMPTSP. Jika Anda menerima email ini, berarti konfigurasi SMTP sudah benar!', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - Sistem Perizinan DPMPTSP');
            });

            $this->info('✅ Email berhasil dikirim!');
            $this->info('📬 Silakan cek inbox email: ' . $email);
            $this->info('💡 Jangan lupa cek folder Spam jika email tidak muncul di inbox.');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Gagal mengirim email!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->warn('💡 Tips troubleshooting:');
            $this->line('1. Pastikan MAIL_MAILER=smtp di file .env');
            $this->line('2. Pastikan MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD sudah benar');
            $this->line('3. Untuk Gmail, gunakan App Password, bukan password biasa');
            $this->line('4. Cek firewall server (port 587 atau 465 harus terbuka)');
            $this->line('5. Jalankan: php artisan config:clear');
            
            return 1;
        }
    }
}

