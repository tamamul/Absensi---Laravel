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
            //
            // Ubah kolom upt_id jadi varchar(20)
            $table->string('upt_id', 20)->change();
            
            // Ubah kolom ultg_id jadi varchar(255)
            $table->string('ultg_id', 255)->change();

            // Hapus foreign key lama kalau ada
            $table->dropForeign(['upt_id']);
            $table->dropForeign(['ultg_id']);

            // Tambahkan foreign key baru
            $table->foreign('upt_id')->references('id')->on('upt')->onDelete('cascade');
            $table->foreign('ultg_id')->references('id')->on('ultg')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lokasikerja', function (Blueprint $table) {
            //
            // Rollback perubahan kolom
            $table->unsignedBigInteger('upt_id')->change();
            $table->unsignedBigInteger('ultg_id')->change();

            // Hapus foreign key baru
            $table->dropForeign(['upt_id']);
            $table->dropForeign(['ultg_id']);
        });
    }
};
