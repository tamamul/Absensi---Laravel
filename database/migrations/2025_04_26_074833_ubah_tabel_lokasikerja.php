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
        //
        Schema::table('lokasikerja', function (Blueprint $table) {
            // Jangan tambah kolom, cukup tambahkan foreign key
            $table->foreign('upt_id')->references('id')->on('upt')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('lokasikerja', function (Blueprint $table) {
            $table->dropForeign(['upt_id']);
        });
    }
};
