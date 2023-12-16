<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MInvoice extends Model
{

    use HasFactory;
    protected $table = 'invoice';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'noinvoice';
    public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    public function getdetailinvoice() {
        return $this->hasMany(MDetailinvoice::class, 'noinvoice', 'noinvoice');
    }
    public function getshipment() {
        return $this->belongsTo(MShipment::class, 'shipmentid', 'shipmentid');
    }


}
