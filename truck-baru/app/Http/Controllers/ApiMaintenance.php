<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MDokumenmaintenance;
use App\Models\MMaintenance;
use App\Models\MMaintenanceaction;
use App\Models\MUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ApiMaintenance extends Controller
{
    public function listofunit($idsitename)
    {
        $unit = MUnit::where('idsitename',$idsitename)->get();
        return Response::json($unit);
    }
    public function getunit($id)
    {
        $unit = MUnit::where('kdunit',$id)->get();
        return Response::json($unit);
    }
    public function uploadgallery(Request $request)
    {
        $file = $request->filefoto;
        $pathUpload = 'assets/inventory';

        $extension = $file->getClientOriginalExtension();
        $filename = time() . "." . $extension;
        $file->move($pathUpload, $filename);
        return redirect()->back();
    }
    public function store(Request $request)
    {
        $MMaintenanceaction = New MMaintenanceaction();
        $MMaintenanceaction->kdunit = $request->kdunit;
        $MMaintenanceaction->iduser = $request->iduser;
        $MMaintenanceaction->tanggalmulai = date("y-m-d", strtotime($request->tanggalmulai));
        $MMaintenanceaction->tanggalakhir = date("y-m-d", strtotime($request->tanggalakhir));
        $MMaintenanceaction->shift = $request->shift;
        $MMaintenanceaction->actionplan = $request->actionplan;
        $MMaintenanceaction->sparepart = $request->sparepart;
        $MMaintenanceaction->statusmekanik = $request->statusmekanik;
        $MMaintenanceaction->hm = $request->hm;
        $MMaintenanceaction->save();
        $idaction = $MMaintenanceaction->id;

        $MMaintenance = MUnit::where('kdunit',$request->kdunit)->first();
        $MMaintenance->statusmekanik = $request->statusmekanik;
        $MMaintenance->tanggal = date("y-m-d",strtotime($request->tanggalakhir));
        $MMaintenance->hm = $request->hm;
        $MMaintenance->save();
        
        return $data = [
            'idaction' => $idaction,
        ];

       
    }
    public function listdokumen($id)
    {
        $maintenance = MDokumenmaintenance::where('idaction',$id)
        ->get();
        return Response::json($maintenance);
    }
}
