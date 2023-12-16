<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MRute extends Model
{

    use HasFactory;
    protected $table = 'rute';

    #kalau kolom primary keynya bernama id, maka baris dibawah ini boleh diisi, dan boleh juga tidak buat
    protected $primaryKey = 'routeid';
    public $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    // In Laravel 6.0+ make sure to also set $keyType
    //protected $keyType = 'string';

    protected $guarded = [];
    public function gettypetruck() {
        return $this->belongsTo(MTypetruck::class, 'typetruckid', 'typetruckid');
    }
    public function getproject() {
        return $this->belongsTo(MProject::class, 'kdproject', 'kdproject');
    }
    public function getkategori() {
        return $this->belongsTo(MKategori::class, 'kdkategori', 'kdkategori');
    }
    public function getdetailrute() {
        return $this->hasMany(MDetailrute::class, 'routeid', 'routeid');
        
    }


}
