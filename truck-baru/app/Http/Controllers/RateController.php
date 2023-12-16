<?php

namespace App\Http\Controllers;

use App\Models\MRate;
use App\Models\MAkun;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class RateController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rate = MRate::get();
        return view('rate.index', compact('rate'));
    }
    public function create()
    {
        $akun=MAkun::get();
        return view('rate.create',compact('akun'));
    }
    public function edit($id)
    {
        $rate = MRate::find($id);
        $akun=MAkun::get();
        return view('rate.edit', compact('rate','akun'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'rateid' => 'required|regex:/^\S*$/u|unique:rate,rateid',
            'namarate' => 'required',
            'kdakun' => 'required',
            'f_pajak' => 'required',
            'persenpajak' => 'required',
            'f_default' => 'required',

        ]);

        $rate = new MRate;
        $rate->rateid = $request->rateid;
        $rate->namarate = $request->namarate;
        $rate->kdakun = $request->kdakun;
        $rate->f_pajak = $request->f_pajak;
        $rate->persenpajak = $request->persenpajak;
        $rate->f_default = $request->f_default;
        $simpan = $rate->save();

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('rate.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rateid' => 'required|regex:/^\S*$/u|unique:rate,rateid,' . $id . ',rateid',
            'namarate' => 'required',
            'kdakun' => 'required',
            'f_pajak' => 'required',
            'persenpajak' => 'required',
            'f_default' => 'required',
        ]);

        $rate = MRate::find($id);
        $rate->rateid = $request->rateid;
        $rate->namarate = $request->namarate;
        $rate->kdakun = $request->kdakun;
        $rate->f_pajak = $request->f_pajak;
        $rate->persenpajak = $request->persenpajak;
        $rate->f_default = $request->f_default;
        $simpan = $rate->save();
        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('rate.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }
    }
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            MRate::where('rateid', '=', $id)->delete();
            Alert::success('sukses dihapus');
            DB::commit();
            return redirect()->route('rate.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            DB::rollback();
            return redirect()->route('rate.index');
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
    public function getrate(Request $request)
    {
        $rate = MRate::where('namarate', 'LIKE', '%' . $request->search . '%')->orderBy('rateid', 'ASC')->get();

        $response = array();
        foreach ($rate as $value) {
            $response[] = array(
                "id" => $value->rateid,
                "text" => $value->namarate,
            );
        }

        return response()->json($response);
    }
}
