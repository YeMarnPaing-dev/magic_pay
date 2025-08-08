<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
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

      return DataTables::of($data)
      ->editColumn('user_agent', function($each){
        if($each->user_agent){
        $agent = new Agent();
        $agent->setUserAgent($each->user_agent);
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();

        return "
        <table class='table table-bordered'>

        <tbody>
        <tr><td>Device</td><td>$device </td></tr>
        <tr><td>Platform</td><td>$platform </td></tr>
       <tr> <td>Browser</td><td> $browser </td></tr></tbody>

        </table>
        ";}

        return '-';
      })
      ->addColumn('action',function($each){
          $edit_icon = '<a href="'.route('admin-user.edit', $each->id).'" class="text-warning" ><i class="fa-solid fa-pen-to-square"></i></a>';
          $delete_icon = '<a href="" class="text-danger delete" data-id="'.$each->id.'"><i class="fa-solid fa-trash "></i></a>';

          return $edit_icon . $delete_icon;
      })
      ->rawColumns(['user_agent', 'action'])
      ->make(true);
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

    public function edit($id){
      $admin_user = User::findorFail($id);
      return view('admin.admin_user.edit',compact('admin_user'));
    }

    public function update($id, UpdateAdminUser $request){

         $admin_user = User::findorFail($id);
        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->phone = $request->phone;
        $admin_user->password = $request->password ? Hash::make($request->password) : $admin_user->password;
        $admin_user->update();
        return redirect()->route('admin-user.index')->with('update','Successfully Updated');
    }

    public function destroy($id){
        $admin_user = User::findorFail($id);
        $admin_user->delete();
        return 'success';
    }


}
