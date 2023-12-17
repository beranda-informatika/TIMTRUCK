<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MShipment extends Model
{

    use HasFactory;
    protected $table = 'shipment';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'shipmentid';
    //public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    public function getquotation(){
        return $this->belongsTo(MQuotation::class,'quotationid','id');
    }
    public function getkategori(){
        return $this->belongsTo(MKategori::class,'kdkategori','kdkategori');
    }
    public function gettypetruck(){
        return $this->belongsTo(MTypetruck::class,'typetruckid','typetruckid');
    }
    public function getproject(){
        return $this->belongsTo(MProject::class,'kdproject','kdproject');
    }
    public function getcustomer(){
        return $this->belongsTo(MCustomer::class,'kdcustomer','kdcustomer');
    }
    public function getdriver(){
        return $this->belongsTo(MDriver::class,'kddriver','kddriver');
    }
    public function getsales(){
        return $this->belongsTo(MSales::class,'kdsales','kdsales');
    }
    public function getujo(){
        return $this->belongsTo(MUjo::class,'shipmentid','shipmentid');
    }

    public function getunit(){
        return $this->belongsTo(MUnit::class,'kdunit','kdunit');
    }
    public function scopeStatus($query, $status)
    {
        return $query->where('f_status', $status);
    }
    public function getdetailshipment() {
        return $this->hasMany(MDetailshipment::class, 'shipmentid', 'shipmentid');

    }
    public function getmultidrop(){
        return $this->hasMany(MLocationpoint::class,'shipmentid','shipmentid')->where('typelocation','drop');
    }
    public function getmultipickup(){
        return $this->hasMany(MLocationpoint::class,'shipmentid','shipmentid')->where('typelocation','pickup');
    }

}
