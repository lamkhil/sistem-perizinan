<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('no_permohonan')->unique()->nullable();
            $table->string('nama_usaha')->nullable();
            $table->string('jenis_pelaku_usaha')->nullable();
            $table->string('jenis_perusahaan')->nullable();
            $table->string('nik')->nullable();
            $table->date('tanggal_permohonan')->nullable();
            $table->string('nib')->nullable();
            $table->text('alamat_perusahaan')->nullable();
            $table->string('sektor')->nullable();
            $table->decimal('modal_usaha', 15, 2)->nullable();
            $table->string('jenis_proyek')->nullable();
            $table->string('no_proyek')->nullable();
            $table->string('verifikator')->nullable();
            $table->string('verifikasi_dpmptsp')->nullable();
            $table->string('verifikasi_pd_teknis')->nullable();
            $table->string('status')->default('Menunggu Diproses'); // default status
            
            // Tracking field (Admin/DPMPTSP)
            $table->date('pengembalian')->nullable();
            $table->text('keterangan_pengembalian')->nullable();
            $table->date('menghubungi')->nullable();
            $table->text('keterangan_menghubungi')->nullable();
            $table->string('status_menghubungi')->nullable();
            $table->date('perbaikan')->nullable();
            $table->text('keterangan_perbaikan')->nullable();
            $table->date('terbit')->nullable();
            $table->text('keterangan_terbit')->nullable();
            $table->string('pemroses_dan_tgl_surat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};