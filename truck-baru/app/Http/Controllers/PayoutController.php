<?php

namespace App\Http\Controllers;

use App\Models\MDetailinvoice;
use App\Models\MDetailshipment;
use App\Models\MKategori;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MShipment;
use App\Models\MInvoice;
use App\Models\MUjo;
use App\Models\MDetailujoongoing;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class PayoutController extends Controller
{
    public function genkode() {
        $kode =DB::table('invoice')->max('noinvoice');
                if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "RPY";
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
        $shipment = MShipment::where('f_status','Approve')->
        orWhere('f_status','Payout')->
        orWhere('f_status','Shiping')->
        orWhere('f_status','Arrival')->
        get();
        return view('payout.index', compact('shipment'));
    }


    public function forminvoice($id)
    {
        $ujo = MUjo::with('getshipment')->where('noujo',$id)->get();
        $detailujo = MDetailujoongoing::join('rate','detailujoongoing.rateid','=','rate.rateid')->where('rate.kdakun','=','5002')
        ->with('getrate')->where('noujo',$id)->get();
        return view('finance.payout.forminvoice', compact('ujo', 'detailujo'));
    }
    public function detail($id)
    {

        $shipment = MShipment::find($id);
        return view('payout.detail', compact('shipment'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'noujo' => 'required',
            'bayar'=>'required'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
            try {

                $noinvoice=$this->genkode();
                $invoice = new MInvoice();
                $invoice->noinvoice = $noinvoice;
                $invoice->noujo = $request->noujo;
                $invoice->tglinvoice = Carbon::now();
                $invoice->keterangan = $request->description;
                $invoice->total = $request->bayar;
                $invoice->save();
                DB::commit();
                Alert::success('Berhasil', 'Data Berhasil Disimpan');

                return redirect()->route('payout.invoice', $invoice->noinvoice)->with('success', 'Data berhasil disimpan');
            } catch (\Exception $e) {
                Alert::error('Gagal', $e->getMessage());
                DB::rollback();

                 return redirect()->back()->withErrors($validator)->withInput();
            }

        }


    }
    public function invoice($id)
    {
        $invoice = MInvoice::where('noinvoice',$id)->get();
        return view('finance.payout.invoice', compact('invoice'));
    }
    public function listinvoice($id)
    {
        $shipmentid=$id;
        $invoice = MInvoice::where('noujo',$id)->get();
        return view('finance.payout.listinvoice', compact('invoice','shipmentid'));
    }


    public function destroy(Request $request, $id)
    {
        try {
            Mdetailshipment::where('shipmentid', '=', $id)->delete();
            MShipment::where('shipmentid', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('shipment.index');
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



}
