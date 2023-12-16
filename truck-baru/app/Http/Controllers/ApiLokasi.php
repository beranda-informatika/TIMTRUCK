<?php

namespace App\Http\Controllers;

use App\Models\Adds;
use App\Models\MCbu;
use App\Models\MRegion;
use App\Models\MSitename;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class ApiLokasi extends Controller
{
 
    public function getcbu($id)
    {
        $cbu = MCbu::where('id',$id)->get();
        return Response::json($cbu);
    }
    public function getregion($id)
    {
        $region = MRegion::where('idcbu',$id)->get();
        return Response::json($region);
    }
    public function getsitename($id)
    {
        $sitename = MSitename::where('idregion',$id)->get();
        return Response::json($sitename);
    }
    public function setsitename($id)
    {
        $sitename = MSitename::where('id',$id)->first();
       // dd($sitename->getregion->getcbu->namacbu);
        if($sitename->count()==0){
            Session::put('runidcbu','');
            Session::put('runnamacbu','');
            Session::put('runidregion','');
            Session::put('runnamaregion','');
            Session::put('runidsitename',$id);
            Session::put('runnamasitename','');
            return Response::json($sitename);
        }
        else {
            Session::put('runidcbu',$sitename->getregion->getcbu->id);
            Session::put('runnamacbu',$sitename->getregion->getcbu->namacbu);
            Session::put('runidregion',$sitename->getregion->$id);
            Session::put('runnamaregion',$sitename->getregion->namaregion);
            Session::put('runidsitename',$id);
            Session::put('runnamasitename',$sitename->namasitename);

            return Response::json($sitename);
    
        }
    }
   
}
