<?php

namespace App\Http\Controllers;

use App\Models\MDetailratequotation;
use App\Models\MDetailshipment;
use App\Models\MInvoice;
use App\Models\MKategori;
use App\Models\MProject;
use App\Models\MQuotation;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MShipment;
use App\Models\MPreinvoice;
use App\Models\MDetailpreinvoice;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
class PreinvoiceController extends Controller
{
    public function genkode($kategori)
    {
        $bulan=date('m');

        $kode = MPreinvoice::whereRaw("SUBSTRING(piid, 9,  3) = '$kategori'")
        ->whereRaw('SUBSTRING(piid, 13,  2) = '.$bulan)->max('piid');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 3,4);
            $noUrut++;

        }
        $char = "PI.";
        $newID = $char . sprintf("%04s", $noUrut).".".$kategori.".".date('m') . "." . date('Y');
        return $newID;
    }
    public function index()
    {
        $shipment = MShipment::get();
        return view('preinvoice.index', compact('shipment'));
    }
    public function getpreinvoice(Request $request)
    {
        if ($request->kdcustomer == "all") {
            $preinvoice = MPreinvoice::where('f_status','open')->get();
        } else {
            $preinvoice = MPreinvoice::where('kdcustomer',$request->kdcustomer)->where('f_status','open')->get();
        }
        return view('preinvoice.preinvoice', compact('preinvoice'));
    }
    public function create()
    {
        return view('preinvoice.create');
    }

    public function getsalesorder(Request $request)
    {
        $kdcustomer = $request->kdcustomer;
        $kategori = MKategori::get();
        if ($request->kdcustomer == "all") {
            $shipment = MShipment::where('f_status','Settlement')->where('f_pi','0')->get();
        } else {
            $shipment = MShipment::where('kdcustomer',$request->kdcustomer)->where('f_status','Settlement')->where('f_pi','0')->get();
        }
        return view('preinvoice.salesorder', compact('shipment','kdcustomer','kategori'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'listshipment' => 'required',
            'project' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $preinvoice = new MPreinvoice();
            $preinvoice->piid = $this->genkode($request->kdkategori);
            $preinvoice->kdcustomer = $request->kdcustomer;
            $preinvoice->project = $request->project;
            $preinvoice->datecreate = Carbon::now();
            $preinvoice->kdkategori = $request->kdkategori;
            $preinvoice->f_status = 'open';
            $simpan = $preinvoice->save();
            $piid = $preinvoice->piid;

            foreach ($request->listshipment as $item => $value) {
                MDetailpreinvoice::create([
                    'shipmentid' => $value,
                    'piid' => $piid,
                ]);

            }
            return Redirect()->route('preinvoice.index')->with('success', 'Data Berhasil Disimpan');

        }

    }


    public function pdfpreinvoice($id)
    {
        $preinvoice = MPreinvoice::where('piid',$id)->get();
        $shipment = MDetailpreinvoice::with('getshipment')
        ->where('piid',$id)
        ->orderby('piid', 'asc')
        ->get();

        return PDF::loadView('preinvoice.pdfpreinvoice', compact('preinvoice', 'shipment'))
        ->setPaper('a4', 'landscape')
        ->stream('preinvoice.pdf');

    }
    public function edit($id)
    {
        $kategori = MKategori::get();
        $preinvoice = MPreinvoice::find($id);
        $shipment = MDetailpreinvoice::with('getshipment')
        ->where('piid',$id)
        ->orderby('piid', 'asc')
        ->get();
        return view('preinvoice.edit', compact('preinvoice', 'shipment','kategori'));
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'listshipment' => 'required',
            'project' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $preinvoice = MPreinvoice::find($id);
            $preinvoice->kdcustomer = $request->kdcustomer;
            $preinvoice->project = $request->project;
            $preinvoice->datecreate = Carbon::now();
            $preinvoice->kdkategori = $request->kdkategori;
            $simpan = $preinvoice->save();

            $hapus = MDetailpreinvoice::where('piid',$id)->delete();
            foreach ($request->listshipment as $item => $value) {
                $cek=MDetailpreinvoice::where('shipmentid',$value)->where('piid',$id)->count();
                if ($cek==0) {
                    MDetailpreinvoice::create([
                        'shipmentid' => $value,
                        'piid' => $id,
                    ]);
                }
            }
            return Redirect()->route('preinvoice.index')->with('success', 'Data Berhasil Disimpan');

        }

    }
    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
                MDetailpreinvoice::where('piid', '=', $id)->delete();
                MPreinvoice::where('piid', '=', $id)->delete();
                DB::commit();
                Alert::success('sukses dihapus');
                return redirect()->route('preinvoice.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('preinvoice.index');
        }
    }

}
