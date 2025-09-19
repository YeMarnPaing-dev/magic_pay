<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DetailResource;
use App\Http\Requests\TransferValidate;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\NotiDetailResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\NotificationResource;

class PageController extends Controller
{

    public function profile(){
     $user = auth()->user();
     $data = new ProfileResource($user);
     return success('success',$data);
    }

    public function transaction(Request $request){
    $authUser = auth()->guard('api')->user();

    $transactions = Transaction::with('user','source')
    ->where('user_id', $authUser->id)
    ->orderBy('created_at','desc');

    if($request->date){
        $transactions = $transactions->whereDate('created_at',$request->date);
    }

    if($request->type){
        $transactions = $transactions->where('type' , $request->type);
    }

    $transactions= $transactions->paginate(5);

    $data = TransactionResource::collection($transactions)->additional(['result'=>1,'message'=>'success']);

    return $data;


    }

    public function transaction_detail($trx_id){
        $authUser = auth()->user();
     $transactions = Transaction::with('user', 'source')->where('user_id',$authUser->id)->where('trx_id',$trx_id)->firstorFail();

     $data = new DetailResource($transactions);
     return success('success', $data);
    }

    public function notification(){
            $authUser = auth()->user();
            $notifications = $authUser->notifications()->paginate(5);

            return NotificationResource::collection($notifications)->additional(['result' =>1, 'message'=>'success']);

    }

    public function noti_detail($id){
      $authUser = auth()->guard('api')->user();

    $notifications = $authUser->notifications()->where('id', $id)->firstorFail();
    $notifications->markAsRead();

    $data = new NotiDetailResource($notifications);
    return success('success', $data);
    }


    public function to_account_verify(Request $request){
        if($request->phone){
         $authUser = auth()->user();
         if($authUser->phone != $request->phone){
            $user = User::where('phone', $request->phone)->first();
            if($user){
                return success('success', [
                    'name'=> $user->name,
                    'phone'=> $user->phone
                ]);
            }
         }
        }
        return fail('Invalid data', null);
    }

   public function transferConfirm(TransferValidate $request)
{
    $authUser = Auth::user();

    $to_phone    = $request->to_phone;
    $amount      = $request->amount;
    $description = $request->description ?? '';
    $hash_value  = $request->hash_value;


    $str = $to_phone . $amount . $description;
    $hash_value2 = hash_hmac('sha256', $str,'yemarnpay123#1234');

    if ($hash_value !== $hash_value2) {
        return fail('Hash value mismatch: The given data is invalid', null);
    }

    if ($authUser->phone == $to_phone) {
        return fail('You cannot transfer to your own account', null);
    }


    $to_account = User::with('wallet')->where('phone', $to_phone)->first();
    if (!$to_account) {
        return fail('Recipient account not found', null);
    }


    if (!$authUser->wallet) {
        return fail('Your wallet is not set up', null);
    }


    if (!$to_account->wallet) {
        return fail('Recipient wallet is not set up', null);
    }

    if ($authUser->wallet->amount < $amount) {
        return fail('Insufficient balance', null);
    }

    // Success response
    return success('success', [
        'from_account_name'  => $authUser->name,
        'from_account_phone' => $authUser->phone,

        'to_account_name'    => $to_account->name,
        'to_account_phone'   => $to_account->phone,

        'amount'             => $amount,
        'description'        => $description,
        'hash_value'         => $hash_value,
    ]);
}

}
