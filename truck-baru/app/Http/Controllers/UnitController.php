<?php

namespace App\Http\Controllers;

use App\Models\MCbu;
use App\Models\MUnit;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class UnitController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $unit = MUnit::get();
        return view('unit.index', compact('unit'));
    }
    public function create()
    {
        return view('unit.create');
    }
    public function edit($id)
    {
        $unit = MUnit::find($id);
        return view('unit.edit', compact('unit'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kdunit' => 'required|regex:/^\S*$/u|unique:unit,kdunit',
            'typeunit' => 'required',
            'plat' => 'required',
            'merk' => 'required',
        ]);

        $unit = new MUnit;
        $unit->kdunit = $request->kdunit;
        $unit->plat = $request->plat;
        $unit->merk = $request->merk;
        $unit->typeunit = $request->typeunit;
        $simpan = $unit->save();

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('unit.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kdunit' => 'required|regex:/^\S*$/u|unique:unit,kdunit,' . $id . ',kdunit',
            'plat' => 'required',
            'merk' => 'required',
            'typeunit' => 'required',
        ]);

        $unit = MUnit::find($id);
        $unit->kdunit = $request->kdunit;
        $unit->merk = $request->merk;
        $unit->plat = $request->plat;
        $unit->typeunit = $request->typeunit;
        $simpan = $unit->save();
        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('unit.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();

        }
    }
    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            MUnit::where('kdunit', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('unit.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('unit.index');
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
    public function getunit(Request $request)
    {
        $unit = MUnit::
            where('plat', 'LIKE', '%' . $request->search . '%')->
            orWhere('merk', 'LIKE', '%' . $request->search . '%')->
            orWhere('kdunit', 'LIKE', '%' . $request->search . '%')->
            orderBy('kdunit', 'ASC')->get();

        $response = array();
        foreach ($unit as $value) {
            $response[] = array(
                "id" => $value->kdunit,
                "text" =>$value->kdunit.' - '.  $value->plat . ' - ' . $value->merk.' - '.$value->typeunit,
            );
        }

        return response()->json($response);
    }
}
