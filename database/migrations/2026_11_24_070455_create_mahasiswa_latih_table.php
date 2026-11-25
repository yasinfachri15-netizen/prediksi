<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa_latih', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 30)->unique();
            $table->string('nama', 120);
            $table->integer('angkatan')->default(2022);
            $table->decimal('ipk', 3, 2)->default(0.00);
            $table->integer('sks_diambil')->default(0);
            $table->integer('sks_lulus')->default(0);
            $table->integer('jumlah_e')->default(0);
            $table->integer('jumlah_d_cd')->default(0);
            $table->integer('jumlah_c')->default(0);
            $table->decimal('rata_rata_inti', 3, 2)->default(0.00);
            $table->tinyInteger('status_kelulusan')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_latih');
    }
};