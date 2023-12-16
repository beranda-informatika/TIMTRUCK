<?php

namespace App\Http\Controllers;

use App\Models\MDetailbill;
use App\Models\MDetailshipment;
use App\Models\MKategori;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MShipment;
use App\Models\MBill;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BillController extends Controller
{
    public function genkode() {
        $kode =DB::table('bill')->max('nobill');
                if(empty($kode)) {
                $noUrut = 1;
        }
        else {
            $noUrut = substr($kode, 3);
            $noUrut++;
        }
        $char = "BIL";
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
        $shipment = MShipment::Where('f_status','Payout')->
        orWhere('f_status','Shiping')->
        orWhere('f_status','Arrival')->
        orWhere('f_status','Bill')->
        get();
        return view('bill.index', compact('shipment'));
    }
    public function search(){
        return view('bill.search');
    }
    public function searchshipment(Request $request){
        $kriteria=$request->kriteria;
        switch($kriteria) {
            case 'shipmentid':

                $shipment = MShipment::status('Arrival')->where('shipmentid', 'LIKE', '%' . $request->keyword . '%')->orderBy('routeid', 'ASC')->get();
                break;
            case 'rute':
                $shipment = MShipment::status('Arrival')->join('rute','shipment.routeid','=','rute.routeid')->where('rute.route', 'LIKE', '%' . $request->keyword . '%')->orderBy('shipment.routeid', 'ASC')->get();
                break;
            case 'customer':
                $shipment = MShipment::status('Arrival')->join('customer','shipment.kdcustomer','=','customer.kdcustomer')->where('namacustomer', 'LIKE', '%' . $request->keyword . '%')->orderBy('routeid', 'ASC')->get();
                break;

        }

        return view('bill.shipment', compact('shipment'));
    }

    public function formbill($id)
    {
        $shipment = MShipment::with('getdetailshipment')->where('shipmentid',$id)->get();
        $detailshipment = MDetailshipment::join('rate','detailrateshipment.rateid','=','rate.rateid')
        ->join('akun','rate.kdakun','=','akun.kdakun')
        ->where('akun.kelakun','=','1000')
        ->with('getrate')->where('shipmentid',$id)->get();

        return view('bill.formbill', compact('shipment', 'detailshipment'));
    }
    public function detail($id)
    {

        $shipment = MShipment::find($id);
        return view('bill.detail', compact('shipment'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipmentid' => 'required',
            'nominal' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
            try {

                $bill = new MBill();
                $bill->nobill = $this->genkode();
                $bill->shipmentid = $request->shipmentid;
                $bill->tglbill = Carbon::now();
                $bill->keterangan = $request->keterangan;
                $simpan = $bill->save();

                $shipmentid = $bill->shipmentid;
                $jml = count($request->nominal);
                $pajak=0;

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
                    MDetailbill::create([
                        'shipmentid' => $shipmentid,
                        'nobill' => $bill->nobill,
                        'iddetailrateshipment'=>$request->id[$i],
                        'routeid' => $request->routeid,
                        'rateid' => $request->rateid[$i],
                        'nominal' => $nominal,
                        'qty' => $request->qty[$i],
                        'jumlah' => $jumlah,
                    ]);

                }
                MShipment::where('shipmentid', $request->shipmentid)->update([
                    'f_status' => 'Bill',
                ]);
                DB::commit();
                Alert::success('Berhasil');
                return redirect()->route('bill.bill', $bill->nobill)->with('success', 'Data berhasil disimpan');
            } catch (\Exception $e) {
                Alert::error('Error', $e->getMessage());
                DB::rollback();
                return redirect()->back()->withErrors($validator)->withInput();
            }

        }


    }
    public function bill($id)
    {
        $bill = MBill::with('getdetailbill')->where('nobill',$id)->get();
        return view('bill.bill', compact('bill'));
    }
    public function listbill($id)
    {
        $bill = MBill::with('getdetailbill')->where('shipmentid',$id)->get();
        return view('bill.listbill', compact('bill'));
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
            DB::rollback();
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
