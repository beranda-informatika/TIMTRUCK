<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MDokumentrouble;
use App\Models\MTrouble;
use App\Models\MTroubleaction;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ApiTrouble extends Controller
{
   
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
        $tahun=date('Y');
        $bulan=date('m');
        $periode=$tahun.'-'.$bulan;
        $trouble = New MTroubleaction();
        $trouble->kdunit = $request->kdunit;
        $trouble->periode = $periode;
        $trouble->iduser = $request->iduser;
        
        $tglmulai=new DateTime($request->tanggalmulai.' '.$request->jammulai);
        $tglselesai=new DateTime($request->tanggalakhir.' '.$request->jamselesai);
        $lapsetime = $tglmulai->diff($tglselesai);
        $hari=$lapsetime->format('%d');
        $jam=$lapsetime->format('%H');
        $menit=$lapsetime->format('%I');
        $interval=(($hari*24+$jam)*60)+$menit;

      
        $trouble->tanggalmulai = $tglmulai;
        $trouble->tanggalakhir = $tglselesai;
        $trouble->lapsetime = $interval;

        $trouble->shift = $request->shift;
        $trouble->actionplan = $request->actionplan;
        $trouble->sparepart = $request->sparepart;
        $trouble->statusmekanik = $request->statusmekanik;
        $trouble->save();
        $idaction = $trouble->id;

        return $data = [
            'idaction' => $idaction,
        ];

       
    }
    
    public function listdokumen($id)
    {
        $trouble = MDokumentrouble::where('idaction',$id)
        ->get();
        return Response::json($trouble);
    }
}
