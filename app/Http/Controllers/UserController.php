<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUser;
use App\Http\Requests\UpdateAdminUser;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    public function index(){
        return view('admin.user.index');
    }

    public function ssd(){
      $data = User::where('role', 'user')->get();

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
          $edit_icon = '<a href="'.route('user.edit', $each->id).'" class="text-warning" ><i class="fa-solid fa-pen-to-square"></i></a>';
          $delete_icon = '<a href="" class="text-danger delete" data-id="'.$each->id.'"><i class="fa-solid fa-trash "></i></a>';

          return $edit_icon . $delete_icon;
      })
      ->rawColumns(['user_agent', 'action'])

      ->make(true);
    }

    public function create(){
       return view('admin.user.create');
    }

    public function store(StoreUser $request){

        DB::beginTransaction();
        try{
        $admin_user = new User();
        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->phone = $request->phone;
        $admin_user->role = 'user';
        $admin_user->password = Hash::make($request->password);
        $admin_user->save();

        Wallet::firstOrCreate(
            ['user_id' => $admin_user->id],
            [
                'account_number' => UUIDGenerate::accountNumber(),
                'amount'=>0, ]
            );

            DB::commit();

            return redirect()->route('user.index')->with('create','Successfully Created');

        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors(['fail', 'Something wrong'])->withInput();
        }

    }

    public function edit($id){
      $admin_user = User::findorFail($id);
      return view('admin.user.edit',compact('admin_user'));
    }

    public function update($id, UpdateUser $request){

        DB::beginTransaction();
         $admin_user = User::findorFail($id);
        $admin_user->name = $request->name;
        $admin_user->email = $request->email;
        $admin_user->phone = $request->phone;
        $admin_user->password = $request->password ? Hash::make($request->password) : $admin_user->password;
        $admin_user->update();

         Wallet::firstOrCreate(
            ['user_id' => $admin_user->id],
            [
                'account_number' => UUIDGenerate::accountNumber(),
                'amount'=>0, ]
            );

            DB::commit();

            return redirect()->route('user.index')->with('update','Successfully Updated');

        try{
        }catch(\Exception $e){
             DB::rollback();
            return back()->withErrors(['fail', 'Something wrong'])->withInput();
        }

    }

    public function destroy($id){
        $admin_user = User::findorFail($id);
        $admin_user->delete();
        return 'success';
    }


}
