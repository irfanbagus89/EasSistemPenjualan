<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjualan extends Model
{
    use HasFactory;
    protected $table='penjualans';
    protected $primaryKey = 'id_pen';
    public $timestamps=false;

    public function detailPen(){
        return $this->belongsTo(detailpen::class,'id_pen','id_pen');
    }
}
