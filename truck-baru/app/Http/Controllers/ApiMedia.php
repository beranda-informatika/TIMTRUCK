<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MDokumen;
use App\Models\MDokumenmaintenance;
use App\Models\MDokumentrouble;
use App\Models\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class ApiMedia extends Controller
{
    public function store(Request $request)
    {
       // $file =  $request->filegambar;
        $file =  $request->file('image');
        $pathUpload = 'assets/inventory';

        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move($pathUpload, $filename);
        if ($request->transaksi=="trouble") {
            MDokumentrouble::create([
                'idaction' => $request->idaction,
                'filename' => $filename,
                'keterangan' => $request->keterangan,

            ]);
        }
        if ($request->transaksi=="maintenance") {
            MDokumenmaintenance::create([
                'idaction' => $request->idaction,
                'filename' => $filename,
                'keterangan' => $request->keterangan,

            ]);
        }
        return $filename;
    }
}
