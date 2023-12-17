<?php

namespace App\Http\Controllers;

use App\Models\MDetailratequotation;
use App\Models\MDetailshipment;
use App\Models\MDetailujoongoing;
use App\Models\MInvoice;
use App\Models\MKategori;
use App\Models\MProject;
use App\Models\MQuotation;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MShipment;
use App\Models\MUnit;
use App\Models\MDriver;
use App\Models\MDocpod;
use App\Models\MLocationpoint;
use App\Models\MUjo;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UjoController extends Controller
{
    public function genkode()
    {
        $kode = DB::table('ujo')->max('noujo');
        if (empty($kode)) {
            $noUrut = 1;
        } else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = 'UJO';
        $newID = $char . sprintf('%017s', $noUrut);
        return $newID;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ujo = MUjo::get();
        return view('ujo.index', compact('ujo'));
    }
    public function getsalesorder(Request $request)
    {
        if ($request->kdcustomer == 'all') {
            $shipment = MShipment::with('getujo')->get();
        } else {
            $shipment = MShipment::with('getujo')->where('kdcustomer', $request->kdcustomer)->get();
        }

        return view('ujo.salesorder', compact('shipment'));
    }

    public function create()
    {

        return view('ujo.index');
    }
    public function edit($id)
    {
        $shipment = MShipment::with([
            'getdetailshipment' => function ($query) {
                $query->orderBy('rateid', 'asc');
            },
            'gettypetruck',
        ])
            ->where('shipmentid', $id)
            ->get();

        $kategori = MKategori::get();
        $project = MProject::get();
        return view('shipment.edit', compact('shipment', 'kategori', 'project'));
    }
    public function formujo(Request $request)
    {
        $cekujo=MUjo::where('shipmentid', $request->shipmentid)->count();
        if ($cekujo>0){
            $shipment = MShipment::with(
                'gettypetruck','getujo')
                ->where('shipmentid', $request->shipmentid)
                ->first();
                $detailrate = MDetailujoongoing::join('rate', 'detailujoongoing.rateid', '=', 'rate.rateid')
                ->where('rate.kdakun', '5002')
                ->get();
                $jmlitem=$detailrate->count();
                return view('ujo.formeditujo', compact('shipment','detailrate','jmlitem'));
        }
        else {
            $shipment = MShipment::with(
                'gettypetruck','getujo')
                ->where('shipmentid', $request->shipmentid)
                ->first();
                $quotationid=$shipment->quotationid;
             //   dd($quotationid);
                $detailrate = MDetailratequotation::join('rate', 'detailratequotation.rateid', '=', 'rate.rateid')
                ->where('rate.kdakun', '5002')
                ->where('rate.f_default', '1')

                ->where('quotationid',$quotationid)
                ->get();
                $jmlitem=$detailrate->count();
                return view('ujo.formujo', compact('shipment','detailrate','jmlitem'));
        }


    }
    public function detail($id)
    {
        $shipment = MShipment::find($id);
        return view('shipment.detail', compact('shipment'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipmentid' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $ujo = new MUjo();
            $ujo->noujo = $this->genkode();
            $ujo->shipmentid = $request->shipmentid;
            $ujo->tglujo = Carbon::now();
            $ujo->terbayar= 0;
            $ujo->nominalujo= $request->totalujo;;

            $simpan = $ujo->save();
            $noujo = $ujo->noujo;
            $jmlrate=count($request->rateid);

            for ($i=0; $i<$jmlrate; $i++) {
                MDetailujoongoing::create([
                    'noujo' => $noujo,
                    'rateid' => $request->rateid[$i],
                    'descript' => $request->descript[$i],
                    'nominal' => $request->nominal[$i],
                    'qty' => $request->qty[$i],
                    'jumlah' => $request->jumlah[$i],
                    'pph' => $request->pph[$i],
                    'pajak' => $request->pajak[$i],
                ]);
            }
            Alert::success('sukses');
            return Redirect()
                ->route('ujo.index')
                ->with('success', 'Data Berhasil Disimpan');
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kdunit' => 'required',
            'kddriver' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            // DB::beginTransaction();
            try {
                $shipment = MShipment::find($id);
                $shipment->kdunit = $request->kdunit;
                $shipment->kddriver = $request->kddriver;
                $shipment->f_operational = '1';
                $shipment->save();
                Alert::success('sukses');
                return redirect()->back();

                // return Redirect()
                //     ->route('shipment.index')
                //     ->with('success', 'Data Berhasil Disimpan');
            } catch (\Exception $e) {
                Alert::error('Gagal', $e->getMessage());
                DB::rollback();
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
    }

    public function updateroute(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'origin' => 'required',
            'destination' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            // DB::beginTransaction();
            try {
                $shipment = MShipment::find($id);
                $shipment->origin = $request->origin;
                $shipment->destination = $request->destination;
                $shipment->typeroute = $request->typeroute;
                $shipment->mrc = $request->mrc;
                $shipment->ujo = $request->ujo;

                $shipment->save();
                //hapus rate
                MDetailshipment::where('shipmentid', '=', $id)
                    ->where('rateid', '!=', '50027')
                    ->delete();
                $dataratequotation = MDetailratequotation::where('quotationid', '=', $request->routeid)->get();
                $jml = count($dataratequotation);

                foreach ($dataratequotation as $itemrate) {
                    if ($itemrate->rateid == '10011' && $request->typeroute == 'load') {
                        $f_edit = 1;
                    } elseif ($itemrate->rateid == '50027') {
                        $f_edit = 1;
                    } else {
                        $f_edit = 0;
                    }
                    if ($itemrate->rateid == '50027') {
                        //skip
                    } else {
                        MDetailshipment::create([
                            'shipmentid' => $id,
                            'rateid' => $itemrate->rateid,
                            'descript' => $itemrate->descript,
                            'nominal' => $itemrate->nominal,
                            'qty' => $itemrate->qty,
                            'jumlah' => $itemrate->jumlah,
                            'pph' => $itemrate->pph,
                            'pajak' => $itemrate->pajak,
                            'f_edit' => $f_edit,
                        ]);
                    }
                }
                Alert::success('sukses');

                return Redirect()
                    ->route('shipment.detail', $id)
                    ->with('success', 'Data Berhasil Disimpan');
            } catch (\Exception $e) {
                Alert::error('Gagal', $e->getMessage());
                DB::rollback();
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $cek = MInvoice::where('shipmentid', '=', $id)->count();
            if ($cek > 0) {
                Alert::error('Gagal hapus, ada  relasi data dengan yang lain (UJO), silahkan batalkan UJO terlebih dahulu');
                return redirect()->route('shipment.index');
            } else {
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
            return redirect()
                ->back()
                ->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }
    public function getshipment(Request $request)
    {
        $shipment = MShipment::where('route', 'LIKE', '%' . $request->search . '%')
            ->orderBy('routeid', 'ASC')
            ->get();

        $response = [];
        foreach ($shipment as $value) {
            $response[] = [
                'id' => $value->routeid,
                'text' => $value->route,
            ];
        }

        return response()->json($response);
    }

    public function getrute(Request $request)
    {
        $shipment = MRute::where('kdkategori', '=', $request->kdkategori)
            ->where('kdproject', '=', $request->kdproject)
            ->where('route', 'LIKE', '%' . $request->search . '%')
            ->orderBy('routeid', 'ASC')
            ->get();

        $response = [];
        foreach ($shipment as $value) {
            $response[] = [
                'id' => $value->routeid,
                'text' => $value->route,
            ];
        }

        return response()->json($response);
    }
    public function pilihrute(Request $request)
    {
        $rute = MRute::with('getdetailrute')
            ->where('routeid', '=', $request->routeid)
            ->get();
        //dd($rute);
        return view('shipment.tabelrate', compact('rute'));
    }
    public function inrate($id)
    {
        $inshipment = MShipment::find($id);
        $rate = MRate::where('kdakun', '5002')->get();
        return view('ujo.inrate', compact('inshipment', 'rate', 'id'));
    }
    public function inraterevenue($id)
    {
        $inshipment = MShipment::find($id);
        $rate = MRate::where('kdakun', '1001')->get();
        return view('shipment.inraterevenue', compact('inshipment', 'rate', 'id'));
    }
    public function ratestore(Request $request)
    {
        $simpan = MDetailujoongoing::create([
            'noujo' => $request->noujo,
            'rateid' => $request->rateid,
            'descript' => $request->descript,
            'nominal' => $request->nominal,
            'qty' => $request->qty,
            'jumlah' => $request->jumlah,
            'pph' => $request->pph,
            'pajak' => $request->pajak,
        ]);

        return $data = [
            'status' => $simpan,
            'message' => $simpan ? 'Data Berhasil Disimpan' : 'Data Gagal Disimpan',
        ];
    }

    public function pilihquotation(Request $request)
    {
        $quotation = MQuotation::with('getcustomer', 'getsales', 'getkategori', 'get_detailrate')
            ->where('id', $request->id)
            ->get();
        return view('shipment.tabelrate', compact('quotation'));
    }
    public function inujo($id)
    {
        $detailrate = MDetailshipment::join('rate', 'detailrateshipment.rateid', '=', 'rate.rateid')
            ->where('shipmentid', $id)
            ->where('rate.kdakun', '5002')
            ->get();
        $jmlitem = $detailrate->count();
        $shipment = MShipment::with('getcustomer', 'getsales', 'getkategori')
            ->where('shipmentid', $id)
            ->first();
        return view('shipment.inujo', compact('shipment', 'detailrate', 'jmlitem'));
    }
    public function inrevenue($id)
    {
        $detailrate = MDetailshipment::join('rate', 'detailrateshipment.rateid', '=', 'rate.rateid')
            ->where('shipmentid', $id)
            ->where('rate.kdakun', '1001')
            ->get();
        $jmlitem = $detailrate->count();
        $shipment = MShipment::with('getcustomer', 'getsales', 'getkategori')
            ->where('shipmentid', $id)
            ->first();
        return view('shipment.inrevenue', compact('shipment', 'detailrate', 'jmlitem'));
    }
    public function storeujo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipmentid' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            // DB::beginTransaction();

            $shipment = MShipment::find($request->shipmentid);
            $shipment->description = $request->description;
            if ($request->trshipment == 'revenue') {
                $shipment->mrc = $request->totalujo;
            } else {
                $shipment->ujo = $request->totalujo;
            }

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
                    $save = MDetailshipment::where('id', $request->idratequotation[$i])->update([
                        'shipmentid' => $request->shipmentid,
                        'rateid' => $request->rateid[$i],
                        'nominal' => $nominal,
                        'qty' => $request->qty[$i],
                        'jumlah' => $jumlah,
                        'pph' => $request->pph[$i],
                        'pajak' => $request->pajak[$i],
                    ]);
                } else {
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
            DB::select('call  updfeeshipment(?,?,?)', [$shipment->shipmentid, '50031', $pajak]);

            // DB::commit();

            return Redirect()->route('shipment.detail',$shipment->shipmentid)
                ->with('success', 'Data Berhasil Disimpan');
        }
    }

    public function getrouteall(Request $request)
    {
        $quotation = MQuotation::join('groupquotations', 'quotations.groupquotationid', '=', 'groupquotations.groupquotationid')
            ->where('groupquotations.kdcustomer', $request->id)
            ->where('groupquotations.f_accso', '1')
            ->orderby('destination')
            ->get();
        $kdcustomer = $request->id;
        return view('shipment.getroute', compact('quotation', 'kdcustomer'));
    }

    public function unitactivity(Request $request)
    {
        $shipment = MShipment::where('kdunit', $request->kdunit)
            ->where(function ($query) {
                $query->where('f_status', '=', 'New')->orWhere('f_status', '=', 'Shiping');
            })
            ->get();
        return view('shipment.unitactivity', compact('shipment'));
    }
    public function driveractivity(Request $request)
    {
        $shipment = MShipment::where('kddriver', $request->kddriver)
            ->where(function ($query) {
                $query->where('f_status', '=', 'New')->orWhere('f_status', '=', 'Shiping');
            })
            ->get();
        return view('shipment.driveractivity', compact('shipment'));
    }
    public function listpod($id)
    {
        $shipmentid=    $id;
        $docpod = MDocpod::where('shipmentid', $id)->get();
        return view('shipment.listpod', compact('docpod','shipmentid'));
    }
    public function changeroute($id)
    {
        $shipment = MShipment::find($id);
        return view('shipment.changeroute', compact('shipment'));
    }
}
