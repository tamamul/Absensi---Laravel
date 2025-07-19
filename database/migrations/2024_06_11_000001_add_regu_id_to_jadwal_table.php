<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->unsignedBigInteger('regu_id')->nullable()->after('satpam_id');
            $table->foreign('regu_id')->references('id')->on('regu')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropForeign(['regu_id']);
            $table->dropColumn('regu_id');
        });
    }
}; 