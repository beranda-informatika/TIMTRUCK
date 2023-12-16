<?php

namespace App\Http\Controllers;

use App\Models\MCustomer;
use App\Models\MDetailratequotation;
use App\Models\MKategori;
use App\Models\MQuotation;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MSales;
use App\Models\MGroupquotation;
use App\Models\MProject;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class QuotationController extends Controller
{
    public function genkode()
    {
        $kode = DB::table('quotations')->max('id');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 13);
            $noUrut++;
        }
        $char = "QTT-" . date('m') . "-" . date('Y') . "-";
        $newID = $char . sprintf("%07s", $noUrut);
        return $newID;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $quotation = MQuotation::orderby('id', 'desc')->get();
        return view('quotation.index', compact('quotation'));
    }

    public function create()
    {
        $groupquotation = MGroupquotation::find(Session::get('groupquotationid'));

        return view('quotation.create', compact('groupquotation'));
    }
    public function edit($id)
    {
        $kategori = MKategori::get();
        $quotation = MQuotation::find($id);
        return view('quotation.edit', compact('quotation', 'kategori'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'kdcustomer' => 'required',
            'typetruckid' => 'required',
            'typeroute' => 'required',
            'mrc' => 'required',
        ]);

        $quotation = new MQuotation;
        $quotation->id = $this->genkode();
        $quotation->groupquotationid = Session::get('groupquotationid');
        $quotation->tglrequest = Carbon::now();
        $quotation->origin = Str::upper($request->origin);
        $quotation->destination = Str::upper($request->destination);
        $quotation->kdcustomer = $request->kdcustomer;
        $quotation->typetruckid = $request->typetruckid;
        $quotation->typeroute = $request->typeroute;
        $quotation->minqty = $request->minqty;
        $quotation->mrc = $request->mrc;

        $simpan = $quotation->save();
        //akun mrc
        $detailratequotation=new MDetailratequotation;
        $detailratequotation->quotationid=$quotation->id;
        $detailratequotation->rateid='10011';
        $detailratequotation->nominal=$request->mrc;
        $detailratequotation->qty='1';
        $detailratequotation->jumlah=$request->mrc;
        $detailratequotation->pph='0';
        $detailratequotation->pajak='0';
        $detailratequotation->save();

        //akun fee
        $detailratequotation=new MDetailratequotation;
        $detailratequotation->quotationid=$quotation->id;
        $detailratequotation->rateid='50011';
        $detailratequotation->nominal=0;
        $detailratequotation->qty='1';
        $detailratequotation->jumlah=0;
        $detailratequotation->pph='0';
        $detailratequotation->pajak='0';
        $detailratequotation->save();
        //akun pajak
        $detailratequotation=new MDetailratequotation;
        $detailratequotation->quotationid=$quotation->id;
        $detailratequotation->rateid='50031';
        $detailratequotation->nominal=0;
        $detailratequotation->qty='1';
        $detailratequotation->jumlah=0;
        $detailratequotation->pph='0';
        $detailratequotation->pajak='0';
        $detailratequotation->save();

        $fee=$request->mrc*0.05;
        DB::select('call  updfeequotation(?,?,?)',array($quotation->id,'50011',$fee));


        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('groupquotation.tabelrute', ['id' => Session::get('groupquotationid')]);

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }

    }
    public function tabelrute(Request $request)
    {
        $rute = MQuotation::
            where('origin', 'LIKE', '%' . $request->origin . '%')->
            where('destination', 'LIKE', '%' . $request->destination . '%')->
            where('f_accquotation','1')->
            orderBy('id', 'ASC')->get();
        return view('quotation.tabelrute')->with(['rute' => $rute]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'origin' => 'required',
            'destination' => 'required',
            'mrc' => 'required',
        ]);

        $quotation = MQuotation::find($id);
        $quotation->origin = Str::upper($request->origin);
        $quotation->destination = Str::upper($request->destination);
        $quotation->typeroute = $request->typeroute;
        $quotation->minqty = $request->minqty;
        $quotation->mrc = $request->mrc;
        $quotation->f_accquotation = "0";

        $quotation->f_accso ='0';


        $simpan = $quotation->save();

        $dataratequotation=MDetailratequotation::where('quotationid',$id)->where('rateid','10011')->first();
        $dataratequotation->nominal=$request->mrc;
        $dataratequotation->jumlah=$request->mrc;
        $dataratequotation->save();
        $fee=$request->mrc*0.05;
        DB::select('call  updfeequotation(?,?,?)',array($quotation->id,'50011',$fee));

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('groupquotation.tabelrute', ['id' => Session::get('groupquotationid')]);

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            MQuotation::where('id', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('groupquotation.tabelrute', ['id' => Session::get('groupquotationid')]);
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->back();
        }
    }
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function formincustomer()
    {
        return view('quotation.formincustomer');
    }
    public function forminsales()
    {
        return view('quotation.forminsales');
    }
    public function forminproject()
    {
        return view('quotation.forminproject');
    }
    public function customerstore(Request $request)
    {
        $request->validate([
            'kdcustomer' => 'required|regex:/^\S*$/u|unique:customer,kdcustomer',
            'namacustomer' => 'required',
        ]);

        $customer = new MCustomer;
        $customer->kdcustomer = $request->kdcustomer;
        $customer->namacustomer = $request->namacustomer;
        $simpan = $customer->save();

        if ($simpan) {
            return '{"status":"1"}';
        } else {
            return '{"status":"0"}';

        }

    }
    public function salesstore(Request $request)
    {
        $request->validate([
            'kdsales' => 'required|regex:/^\S*$/u|unique:sales,kdsales',
            'namasales' => 'required',
        ]);

        $sales = new MSales;
        $sales->kdsales = $request->kdsales;
        $sales->namasales = $request->namasales;
        $simpan = $sales->save();

        if ($simpan) {
            return '{"status":"1"}';
        } else {
            return '{"status":"0"}';

        }

    }
    public function projectstore(Request $request)
    {
        $request->validate([
            'kdproject' => 'required|regex:/^\S*$/u|unique:project,kdproject',
            'namaproject' => 'required',
        ]);

        $project = new MProject();
        $project->kdproject = $request->kdproject;
        $project->namaproject = $request->namaproject;
        $simpan = $project->save();

        if ($simpan) {
            return '{"status":"1"}';
        } else {
            return '{"status":"0"}';

        }

    }
    public function docquotation($id)
    {
        $quotation = MQuotation::with(['get_detailrate' => function($query) {
            $query->join('rate','detailratequotation.rateid','=','rate.rateid')->orderBy('detailratequotation.rateid', 'asc')
            ->where('rate.rateid', '10011');
        }])
        ->with('getcustomer', 'getsales', 'getkategori')
        ->where('id',$id)
        ->get();
        return view('quotation.docquotation', compact('quotation'));
    }
    //ujo menu
    public function ujo()
    {
        $quotation = MQuotation::orderby('id', 'desc')->get();
        return view('quotation.ujo', compact('quotation'));
    }
    public function inujo($id)
    {

        $cekujo = MDetailratequotation::join('rate', 'detailratequotation.rateid', '=', 'rate.rateid')->
        where('quotationid', $id)->
        where('rate.kdakun', '5002')
        ->count();
        if ($cekujo > 0) {
            $detailrate = MDetailratequotation::join('rate', 'detailratequotation.rateid', '=', 'rate.rateid')->
            where('quotationid', $id)->
            where('rate.kdakun', '5002')->get();
            $jmlitem =$cekujo;
            $rate = MRate::where('f_default', "1")->get();

        } else {
            $detailrate = MDetailratequotation::where('quotationid', '0')->get();
            $rate = MRate::where('f_default', "1")->get();
            $jmlitem = MRate::where('f_default', "1")->count();
        }

        $quotation = MQuotation::with('getcustomer')->where('id', $id)->first();
        if (Auth::user()->roles_id == 3) {
            if ($quotation->f_accquotation == 0) {
                return view('quotation.inujo', compact('quotation', 'rate', 'detailrate', 'jmlitem'));
            }
            else {
                Alert::error('Gagal', 'Route sudah di acc');
                return redirect()->back();
            }

        }
        else  if (Auth::user()->roles_id == 1 || Auth::user()->roles_id == 2) {
            return view('quotation.inujo', compact('quotation', 'rate', 'detailrate', 'jmlitem'));
        }
        else {
            Alert::error('Gagal', 'Route sudah di acc');
            return redirect()->back();
        }


    }
    public function storeujo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'jumlah' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // DB::beginTransaction();

            $quotation = MQuotation::find($request->id);
            $quotation->ujo = $request->totalujo;
            $quotation->f_accquotation = "0";
            $quotation->save();
            $jml = count($request->nominal);
            $jumlah = 0;
            $pajak = 0;

            for ($i = 0; $i < $jml; $i++) {
                $nominal = $request->nominal[$i];
                if ($nominal == null) {
                    $nominal = 0;
                    $jumlah = 0;
                } else {
                    $nominal = $request->nominal[$i];
                    $jumlah = $request->jumlah[$i];
                }
                if ($request->idratequotation[$i] != null) {
                    $save = MDetailratequotation::where('id',$request->idratequotation[$i])->update([
                        'quotationid' => $request->id,
                        'rateid' => $request->rateid[$i],
                        'nominal' => $nominal,
                        'qty' => $request->qty[$i],
                        'jumlah' => $jumlah,
                        'pph' => $request->pph[$i],
                        'pajak' => $request->pajak[$i],
                    ]);
                }
                else {
                $save = MDetailratequotation::create([
                    'quotationid' => $request->id,
                    'rateid' => $request->rateid[$i],
                    'nominal' => $nominal,
                    'qty' => $request->qty[$i],
                    'jumlah' => $jumlah,
                    'pph' => $request->pph[$i],
                    'pajak' => $request->pajak[$i],
                ]);
            }
                if ($request->pph[$i] > 0) {
                    $pajak = $pajak + $request->pajak[$i];
                }

            }

             DB::select('call  updfeequotation(?,?,?)',array($quotation->id,'50031',$pajak));

            // DB::commit();

            return redirect()->route('groupquotation.tabelrute', ['id' => Session::get('groupquotationid')]);

        }

    }
    public function accqts(Request $request)
    {

        $quotation = MQuotation::find($request->id);
        $quotation->f_accquotation = '1';
        $quotation->save();
        return redirect()->back();
    }
    public function accso(Request $request)
    {
        $quotation = MQuotation::find($request->id);
        $quotation->f_accso = '1';
        $quotation->save();
        return redirect()->back();

    }
    public function requestujo(Request $request)
    {
        $quotation = MQuotation::find($request->id);
        $quotation->f_request = '1';
        $quotation->save();
        return redirect()->back();

    }
    public function accrequest(Request $request)
    {
        $quotation = MQuotation::find($request->id);
        $quotation->f_request = '0';
        $quotation->f_accquotation = '0';
        $quotation->save();
        return redirect()->back();

    }
    public function getquotation(Request $request)
    {
        // $quotation = MQuotation::where('f_accso',1)
        // ->where('origin', 'LIKE', '%' . $request->search . '%')
        // ->orWhere('destination', 'LIKE', '%' . $request->search . '%')
        // ->orWhere('id', 'LIKE', '%' . $request->search . '%')
      //  $quotation =MQuotation::accso()->get();
        $quotation =MQuotation::accso()->where('id', 'LIKE', '%' . $request->search . '%')->get();
        $response = array();
        foreach ($quotation as $value) {
            $response[] = array(
                "id" => $value->id,
                "text" => $value->id . ' - ' . $value->origin . ' - ' . $value->destination,
            );
        }

        return response()->json($response);
    }
    public function pilihquotation(Request $request)
    {
        $order = MQuotation::with('getcustomer','getsales','getkategori')->where('id', $request->id)->first();
        return response()->json($order);
    }


}
