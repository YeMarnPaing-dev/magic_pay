<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
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

 public function addStore(Request $request)
{
    $request->validate(
        [
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|integer',
        ],
        [
            'user_id.required' => 'User Field is required',
        ]
    );

    if ($request->amount < 1000) {
        return back()
            ->withErrors(['amount' => 'The amount must be at least 1000 MMK'])
            ->withInput();
    }

    DB::beginTransaction();
    try {
        // Find user and wallet
        $to_account = User::with('wallet')->findOrFail($request->user_id);
        $to_account_wallet = $to_account->wallet;

        // Update wallet balance
        $to_account_wallet->increment('amount', $request->amount);

        // Create transaction
        $ref_no = UUIDGenerate::refNumber();
        $trx_id = UUIDGenerate::trxId();

        $to_account_transaction = new Transaction();
        $to_account_transaction->ref_no = $ref_no;
        $to_account_transaction->trx_id = $trx_id;
        $to_account_transaction->user_id = $to_account->id;
        $to_account_transaction->type = 1; // 1 = credit
        $to_account_transaction->amount = $request->amount;
        $to_account_transaction->source_id = 0;
        $to_account_transaction->description = $request->description;
        $to_account_transaction->save();

        DB::commit();

        return redirect()
            ->route('wallet.index')
            ->with('create', 'Successfully added amount');
    } catch (\Exception $error) {
        DB::rollBack();

        return back()
            ->withErrors(['Fail' => 'Something went wrong: ' . $error->getMessage()])
            ->withInput();
    }
}


  public function reduce(){
    $users = User::orderBy('name')->get();
    return view('admin.wallet.reduceAmount',compact('users'));
   }

 public function reduceStore(Request $request)
{
    $request->validate(
        [
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|integer',
        ],
        [
            'user_id.required' => 'User Field is required',
        ]
    );

    if ($request->amount < 1) {
        return back()
            ->withErrors(['amount' => 'The amount must be at least 1 MMK'])
            ->withInput();
    }

    DB::beginTransaction();
    try {
        // Find user and wallet
        $to_account = User::with('wallet')->findOrFail($request->user_id);
        $to_account_wallet = $to_account->wallet;

        // Update wallet balance
        if($to_account_wallet->amount < $request->amount){
            throw new Exception('The Amount is not Greater than Wallet Amount Balance');
        }
        $to_account_wallet->decrement('amount', $request->amount);

        // Create transaction
        $ref_no = UUIDGenerate::refNumber();
        $trx_id = UUIDGenerate::trxId();

        $to_account_transaction = new Transaction();
        $to_account_transaction->ref_no = $ref_no;
        $to_account_transaction->trx_id = $trx_id;
        $to_account_transaction->user_id = $to_account->id;
        $to_account_transaction->type = 2; // 1 = credit
        $to_account_transaction->amount = $request->amount;
        $to_account_transaction->source_id = 0;
        $to_account_transaction->description = $request->description;
        $to_account_transaction->save();

        DB::commit();

        return redirect()
            ->route('wallet.index')
            ->with('create', 'Successfully reduced amount');
    } catch (\Exception $error) {
        DB::rollBack();

        return back()
            ->withErrors(['Fail' => 'Something went wrong: ' . $error->getMessage()])
            ->withInput();
    }
}


}
