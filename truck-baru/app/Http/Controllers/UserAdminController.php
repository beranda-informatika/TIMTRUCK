<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where('roles_id', 1)->get();
        return view('admin.index', ['admins' => $admins]);
        //
    }
    public function getadmin(Request $request)
    {
        $worker = User::where('roles_id', 1)->where('name', 'like', '%' . $request->q . '%')->get();
    }

    public function create()
    {
        
        return view('admin.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'name'  => 'required',
            'email'  => 'required|unique:users,email',
        ],
        [
          'name.min'      => 'nama Minimal 5 karakter',
            'email.unique'      => 'email sudah ada',
        ]);

        $admin = new User();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->roles_id = 1;
        $simpan=$admin->save();

        if($simpan){
                return redirect()->route('admin.index')
                    ->with(['success'=>'admin sukses disimpan']);
        } else {
            return redirect()->route('admin.index')
                    ->with(['success', 'ada kesalahan simpan, coba beberapa saat lagi']);
        }
    }


}
