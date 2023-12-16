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

class ArrivalController extends Controller
{

    public function index()
    {
        $shipment = MShipment::where('f_status','Shiping')->orWhere('f_status','Payout')->get();
        return view('arrival.index', compact('shipment'));
    }
    public function search(){
        return view('arrival.search');
    }
    public function searchshipment(Request $request){
        $kriteria=$request->kriteria;
        switch($kriteria) {
            case 'shipmentid':

                $shipment = MShipment::status('Shiping')->where('shipmentid', 'LIKE', '%' . $request->keyword . '%')->orderBy('routeid', 'ASC')->get();
                break;
            case 'rute':
                $shipment = MShipment::status('Shiping')->join('rute','shipment.routeid','=','rute.routeid')->where('rute.route', 'LIKE', '%' . $request->keyword . '%')->orderBy('shipment.routeid', 'ASC')->get();
                break;
            case 'customer':
                $shipment = MShipment::status('Shiping')->join('customer','shipment.kdcustomer','=','customer.kdcustomer')->where('namacustomer', 'LIKE', '%' . $request->keyword . '%')->orderBy('routeid', 'ASC')->get();
                break;

        }

        return view('arrival.shipment', compact('shipment'));
    }

    public function formapprove($id)
    {
        $shipment = MShipment::with('getdetailshipment')->where('shipmentid',$id)->get();

        $kategori = MKategori::get();
        return view('arrival.formapprove', compact('shipment', 'kategori'));
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
            'keterangan' => 'required',
            'tglarrival' => 'required|date|date_format:Y-m-d|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
            try {
                $shipment = MShipment::find($id);
                $shipment->tglarrival = $request->tglarrival;
                $shipment->f_status = 'Arrival';
                $simpan = $shipment->save();

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


}
