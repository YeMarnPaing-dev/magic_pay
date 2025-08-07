<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
     public function admin(){
        return view('admin.admin');
    }

    public function index(){

        return view('admin.admin_user.index');
    }

    public function ssd(){
      $data = User::all();

      return DataTables::of($data)->make(true);
    }

    public function create(){
       return view('admin.admin_user.create');
    }

    public function store(StoreAdminUser $request){

        $admin_user = new User();
        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->phone = $request->phone;
        $admin_user->password = Hash::make($request->password);
        $admin_user->save();
        return redirect()->route('admin-user.index')->with('create','Successfully Created');
    }
}
