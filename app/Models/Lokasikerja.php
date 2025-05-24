<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasikerja extends Model
{
    use HasFactory;

    protected $table = 'lokasikerja'; // nama tabel
    protected $primaryKey = 'id';     // primary key

    public $incrementing = false;     // karena id buatan sendiri (contoh LOK0001)
    protected $keyType = 'string';    // tipe id nya string

    protected $fillable = [
        'id',
        'upt_id',
        'ultg_id',
        'nama_lokasikerja',
        'latitude',
        'longitude',
        'radius',
    ];

    // relasi ke ultg
    public function upt()
    {
        return $this->belongsTo(Upt::class, 'upt_id', 'id');
    }
    public function ultg()
    {
        return $this->belongsTo(Ultg::class, 'ultg_id', 'id');
    }
}
