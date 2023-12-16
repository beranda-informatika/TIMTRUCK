<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use App\Models\MShipment;

class ApiShipment extends Controller
{
    public function listshipment($id)
    {
        $shipment = MShipment::where('kddriver',$id)->
        where('f_status','Shiping')->get();
        return Response::json($shipment);
    }
    public function listhistoryshipment($id)
    {
        $shipment = MShipment::where('kddriver',$id)->
        where('f_status','!=','Shiping')->get();
        return Response::json($shipment);
    }
    public function getshipment($id)
    {
        $shipment = MShipment::where('shipmentid',$id)->get();
        return Response::json($shipment);
    }
}
