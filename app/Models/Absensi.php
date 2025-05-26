<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'satpam_id',
        'tanggal',
        'status', // Misalnya: hadir, izin, sakit, tidak hadir
    ];
    protected $casts = [
        'tanggal' => 'date',
    ];
    public function satpam()
    {
        return $this->belongsTo(Datasatpam::class, 'satpam_id');
    }
}
