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
        Schema::create('datasatpam', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nik')->unique();
            $table->string('foto');
            $table->string('nama');
            $table->enum('pekerjaan', ['Satpam'])->default('Satpam');
            $table->enum('status', ['PKWT', 'PKWTT']);
            $table->string('no_pkwt_pkwtt')->unique();
            $table->string('kontrak');
            $table->date('terhitung_mulai_tugas');
            $table->enum('jabatan', ['Komandan Regu', 'Anggota']);
            $table->foreignId('upt_id')->constrained('upt')->onDelete('cascade');
            $table->foreignId('ultg_id')->constrained('ultg')->onDelete('cascade');
            $table->foreignId('lokasikerja_id')->constrained('lokasikerja')->onDelete('cascade');
            $table->string('wilayah_kerja');
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->integer('radius')->comment('Radius dalam meter');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('usia');
            $table->enum('warga negara', ['WNI', 'WNA']);
            $table->string('agama');
            $table->string('no_hp');
            $table->string('email');
            $table->text('alamat');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->string('negara');
            $table->string('nama_ibu');
            $table->string('no_kontak_darurat');
            $table->string('nama_kontak_darurat');
            $table->string('nama_ahli_waris');
            $table->string('tempat_lahir_ahli_waris');
            $table->date('tanggal_lahir_ahli_waris');
            $table->string('hub_ahli_waris');
            $table->enum('status_nikah', ['TK', 'K', 'K1', 'K2', 'K3', 'K4']);
            $table->integer('jumlah_anak');
            $table->string('npwp')->Unique();
            $table->string('nama_bank');
            $table->string('no_rek')->unique();
            $table->string('nama_pemilik_rek');
            $table->string('no_dplk')->unique();
            $table->string('pend_terakhir');
            $table->enum('sertifikasi_satpam', ['Gada Pratama', 'Gada Madya', 'Gada Utama']);
            $table->string('no_reg_kta')->unique();
            $table->string('no_kta')->unique();
            $table->string('polda');
            $table->string('polres');
            $table->string('no_bpjs_kesehatan')->unique();
            $table->string('no_bpjs_ketenagakerjaan')->unique();
            $table->enum('ukuran_baju', ['S', 'M', 'L', 'XL', 'XXL']);
            $table->integer('ukuran_celana');
            $table->integer('ukuran sepatu');
            $table->integer('ukuran_topi');
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
