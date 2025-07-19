<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regu extends Model
{
    use HasFactory;
    protected $table = 'regu';
    protected $fillable = ['nama_regu'];

    public function satpams()
    {
        return $this->belongsToMany(Datasatpam::class, 'regu_satpam', 'regu_id', 'satpam_id');
    }
} 