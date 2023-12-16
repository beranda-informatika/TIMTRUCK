<?php

namespace App\Http\Controllers;

use App\Models\MDetailrute;
use App\Models\MKategori;
use App\Models\MRate;
use App\Models\MRute;
use App\Models\MQuotation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RuteController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rute = MQuotation::where('f_accquotation','1')->get();
        return view('rute.index', compact('rute'));
    }
    public function create()
    {
        $kategori = MKategori::get();
        $rate = MRate::where('f_default', "1")->get();
        return view('rute.create', compact('kategori', 'rate'));
    }
    public function edit($id)
    {
        $rute = MRute::find($id);
        $kategori = MKategori::get();
        return view('rute.edit', compact('rute', 'kategori'));
    }
    public function detail($id)
    {
        $rute = MRute::find($id);
        $kategori = MKategori::get();
        return view('rute.detail', compact('rute', 'kategori'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'routeid' => 'required|unique:rute,routeid|regex:/^\S*$/u',
            'route' => 'required',
            'kdkategori' => 'required',
            'kdproject' => 'required',
            'typetruckid' => 'required',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
            try {
                $rute = new MRute;
                $rute->routeid = $request->routeid;
                $rute->route = $request->route;
                $rute->kdkategori = $request->kdkategori;
                $rute->kdproject = $request->kdproject;
                $rute->typetruckid = $request->typetruckid;
                $rute->keterangan = $request->keterangan;
                $simpan = $rute->save();
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
                    MDetailrute::create([
                        'routeid' => $request->routeid,
                        'rateid' => $request->rateid[$i],
                        'nominal' => $nominal,
                        'qty' => $request->qty[$i],
                        'jumlah' => $jumlah,
                        'pph' => $request->pph[$i],
                        'pajak' => $request->pajak[$i],
                    ]);
                }

                DB::commit();
                Alert::success('Berhasil');
                return Redirect()->route('rute.index');
            } catch (\Exception $e) {
                Alert::error('Error', $e->getMessage());
                DB::rollback();
                return redirect()->back()->withErrors($validator)->withInput();
            }

        }


    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'routeid' => 'required|unique:rute,routeid,'.$id.',routeid|regex:/^\S*$/u',
            'route' => 'required',
            'kdkategori' => 'required',
            'kdproject' => 'required',
            'typetruckid' => 'required',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', 'Data Belum Lengkap');
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
            try {
                $rute = MRute::find($id);
                $rute->routeid = $request->routeid;
                $rute->route = $request->route;
                $rute->kdkategori = $request->kdkategori;
                $rute->kdproject = $request->kdproject;
                $rute->typetruckid = $request->typetruckid;
                $rute->keterangan = $request->keterangan;
                $simpan = $rute->save();
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
                    MDetailrute::where(['routeid'=>$request->routeid, 'rateid'=>$request->rateid[$i]])->update([
                        'nominal' => $nominal,
                        'qty' => $request->qty[$i],
                        'jumlah' => $jumlah,
                        'pph' => $request->pph[$i],
                        'pajak' => $request->pajak[$i],
                    ]);
                }

                DB::commit();
                Alert::success('Berhasil Update data');
                return Redirect()->route('rute.index');
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
            MRute::where('routeid', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('rute.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('rute.index');
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
    public function getrute(Request $request)
    {
        $rute = MRute::
            where('route', 'LIKE', '%' . $request->search . '%')->orderBy('routeid', 'ASC')->get();

        $response = array();
        foreach ($rute as $value) {
            $response[] = array(
                "id" => $value->routeid,
                "text" => $value->route,
            );
        }

        return response()->json($response);
    }
}
