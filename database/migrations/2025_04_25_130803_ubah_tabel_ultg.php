<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <== penting untuk cek foreign key manual

return new class extends Migration
{
    public function up(): void
{
    // Hapus FK dari tabel 'datasatpam' dan 'lokasikerja'
    if (Schema::hasTable('datasatpam')) {
        Schema::table('datasatpam', function (Blueprint $table) {
            $table->dropForeign(['ultg_id']);
        });
    }

    if (Schema::hasTable('lokasikerja')) {
        Schema::table('lokasikerja', function (Blueprint $table) {
            $table->dropForeign(['ultg_id']);
        });
    }

    // Ubah kolom foreign key jadi string DULU
    Schema::table('lokasikerja', function (Blueprint $table) {
        $table->string('ultg_id')->change();
    });

    Schema::table('datasatpam', function (Blueprint $table) {
        $table->string('ultg_id')->change();
    });

    // Baru ubah kolom id di ultg
    Schema::table('ultg', function (Blueprint $table) {
        $table->string('id')->change();
    });

    // Balikin foreign key constraint
    Schema::table('lokasikerja', function (Blueprint $table) {
        $table->foreign('ultg_id')->references('id')->on('ultg')->onDelete('cascade');
    });

    Schema::table('datasatpam', function (Blueprint $table) {
        $table->foreign('ultg_id')->references('id')->on('ultg')->onDelete('cascade');
    });
}

    public function down(): void
    {
        // Cek foreign key juga sebelum drop
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'datasatpam' 
            AND COLUMN_NAME = 'ultg_id' 
            AND CONSTRAINT_SCHEMA = DATABASE();
        ");

        foreach ($foreignKeys as $fk) {
            if ($fk->CONSTRAINT_NAME == 'datasatpam_ultg_id_foreign') {
                Schema::table('datasatpam', function (Blueprint $table) {
                    $table->dropForeign(['ultg_id']);
                });
            }
        }

        Schema::table('ultg', function (Blueprint $table) {
            $table->integer('id')->change();
        });

        Schema::table('datasatpam', function (Blueprint $table) {
            $table->integer('ultg_id')->change();
        });

        Schema::table('datasatpam', function (Blueprint $table) {
            $table->foreign('ultg_id')->references('id')->on('ultg')->onDelete('cascade');
        });
    }
};
