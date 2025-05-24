<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Upt;

class Ultg extends Model
{
    //
    use HasFactory;
    protected $table = 'ultg';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_upt'];
    public $incrementing = false;
    protected $keyType = 'string';
    public function upt()
    {
        return $this->belongsTo(Upt::class, 'upt_id');
    }
    
}
