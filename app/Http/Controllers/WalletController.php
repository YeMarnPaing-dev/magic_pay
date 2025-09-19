<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class WalletController extends Controller
{
   public function index(){

    return view('admin.wallet.index');
   }

   public function ssd(){
    $wallet = Wallet::with('user');

     return DataTables::of($wallet)
     ->addColumn('account_person', function($each){
       $user= $each->user;
       if($user){
        return ' <p>Name : '. $user->name .' </p>  <p>Email : '. $user->email .' </p>  <p>Phone : '. $user->phone .'</p>';
       }
       return '-';
     })
     ->editColumn('amount', function($each){
        return number_format($each->amount, 2);
     })
     ->editColumn('created_at', function($each){
        return Carbon::parse($each->created_at)->format('Y-m-d H:i:s');
     })
     ->editColumn('updated_at', function($each){
        return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
     })
     ->rawColumns(['account_person'])
    ->make(true);
   }

   public function add(){
    $users = User::orderBy('name')->get();
    return view('admin.wallet.addAmount',compact('users'));
   }
}
