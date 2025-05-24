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
        Schema::table('datasatpam', function (Blueprint $table) {
            //
            $table->dropColumn(['latitude', 'longitude', 'radius']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datasatpam', function (Blueprint $table) {
            //
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->integer('radius')->comment('Radius dalam meter');
        });
    }
};
