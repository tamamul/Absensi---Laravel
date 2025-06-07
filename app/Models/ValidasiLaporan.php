<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiLaporan extends Model
{
    protected $table = 'validasi_laporan';
    
    protected $fillable = [
        'upt_id',
        'ultg_id',
        'lokasikerja_id',
        'periode',
        'is_validated',
        'validated_at'
    ];

    protected $casts = [
        'periode' => 'date',
        'is_validated' => 'boolean',
        'validated_at' => 'datetime'
    ];

    public function upt()
    {
        return $this->belongsTo(Upt::class);
    }

    public function ultg()
    {
        return $this->belongsTo(Ultg::class);
    }

    public function lokasikerja()
    {
        return $this->belongsTo(Lokasikerja::class);
    }
} 