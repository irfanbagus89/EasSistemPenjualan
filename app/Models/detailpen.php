<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailpen extends Model
{
    use HasFactory;
    protected $table='detailpens';
    protected $primaryKey = 'id_detail';
    protected $foreignKey1 = 'id_obat';
    protected $foreignKey2 = 'id_pen';
    public $timestamps=false;
    public function obat(){
       return $this->belongsTo(obat::class,'id_obat','id_obat');
    }
    public function penjualan(){
        return $this->belongsTo(penjualan::class,'id_pen','id_pen');
    }
}
