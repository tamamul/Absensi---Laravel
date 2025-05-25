<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datasatpam extends Model
{
    use HasFactory;

    protected $table = 'datasatpam';

    protected $fillable = [
        'id',
        'nip',
        'nik',
        'foto',
        'nama',
        'status',
        'no_kontrak',
        'kontrak',
        'tmt',
        'jabatan',
        'upt_id',
        'ultg_id',
        'lokasi_kerja_id',
        'wilayah_kerja',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'warga_negara',
        'agama',
        'no_hp',
        'email',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'negara',
        'nama_ibu',
        'kontak_darurat',
        'nama_kontak_darurat',
        'ahli_waris',
        'tempat_lahir_ahli_waris',
        'tanggal_lahir_ahli_waris',
        'hubungan_ahli_waris',
        'status_nikah',
        'jumlah_anak',
        'npwp',
        'nama_bank',
        'no_rekening',
        'nama_pemilik_rekening',
        'no_dplk',
        'pendidikan_terakhir',
        'sertifikasi',
        'no_reg_kta',
        'no_kta',
        'polda',
        'polres',
        'bpjs_kesehatan',
        'bpjs_ketenagakerjaan',
        'ukuran_baju',
        'ukuran_celana',
        'ukuran_sepatu',
        'ukuran_topi',
    ];

    // Relasi ke UPT
    public function upt()
    {
        return $this->belongsTo(Upt::class);
    }

    // Relasi ke ULTG
    public function ultg()
    {
        return $this->belongsTo(Ultg::class);
    }

    // Relasi ke Lokasi Kerja
    public function lokasikerja()
    {
        return $this->belongsTo(Lokasikerja::class, 'lokasikerja_id');
    }
}
