<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDetailujoongoing extends Model
{

    use HasFactory;
    protected $table = 'detailujoongoing';

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
    public function scopeStatusInvoice($query, $status)
    {
        return $query->where('f_invoice', $status);
    }



}
