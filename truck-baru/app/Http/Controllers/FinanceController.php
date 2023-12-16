<?php

namespace App\Http\Controllers;

use App\Models\MDetailshipment;
use App\Models\MKategori;
use App\Models\MInvoice;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MShipment;
use App\Models\MProject;
use App\Models\MQuotation;
use App\Models\MDetailratequotation;


use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FinanceController extends Controller
{
    public function genkode() {
        $kode =DB::table('shipment')->max('shipmentid');
                if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "SHP";
        $newID = $char . sprintf("%017s", $noUrut);
        return $newID;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $shipment = MShipment::get();
        return view('finance.index', compact('shipment'));
    }
    public function create()
    {
        $project = MProject::get();
        return view('shipment.create', compact('project'));
    }
    public function edit($id)
    {
        $shipment = MShipment::with(['getdetailshipment' => function($query) {
            $query->orderBy('rateid', 'asc');
        }])->
        where('shipmentid',$id)->get();

        $kategori = MKategori::get();
        $project = MProject::get();
        return view('shipment.edit', compact('shipment', 'kategori', 'project'));
    }
    public function detail($id)
    {

        $shipment = MShipment::find($id);
        return view('shipment.detail', compact('shipment'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quotationid' => 'required',
            'origin' => 'required',
            'destination' => 'required',
            'kdkategori' => 'required',
            'kdcustomer' => 'required',
            'kdproject' => 'required',
            'kdsales' => 'required',
            'kdunit' => 'required',
            'kddriver' => 'required',
            'typetruckid' => 'required',
            'description' => 'required',
            'mrc' => 'required',
            'ujo' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {


                $shipment = new MShipment;
                $shipment->shipmentid = $this->genkode();
                $shipment->quotationid = $request->quotationid;
                $shipment->origin = $request->origin;
                $shipment->destination = $request->destination;
                $shipment->kdkategori = $request->kdkategori;
                $shipment->kdproject = $request->kdproject;
                $shipment->kdcustomer = $request->kdcustomer;
                $shipment->kdsales = $request->kdsales;
                $shipment->kddriver = $request->kddriver;
                $shipment->kdunit = $request->kdunit;
                $shipment->typetruckid = $request->typetruckid;
                $shipment->tglorder= Carbon::now();
                $shipment->description = $request->description;
                $shipment->mrc = $request->mrc;
                $shipment->ujo = $request->ujo;
                $simpan = $shipment->save();
                $shipmentid = $shipment->shipmentid;

                $dataratequotation=MDetailratequotation::where('quotationid', '=', $request->quotationid)->get();
                $jml = count($dataratequotation);

                foreach($dataratequotation as $itemrate){
                    MDetailshipment::create([
                        'shipmentid' => $shipmentid,
                        'rateid' => $itemrate->rateid,
                        'descript' => $itemrate->descript,
                        'nominal' => $itemrate->nominal,
                        'qty' => $itemrate->qty,
                        'jumlah' => $itemrate->jumlah,
                        'pph' => $itemrate->pph,
                        'pajak' => $itemrate->pajak,
                    ]);

                }

                return Redirect()->route('shipment.index')->with('success', 'Data Berhasil Disimpan');

        }

    }




    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'kdunit' => 'required',
            'kdproject' => 'required',
            'typetruckid' => 'required',
            'kddriver' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // DB::beginTransaction();
            try {
                $shipment = MShipment::find($id);
                $shipment->kdunit = $request->kdunit;
                $shipment->kdproject = $request->kdproject;
                $shipment->typetruckid = $request->typetruckid;
                $shipment->kddriver = $request->kddriver;
                $shipment->description = $request->description;
                $shipment->save();



                return Redirect()->route('shipment.index')->with('success', 'Data Berhasil Disimpan');
            } catch (\Exception $e) {

                DB::rollback();
                return redirect()->back()->withErrors($validator)->withInput();
            }

        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $cek=MInvoice::where('shipmentid', '=', $id)->count();
            if ($cek>0) {
                Alert::error('Gagal hapus, ada  relasi data dengan yang lain (invoice)');
                return redirect()->route('shipment.index');
            }
            else {
                Mdetailshipment::where('shipmentid', '=', $id)->delete();
                MShipment::where('shipmentid', '=', $id)->delete();
                DB::commit();
                Alert::success('sukses dihapus');
                return redirect()->route('shipment.index');
            }
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('shipment.index');
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
    public function getshipment(Request $request)
    {
        $shipment = MShipment::
            where('route', 'LIKE', '%' . $request->search . '%')->orderBy('routeid', 'ASC')->get();

        $response = array();
        foreach ($shipment as $value) {
            $response[] = array(
                "id" => $value->routeid,
                "text" => $value->route,
            );
        }

        return response()->json($response);
    }
    public function getrute(Request $request)
    {
        $shipment = MRute::
            where('kdkategori', '=', $request->kdkategori)->
            where('kdproject', '=', $request->kdproject)->
            where('route', 'LIKE', '%' . $request->search . '%')->orderBy('routeid', 'ASC')->get();

        $response = array();
        foreach ($shipment as $value) {
            $response[] = array(
                "id" => $value->routeid,
                "text" => $value->route,
            );
        }

        return response()->json($response);
    }
    public function pilihrute(Request $request){
        $rute = MRute::with('getdetailrute')->where('routeid', '=', $request->routeid)->get();
        //dd($rute);
        return view('shipment.tabelrate', compact('rute'));
    }
    public function inrate($id)
    {
        $inshipment = MShipment::find($id);
        $rate=MRate::where('kdakun','5002')->get();
        return view('shipment.inrate', compact('inshipment', 'rate', 'id'));
    }
    public function ratestore(Request $request){
        $simpan=MDetailshipment::create([
            'shipmentid' => $request->shipmentid,
            'rateid' => $request->rateid,
            'descript' => $request->descript,
            'nominal' => $request->nominal,
            'qty' => $request->qty,
            'jumlah' => $request->jumlah,
            'pph' => $request->pph,
            'pajak' => $request->pajak,
            'f_edit'=>'1',
           ]);


        return $data = [
            'status' => $simpan,
            'message' => $simpan ? 'Data Berhasil Disimpan' : 'Data Gagal Disimpan',
        ];
    }
    public function pilihquotation(Request $request){
        $quotation = MQuotation::with('getcustomer','getsales','getkategori','get_detailrate')->where('id', $request->id)->get();
        return view('shipment.tabelrate', compact('quotation'));
    }
    public function inujo($id)
    {
        $detailrate = MDetailshipment::join('rate', 'detailrateshipment.rateid', '=', 'rate.rateid')->
        where('shipmentid', $id)->
        where('rate.kdakun', '5002')
        ->get();
        $jmlitem=$detailrate->count();
        $shipment = MShipment::with('getcustomer', 'getsales', 'getkategori')->where('shipmentid', $id)->first();
        return view('shipment.inujo', compact('shipment', 'detailrate', 'jmlitem'));


    }
    public function storeujo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipmentid' => 'required',
            'jumlah' => 'required',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            // DB::beginTransaction();


            $shipment = MShipment::find($request->shipmentid);
            $shipment->description=$request->description;
            $shipment->ujo = $request->totalujo;
            $shipment->save();
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
                    $save = MDetailshipment::where('id',$request->idratequotation[$i])->update([
                        'shipmentid' => $request->shipmentid,
                        'rateid' => $request->rateid[$i],
                        'nominal' => $nominal,
                        'qty' => $request->qty[$i],
                        'jumlah' => $jumlah,
                        'pph' => $request->pph[$i],
                        'pajak' => $request->pajak[$i],
                    ]);
                }
                else {
                $save = MDetailshipmnet::create([
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
             DB::select('call  updfeeshipment(?,?,?)',array($shipment->shipmentid,'50031',$pajak));

            // DB::commit();

            return Redirect()->route('shipment.index');

        }

    }
}
