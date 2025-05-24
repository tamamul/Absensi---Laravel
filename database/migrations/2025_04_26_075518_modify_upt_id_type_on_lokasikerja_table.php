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
        Schema::table('lokasikerja', function (Blueprint $table) {
            // Hapus foreign key kalau sudah ada
            $table->dropForeign(['upt_id']);

            // Ubah kolom upt_id jadi unsignedBigInteger
            $table->unsignedBigInteger('upt_id')->change();

            // Tambah lagi foreign key-nya
            $table->foreign('upt_id')->references('id')->on('upt')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('lokasikerja', function (Blueprint $table) {
            $table->dropForeign(['upt_id']);
            $table->string('upt_id')->change(); // Atur ulang ke sebelumnya jika perlu
        });
    }
};
