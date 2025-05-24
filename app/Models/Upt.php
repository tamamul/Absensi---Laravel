<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upt extends Model
{
    //
    use HasFactory;
    protected $table = 'upt';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_upt'];
    public $incrementing = false;
    protected $keyType = 'string';
    public function ultg()
    {
        return $this->hasMany(Ultg::class, 'upt_id');
    }
}
