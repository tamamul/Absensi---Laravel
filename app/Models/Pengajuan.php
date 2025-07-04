<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';
    
    protected $fillable = [
        'satpam_id',
        'tanggal_pengajuan',
        'jenis_pengajuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'bukti_foto',
        'status',
        'catatan_admin'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date'
    ];

    public function datasatpam()
    {
        return $this->belongsTo(Datasatpam::class, 'satpam_id');
    }
} 