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
        Schema::create('lokasikerja', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lokasikerja');
            $table->foreignId('ultg_id')->constrained('ultg')->onDelete('cascade');
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->integer('radius')->comment('Radius dalam meter');
            $table->timestamps();
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
