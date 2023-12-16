<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MGroupquotation extends Model
{

    use HasFactory;
    protected $table = 'groupquotations';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'groupquotationid';
    public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    public function getcustomer(){
        return $this->belongsTo(MCustomer::class, 'kdcustomer', 'kdcustomer');
    }
    public function getkategori(){
        return $this->belongsTo(MKategori::class, 'kdkategori');
    }
    public function getquotation(){
        return $this->hasMany(MQuotation::class, 'groupquotationid','groupquotationid' );
    }
    public function scopeAccso($query)
    {
        return $query->where('f_accso', '1');
    }
    public function scopeAccquotation($query, $id, $status)
    {
        return $query->where('f_accquotation', $status)->where('groupquotationid', $id);
    }


}
