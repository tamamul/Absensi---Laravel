<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('regu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_regu');
            $table->timestamps();
        });

        Schema::create('regu_satpam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regu_id')->constrained('regu')->onDelete('cascade');
            $table->foreignId('satpam_id')->constrained('datasatpam')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['regu_id', 'satpam_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('regu_satpam');
        Schema::dropIfExists('regu');
    }
}; 