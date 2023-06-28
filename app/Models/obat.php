<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
    use HasFactory;
    protected $table='obats';
    protected $primaryKey = 'id_obat';
    public $timestamps=false;
    public function detailPen(){
        return $this->belongsTo(detailpen::class,'id_obat','id_obat');
    }
}
