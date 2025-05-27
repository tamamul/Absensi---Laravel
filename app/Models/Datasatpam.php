<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datasatpam extends Model
{
    use HasFactory;

    protected $table = 'datasatpam';

    protected $fillable = [
        'kode_satpam',
        'nip',
        'nik',
        'foto',
        'nama',
        'pekerjaan',
        'status',
        'no_pkwt_pkwtt',
        'kontrak',
        'terhitung_mulai_tugas',
        'jabatan',
        'lokasikerja_id',
        'wilayah_kerja',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'usia',
        'warga negara',
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
        'no_kontak_darurat',
        'nama_kontak_darurat',
        'nama_ahli_waris',
        'tempat_lahir_ahli_waris',
        'tanggal_lahir_ahli_waris',
        'hub_ahli_waris',
        'status_nikah',
        'jumlah_anak',
        'npwp',
        'nama_bank',
        'no_rek',
        'nama_pemilik_rek',
        'no_dplk',
        'pend_terakhir',
        'sertifikasi_satpam',
        'no_reg_kta',
        'no_kta',
        'polda',
        'polres',
        'no_bpjs_kesehatan',
        'no_bpjs_ketenagakerjaan',
        'ukuran_baju',
        'ukuran_celana',
        'ukuran sepatu',
        'ukuran_topi'
    ];

    protected $dates = [
        'tanggal_lahir',
        'tanggal_lahir_ahli_waris',
        'terhitung_mulai_tugas',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'usia' => 'integer',
        'jumlah_anak' => 'integer',
        'ukuran_celana' => 'integer',
        'ukuran sepatu' => 'integer',
        'ukuran_topi' => 'integer'
    ];

    public function lokasikerja()
    {
        return $this->belongsTo(Lokasikerja::class, 'lokasikerja_id');
    }

    public function ultg()
    {
        return $this->belongsTo(Ultg::class, 'ultg_id');
    }

    public function upt()
    {
        return $this->belongsTo(Upt::class, 'upt_id');
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }
}
