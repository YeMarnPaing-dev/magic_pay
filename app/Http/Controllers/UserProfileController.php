<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePassword;
use App\Http\Requests\TransferValidate;

class UserProfileController extends Controller
{
    public function profile(){
        $user = Auth::user();
        return view('user.profile',compact('user'));
    }

    public function update(){
       return view('user.update_password');
    }

    public function store(UpdatePassword $request){

        $old_password = $request->old;
        $new_password = $request->new;
        $user = Auth::guard('web')->user();

        if (Hash::check( $old_password, $user->password)) {
             $user->password = Hash::make($new_password);
             $user->update();

             return redirect()->route('profile#user')->with('update', 'Successfully Updated Password');
         }

         return back()->withErrors(['fail' => 'The old password is not correct password'])->withInput();
    }

    public function wallet(){
        $authUser = Auth::guard('web')->user();
        return view('user.wallet',compact('authUser'));
    }

    public function transfer(){
        $user = Auth::user();
        return view('user.transfer',compact('user'));
    }

      public function confirm(TransferValidate $request){
         $authUser = Auth::guard('web')->user();

         if($authUser->phone == $request->to_phone){
             return back()->withErrors(['to_phone' => 'This account is invalid'])->withInput();
         }

        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account){
            return back()->withErrors(['to_phone' => 'This phone number does not register'])->withInput();
        }

        $from_account = $authUser;
        $amount = $request->amount;
        $description = $request->description;
        $user = Auth::user();
        return view('user.confirm',compact('from_account','to_account','amount','description'));
    }

  public function verify(Request $request){
    $authUser = Auth::guard('web')->user();

    if($authUser->phone != $request->phone){
    $user = User::where('phone', $request->phone)->first();

    if($user){
        return response()->json([
            'status' => 'success',
            'message'=>'success',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone
            ]
        ]);
    }

    }
    return response()->json([
        'status' => 'fail',
        'message' => 'User not found'
    ]);
}


public function transferComplete(TransferValidate $request){
       $authUser = Auth::guard('web')->user();

         if($authUser->phone == $request->to_phone){
             return back()->withErrors(['to_phone' => 'This account is invalid'])->withInput();
         }

        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account){
            return back()->withErrors(['to_phone' => 'This phone number does not register'])->withInput();
        }

        $from_account = $authUser;
        $amount = $request->amount;
        $description = $request->description;

        if(!$from_account->wallet || !$to_account->wallet){
            return back()->withErrors(['Fail' => 'Something Wrong.The given data is invalid'])->withInput();
        }

        DB::beginTransaction();
        try{
        $from_account_wallet = $from_account->wallet;
        $from_account_wallet->decrement('amount', $amount);
        $from_account_wallet->update();

        $to_account_wallet = $to_account->wallet;
        $to_account_wallet->increment('amount', $amount);
        $to_account_wallet->update();

        $ref_no = UUIDGenerate::refNumber();
        $from_account_transaction = new Transaction();
        $from_account_transaction->ref_no= $ref_no;
        $from_account_transaction->trx_id= UUIDGenerate::trxId();
        $from_account_transaction->user_id= $from_account->id;
        $from_account_transaction->type= 2;
        $from_account_transaction->amount= $amount;
        $from_account_transaction->source_id= $to_account->id;
        $from_account_transaction->description= $description;
        $from_account_transaction->save();

        $to_account_transaction = new Transaction();
        $to_account_transaction->ref_no=  $ref_no;
        $to_account_transaction->trx_id= UUIDGenerate::trxId();
        $to_account_transaction->user_id= $to_account->id;
        $to_account_transaction->type= 1;
        $to_account_transaction->amount= $amount;
        $to_account_transaction->source_id= $from_account->id;
        $to_account_transaction->description= $description;
        $to_account_transaction->save();

        DB::commit();
        return redirect('user/transactionDetail/'.$from_account_transaction->trx_id)->with('transfer_success', 'Successfully transfered.');
        }catch(\Exception $error){
            DB::rollback();
            return back()->withErrors(['Fail' => 'Something Wrong' . $error->getMessage()])->withInput();
        }




}


public function check(Request $request){
    if(!$request->password){
return response()->json([
    'status'=>'fail',
    'message'=>'Please Fill your password'

]);
    }
     $authUser = Auth::guard('web')->user();
     if(Hash::check($request->password, $authUser->password)){
     return response()->json([
        'status'=>'success',
        'message'=>' The password is correct'
     ]);
     }

     return response()->json([
        'status'=>'fail',
        'message'=>' The password is incorrect'
     ]);

}

public function transaction(Request $request){
$authUser = auth()->guard('web')->user();

$transactions = Transaction::with('user','source')
    ->where('user_id', $authUser->id)
    ->orderBy('created_at','desc');

if ($request->type) {
    $transactions = $transactions->where('type', $request->type);
}

$transactions = $transactions->paginate(5)->appends($request->all());

return view('user.transaction', compact('transactions'));


}

public function transactionDetail($trx_id){
    $authUser = auth()->guard('web')->user();
    $transaction = Transaction::with('user','source')->where('user_id', $authUser->id)->where('trx_id', $trx_id)->first();

    return view('user.transaction_detail',compact('transaction'));
}
}
