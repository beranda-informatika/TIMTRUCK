<?php

namespace App\Http\Controllers;

use App\Models\MProject;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;



class ProjectController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $project = MProject::get();
        return view('project.index', compact('project'));
    }
    public function create()
    {
        return view('project.create');
    }
    public function edit($id)
    {
        $project = MProject::find($id);
        return view('project.edit', compact('project'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kdproject' => 'required|regex:/^\S*$/u|unique:project,kdproject',
            'namaproject' => 'required',
        ]);

        $project = new MProject;
        $project->kdproject = $request->kdproject;
        $project->namaproject = $request->namaproject;
        $simpan = $project->save();

        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('project.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();
            
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kdproject' => 'required|regex:/^\S*$/u|unique:project,kdproject,' . $id . ',kdproject',
            'namaproject' => 'required',
        ]);

        $project = MProject::find($id);
        $project->kdproject = $request->kdproject;
        $project->namaproject = $request->namaproject;
        $simpan = $project->save();
        if ($simpan) {
            Alert::success('Berhasil');
            return redirect()->route('project.index');

        } else {
            Alert::error('Gagal');
            return redirect()->back();
            
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            MProject::where('kdproject', '=', $id)->delete();
            Alert::success('sukses dihapus');
            return redirect()->route('project.index');
        } catch (QueryException $ex) {
            Alert::error('Gagal hapus, ada relasi data dengan yang lain');
            return redirect()->route('project.index');
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
    public function getproject(Request $request)
    {
        $project = MProject::
            where('namaproject', 'LIKE', '%' . $request->search . '%')->orderBy('kdproject', 'ASC')->get();

        $response = array();
        foreach ($project as $value) {
            $response[] = array(
                "id" => $value->kdproject,
                "text" => $value->namaproject,
            );
        }

        return response()->json($response);
    }
}
