<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MShipment;
use App\Models\MBill;

class ReportController extends Controller
{

    public function rptincome()
    {
        return view('reports.rptincome');
    }
    public function income(Request $request)
    {
        $kdcustomer = $request->kdcustomer;
        if ($kdcustomer){
            $tglmulai = $request->tglmulai;
            $tglakhir = $request->tglakhir;
                $shipment = MShipment::with('getdetailshipment')
                    ->whereBetween('tglorder', [$tglmulai, $tglakhir])
                    ->where('kdcustomer', $kdcustomer)
                    ->get();
        }
        else {
            $tglmulai = $request->tglmulai;
            $tglakhir = $request->tglakhir;
                $shipment = MShipment::with('getdetailshipment')
                    ->whereBetween('tglorder', [$tglmulai, $tglakhir])
                    ->get();
        }


            return view('reports.incomedata')->with(['shipment' => $shipment, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
    public function rptshipment()
    {
        return view('reports.rptshipment');
    }
    public function shipment(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
            $shipment = MShipment::with('getdetailshipment')
                ->whereBetween('tglorder', [$tglmulai, $tglakhir])
                ->get();
            return view('reports.shipment')->with(['shipment' => $shipment, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }
    public function rptbill()
    {
        return view('reports.rptbill');
    }
    public function bill(Request $request)
    {
        $tglmulai = $request->tglmulai;
        $tglakhir = $request->tglakhir;
            $bill = MBill::with('getdetailbill')
                ->whereBetween('tglbill', [$tglmulai, $tglakhir])
                ->get()
                ->sortBy(function ($query) {
                    return $query->getshipment->shipmentid;
                });
            return view('reports.bill')->with(['bill' => $bill, 'tglmulai' => $tglmulai, 'tglakhir' => $tglakhir]);
    }

}
