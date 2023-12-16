<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDetailpreinvoice extends Model
{

    use HasFactory;
    protected $table = 'detailpreinvoice';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    //public $keyType = 'string';
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    public function getpreinvoice() {
        return $this->belongsTo(MPreinvoice::class, 'piid', 'piid');
    }
    public function getshipment() {
        return $this->belongsTo(MShipment::class, 'shipmentid', 'shipmentid');
    }



}
