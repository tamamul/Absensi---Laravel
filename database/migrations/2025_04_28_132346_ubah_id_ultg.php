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
        // 1. Drop foreign key di lokasikerja
        Schema::table('lokasikerja', function (Blueprint $table) {
            $table->dropForeign(['ultg_id']);
        });

        // 2. Ubah kolom id di ultg jadi varchar
        Schema::table('ultg', function (Blueprint $table) {
            $table->dropPrimary(); // drop primary key dulu
            $table->string('id', 20)->change(); // ubah tipe
            $table->primary('id'); // set primary lagi
        });

        // 3. Tambahkan foreign key ulang di lokasikerja
        Schema::table('lokasikerja', function (Blueprint $table) {
            $table->foreign('ultg_id')->references('id')->on('ultg')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
