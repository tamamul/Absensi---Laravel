<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwalsatpam extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = [
        'satpam_id',
        'regu_id',
        'upt_id',
        'ultg_id',
        'lokasi_kerja_id',
        'tanggal',
        'shift',
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
    public function lokasiKerja()
    {
        return $this->belongsTo(LokasiKerja::class, 'lokasi_kerja_id');
    }

    public function datasatpam()
    {
        return $this->belongsTo(Datasatpam::class, 'satpam_id');
    }

    public function regu()
    {
        return $this->belongsTo(Regu::class, 'regu_id');
    }
}
