<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDetailrevenue extends Model
{

    use HasFactory;
    protected $table = 'detailrevenue';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    //public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    public function getrate() {
        return $this->belongsTo(MRate::class, 'rateid', 'rateid');
    }
    function getshipment(){
        return $this->belongsTo(MShipment::class,'shipmentid','shipmentid');
    }



}
