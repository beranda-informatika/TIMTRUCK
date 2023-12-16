<?php

namespace App\Http\Controllers;

use App\Models\MCustomer;
use App\Models\MDetailratequotation;
use App\Models\MKategori;
use App\Models\MGroupquotation;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MSales;
use App\Models\MQuotation;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class GroupquotationController extends Controller
{
    public function genkode($kategori)
    {
        $bulan=date('m');

        $kode = MGroupquotation::whereRaw("SUBSTRING(groupquotationid, 9,  3) = '$kategori'")
        ->whereRaw('SUBSTRING(groupquotationid, 13,  2) = '.$bulan)->max('groupquotationid');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 3,4);
            $noUrut++;

        }
        $char = "QF.";
        $newID = $char . sprintf("%04s", $noUrut).".".$kategori.".".date('m') . "." . date('Y');
        return $newID;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $groupquotation = MGroupquotation::withCount(['getquotation as blmacc' => function($query) {
            $query->where('f_accquotation', '0');
        }])
        ->withCount(['getquotation as acc' => function($query) {
            $query->where('f_accquotation', '1');
        }])->orderby('groupquotationid', 'desc')->get();

        return view('groupquotation.index', compact('groupquotation'));
    }

    public function create()
    {
        $kategori = MKategori::get();
        return view('groupquotation.create', compact('kategori'));
    }
    public function edit($id)
    {
        $kategori = MKategori::get();
        $groupquotation = MGroupquotation::find($id);
        return view('groupquotation.edit', compact('groupquotation', 'kategori'));
    }
    public function store(Request $request)
    {
       // dd($this->genkode($request->kdkategori));
        $request->validate([
            'kdkategori' => 'required',
            'kdcustomer' => 'required',
            'datecreated' => 'required',
        ]);

        $quotation = new MGroupquotation;
        $quotation->groupquotationid = $this->genkode($request->kdkategori);
        $quotation->datecreated = $request->datecreated;
        $quotation->kdkategori = $request->kdkategori;
        $quotation->kdcustomer = $request->kdcustomer;
        $quotation->description = $request->description;

        $simpan = $quotation->save();

        if ($simpan) {
            Session::put('groupquotationid', $quotation->groupquotationid);
            Alert::success('Berhasil');
            return redirect()->route('quotation.create');


        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kdkategori' => 'required',
            'kdcustomer' => 'required',
            'datecreated' => 'required',

        ]);

        $quotation = MGroupquotation::find($id);
        $quotation->datecreated = $request->datecreated;
        $quotation->kdkategori = $request->kdkategori;
        $quotation->kdcustomer = $request->kdcustomer;
        $quotation->description = $request->description;
        $quotation->f_accquotation = '0';
        $quotation->f_accso = '0';

        $simpan = $quotation->save();

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('groupquotation.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            MGroupquotation::where('groupquotationid', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('groupquotation.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('groupquotation.index');
        }
    }

    public function docquotation($id)
    {
        $groupquotation = MGroupquotation::where('groupquotationid',$id)->get();
        $quotation = MQuotation::with(['get_detailrate' => function($query) {
            $query->join('rate','detailratequotation.rateid','=','rate.rateid')->orderBy('detailratequotation.rateid', 'asc')
            ->where('rate.rateid', '10011');
        }])
        ->with('getcustomer')
        ->where('groupquotationid',$id)
        ->where('f_accquotation', '1')
        ->orderby('destination', 'asc')
        ->get();
        return view('groupquotation.docquotation', compact('quotation', 'groupquotation'));
    }
    public function pdfquotation($id)
    {
        $groupquotation = MGroupquotation::where('groupquotationid',$id)->get();
        $quotation = MQuotation::with(['get_detailrate' => function($query) {
            $query->join('rate','detailratequotation.rateid','=','rate.rateid')->orderBy('detailratequotation.rateid', 'asc')
            ->where('rate.rateid', '10011');
        }])
        ->with('getcustomer')
        ->where('groupquotationid',$id)
        ->where('f_accquotation', '1')
        ->orderby('destination', 'asc')
        ->get();
        return PDF::loadView('groupquotation.pdfquotation', compact('quotation', 'groupquotation'))
        ->stream('quotation.pdf');

    }
    public function accqts(Request $request)
    {
        $quotation = MGroupquotation::find($request->id);
        $quotation->f_accquotation = '1';
        $quotation->save();
        return redirect()->back();
    }
    public function accso(Request $request)
    {
        $quotation = MGroupquotation::find($request->id);
        $quotation->f_accso = '1';
        $quotation->save();
        return redirect()->back();
    }

    public function getquotation(Request $request)
    {

        $quotation =MGroupquotation::where('kdcustomer',$request->id)
        ->where('f_accso','1')->orderby('datecreated','desc')->get();
        $kdcustomer = $request->id;
        return view('groupquotation.getquotation', compact('quotation','kdcustomer'));

    }
    public function getrouteall(Request $request)
    {
        $aksi=$request->aksi;
        if($aksi=="ubah")
            $shipmentid=$request->shipmentid;
        else
            $shipmentid="";

        $quotation =MQuotation::join('groupquotations','quotations.groupquotationid','=','groupquotations.groupquotationid')
        ->where('groupquotations.kdcustomer',$request->id)
        ->where('groupquotations.f_accso','1')
        ->orderby('destination')->get();
        $kdcustomer = $request->id;
        return view('groupquotation.getroute', compact('quotation','kdcustomer','aksi','shipmentid'));


    }
    public function getroute(Request $request)
    {
        $kdcustomer = $request->id;
        $quotation =MQuotation::with('gettypetruck')->where('groupquotationid',$request->id)
        ->where('f_accquotation','1')->orderby('destination')->get();
        return view('groupquotation.getroute', compact('quotation', 'kdcustomer'));

    }
    public function setroute(Request $request)
    {

        $quotation =MQuotation::with('gettypetruck','getgroupquotation')->where('id',$request->id)->first();
        $kdcustomer=$request->kdcustomer;
        if ($request->aksi=='baru') {
            return view('shipment.formmarketing', compact('quotation','kdcustomer'));
        } else {
            $shipmentid=$request->shipmentid;
            return view('shipment.formchangeroute', compact('quotation','kdcustomer','shipmentid'));
        }

    }
    public function getgroupquotation(Request $request)
    {

        $quotation =MGroupquotation::accso()->where('id', 'LIKE', '%' . $request->search . '%')->get();
        $response = array();
        foreach ($quotation as $value) {
            $response[] = array(
                "id" => $value->id,
                "text" => $value->id . ' - ' . $value->origin . ' - ' . $value->destination,
            );
        }

        return response()->json($response);
    }
    public function tabelrute(Request $request)
    {
        Session::put('groupquotationid', $request->id);
        $groupquotation = MGroupquotation::find($request->id);
        $rute = MQuotation::where('groupquotationid', $request->id)->get();
        return view('groupquotation.tabelrute', compact('rute', 'groupquotation'));
    }


}
