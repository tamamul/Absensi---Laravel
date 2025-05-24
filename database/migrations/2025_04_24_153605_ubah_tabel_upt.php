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
        // Drop semua foreign key ke upt.id
        Schema::table('ultg', function (Blueprint $table) {
            $table->dropForeign(['upt_id']);
        });

        Schema::table('datasatpam', function (Blueprint $table) {
            $table->dropForeign(['upt_id']);
        });

    // Ubah kolom id di upt jadi varchar
        Schema::table('upt', function (Blueprint $table) {
            $table->string('id', 20)->change();
        });

    // Ubah kolom upt_id di tabel lain supaya match
        Schema::table('ultg', function (Blueprint $table) {
            $table->string('upt_id', 20)->change();
            $table->foreign('upt_id')->references('id')->on('upt')->onDelete('cascade');
        });

        Schema::table('datasatpam', function (Blueprint $table) {
            $table->string('upt_id', 20)->change();
            $table->foreign('upt_id')->references('id')->on('upt')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('upt', function (Blueprint $table) {
            $table->integer('id')->change();
        });
    }
};
