<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MPreinvoice extends Model
{

    use HasFactory;
    protected $table = 'preinvoice';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'piid';
    //public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    public function getcustomer() {
        return $this->belongsTo(MCustomer::class, 'kdcustomer', 'kdcustomer');
    }
    public function getkategori() {
        return $this->belongsTo(MKategori::class, 'kdkategori', 'kdkategori');
    }


    public function scopeStatus($query, $status)
    {
        return $query->where('f_status', $status);
    }


}
