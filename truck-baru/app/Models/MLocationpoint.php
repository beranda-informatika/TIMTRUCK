<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MLocationpoint extends Model
{

    use HasFactory;
    protected $table = 'locationpoint';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
   /// public $keyType = 'string';
    //public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    function getshipment()
    {
        return $this->belongsTo(Mshipment::class, 'shipmentid', 'shipmentid');
    }
    public function scopeMultiDrop($query, $shipmentid)
    {
        return $query->where('typelocation', 'drop')->get();
    }
    public function scopeMultiPikcup($query, $shipmentid)
    {
        return $query->where('typelocation', 'pickup')->get();
    }
}
