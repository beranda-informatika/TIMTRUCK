<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MQuotation extends Model
{

    use HasFactory;
    protected $table = 'quotations';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    public function getgroupquotation(){
        return $this->belongsTo(MGroupquotation::class, 'groupquotationid', 'groupquotationid');
    }
    public function getcustomer(){
        return $this->belongsTo(MCustomer::class, 'kdcustomer', 'kdcustomer');
    }
    public function gettypetruck(){
        return $this->belongsTo(MTypetruck::class, 'typetruckid', 'typetruckid');
    }
    public function get_detailrate(){
        return $this->hasMany(MDetailratequotation::class, 'quotationid','id' );
    }

    public function scopeNewOrder($query)
    {
        return $query->where('f_status', 'new');
    }
    public function scopeAccso($query)
    {
        return $query->where('f_accso', '1');
    }


}
