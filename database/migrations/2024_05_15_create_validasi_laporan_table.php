<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('validasi_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('upt_id')->constrained('upt');
            $table->foreignId('ultg_id')->constrained('ultg');
            $table->foreignId('lokasikerja_id')->constrained('lokasikerja');
            $table->date('periode'); // Untuk menyimpan periode bulan dan tahun
            $table->boolean('is_validated')->default(false);
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikasi validasi
            $table->unique(['upt_id', 'ultg_id', 'lokasikerja_id', 'periode']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('validasi_laporan');
    }
}; 