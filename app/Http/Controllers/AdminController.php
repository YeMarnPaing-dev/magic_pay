<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
     public function admin(){
    $user = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    ->groupBy('month')
    ->pluck('count', 'month')
    ->toArray();

$userlabels = [];
$userdata = [];
for ($m = 1; $m <= 12; $m++) {
    $userlabels[] = date("F", mktime(0, 0, 0, $m, 1));
    $userdata[] = $user[$m] ?? 0;
}

 $wallet = Wallet::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    ->groupBy('month')
    ->pluck('count', 'month')
    ->toArray();

$walletlabels = [];
$walletdata = [];
for ($m = 1; $m <= 12; $m++) {
    $walletlabels[] = date("F", mktime(0, 0, 0, $m, 1));
    $walletdata[] = $wallet[$m] ?? 0;
}

        return view('admin.admin',compact('userlabels','userdata','walletlabels','walletdata'));
    }

    public function index(){

        return view('admin.admin_user.index');
    }

    public function ssd(){
      $data = User::whereIn('role', ['superadmin', 'admin'])->get();

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
      ->editColumn('created_at',function($each){
        return Carbon::parse($each->created_at)->format('Y-m-d H:i:s');
      })
      ->editColumn('updated_at',function($each){
        return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
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
        $admin_user->role = 'admin';
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
