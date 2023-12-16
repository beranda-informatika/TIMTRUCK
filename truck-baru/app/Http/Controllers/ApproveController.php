<?php

namespace App\Http\Controllers;

use App\Models\MDetailshipment;
use App\Models\MKategori;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MShipment;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ApproveController extends Controller
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
        $shipment = MShipment::where('f_status','Approve')->
        orWhere('f_status','Payout')->
        orWhere('f_status','Shiping')->
        orWhere('f_status','Arrival')->
        get();
        return view('approve.index', compact('shipment'));
    }
    public function search(){
        return view('approve.search');
    }
    public function searchshipment(Request $request){
        $kriteria=$request->kriteria;
        switch($kriteria) {
            case 'shipmentid':

                $shipment = MShipment::status('Quotation')->where('shipmentid', 'LIKE', '%' . $request->keyword . '%')->orderBy('routeid', 'ASC')->get();
                break;
            case 'rute':
                $shipment = MShipment::status('Quotation')->join('rute','shipment.routeid','=','rute.routeid')->where('rute.route', 'LIKE', '%' . $request->keyword . '%')->orderBy('shipment.routeid', 'ASC')->get();
                break;
            case 'customer':
                $shipment = MShipment::status('Quotation')->join('customer','shipment.kdcustomer','=','customer.kdcustomer')->where('namacustomer', 'LIKE', '%' . $request->keyword . '%')->orderBy('routeid', 'ASC')->get();
                break;

        }

        return view('approve.shipment', compact('shipment'));
    }

    public function formapprove($id)
    {
        $shipment = MShipment::with('getdetailshipment')->where('shipmentid',$id)->get();

        $kategori = MKategori::get();
        return view('approve.formapprove', compact('shipment', 'kategori'));
    }
    public function resi($id)
    {
        $shipment = MShipment::with(['getdetailshipment' => function($query) {
            $query->orderBy('rateid', 'asc');
        }])
        ->where('shipmentid',$id)
        ->get();
//        $shipment = MShipment::with('getdetailshipment')->where('shipmentid',$id)->get();

        $kategori = MKategori::get();
        return view('approve.resi', compact('shipment', 'kategori'));
    }
    public function detail($id)
    {

        $shipment = MShipment::find($id);
        return view('shipment.detail', compact('shipment'));
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'routeid' => 'required',
            'orderid' => 'required',
            'kdcustomer' => 'required',
            'kdsales' => 'required',
            'kdunit' => 'required',
            'kddriver' => 'required',
            //'tglquotation' => 'required',
            //'detailroute' => 'required',
            'keterangan' => 'required',
            'nominal' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
            try {
                $shipment = MShipment::find($id);
                $shipment->orderid = $request->orderid;
                $shipment->routeid = $request->routeid;
                $shipment->kdcustomer = $request->kdcustomer;
                $shipment->kdsales = $request->kdsales;
                $shipment->kddriver = $request->kddriver;
                $shipment->kdunit = $request->kdunit;
              //  $shipment->tglquotation = Carbon::now();
                $shipment->tglapprove = Carbon::now();
                $shipment->keterangan = $request->keterangan;
                $shipment->f_status = 'Approve';
                $simpan = $shipment->save();
                $shipmentid = $shipment->shipmentid;
                $jml = count($request->nominal);
                for ($i = 0; $i < $jml; $i++) {
                    $nominal=$request->nominal[$i];
                    if ($nominal==null) {
                        $nominal=0;
                        $jumlah=0;
                    }
                    else {
                        $nominal=$request->nominal[$i];
                        $jumlah=$request->jumlah[$i];
                    }
                    MDetailshipment::where(['shipmentid'=>$request->shipmentid, 'routeid'=>$request->routeid, 'rateid'=>$request->rateid[$i]])->update([
                        'nominal' => $nominal,
                        'qty' => $request->qty[$i],
                        'jumlah' => $jumlah,
                        'pph' => $request->pph[$i],
                        'pajak' => $request->pajak[$i],
                    ]);
                }

                DB::commit();
                Alert::success('Berhasil Update data');
                return Redirect()->route('approve.index');
            } catch (\Exception $e) {
                Alert::error('Error', $e->getMessage());
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
                return redirect()->route('approve.index');
            }
            else {
                Mdetailshipment::where('shipmentid', '=', $id)->delete();
                MShipment::where('shipmentid', '=', $id)->delete();
                DB::commit();
                Alert::success('sukses dihapus');
                return redirect()->route('approve.index');
            }
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('approve.index');
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
