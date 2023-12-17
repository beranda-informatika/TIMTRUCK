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

class ShipingController extends Controller
{
    public function index()
    {
        $shipment = MShipment::where('f_status', 'Shiping')
            ->orWhere('f_status', 'Payout')
            ->get();
        return view('shiping.index', compact('shipment'));
    }
    public function search()
    {
        return view('shiping.search');
    }
    public function searchshipment(Request $request)
    {
        $kriteria = $request->kriteria;
        switch ($kriteria) {
            case 'shipmentid':
                $shipment = MShipment::status('Payout')
                    ->where('shipmentid', 'LIKE', '%' . $request->keyword . '%')
                    ->orderBy('routeid', 'ASC')
                    ->get();
                break;
            case 'rute':
                $shipment = MShipment::status('Payout')
                    ->join('rute', 'shipment.routeid', '=', 'rute.routeid')
                    ->where('rute.route', 'LIKE', '%' . $request->keyword . '%')
                    ->orderBy('shipment.routeid', 'ASC')
                    ->get();
                break;
            case 'customer':
                $shipment = MShipment::status('Payout')
                    ->join('customer', 'shipment.kdcustomer', '=', 'customer.kdcustomer')
                    ->where('namacustomer', 'LIKE', '%' . $request->keyword . '%')
                    ->orderBy('routeid', 'ASC')
                    ->get();
                break;
        }

        return view('shiping.shipment', compact('shipment'));
    }
    public function formloading($id)
    {
        $shipment = MShipment::where('shipmentid', $id)
            ->get();

        $kategori = MKategori::get();
        return view('shiping.formloading', compact('shipment', 'kategori'));
    }
    public function formapprove($id)
    {
        $shipment = MShipment::where('shipmentid', $id)
            ->get();

        $kategori = MKategori::get();
        return view('shiping.formapprove', compact('shipment', 'kategori'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'shipmentid' => 'required',
            'tglapprove' => 'required|date|date_format:Y-m-d|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            DB::beginTransaction();
            try {

                $shipment = MShipment::find($id);
                if ($request->statustrans == 'Loading') {

                    $shipment->tglloading = $request->tglapprove;
                    $shipment->f_status = 'Loading';


                }
                else if ($request->statustrans == 'Shiping') {

                    $shipment->tglshipment = $request->tglapprove;
                    $shipment->f_status = 'Shiping';
                }

                $simpan = $shipment->save();
                DB::commit();
                Alert::success('Berhasil Update data');
                return Redirect()->route('shipment.detail', $id);
            } catch (\Exception $e) {
                Alert::error('Error', $e->getMessage());
                DB::rollback();
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
    }
}
