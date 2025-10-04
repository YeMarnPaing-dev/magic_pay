<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DetailResource;
use App\Http\Requests\TransferValidate;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\NotiDetailResource;
use App\Notifications\GeneralNotification;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\NotificationResource;
use Illuminate\Support\Facades\Notification;

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
        'from_name'  => $authUser->name,
        'from_phone' => $authUser->phone,

        'to_name'    => $to_account->name,
        'to_phone'   => $to_account->phone,

        'amount'             => $amount,
        'description'        => $description,
        'hash_value'         => $hash_value,
    ]);
}

public function transferComplete(TransferValidate $request){

      if(!$request->password){
        return fail('Please fill your password', null);
    }
      $authUser = auth()->user();
     if(!Hash::check($request->password, $authUser->password)){
     return fail('The password is incorrect.', null);
     }


        $from_account = $authUser;
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $user = Auth::user();
        $hash_value = $request->hash_value;


            $str = $to_phone.$amount.$description;
            $hash_value2 = hash_hmac('sha256',$str,'yemarnpay123#1234');

            // if($hash_value !== $hash_value2){
            // return fail('Your hash value is invalid', null);
            // }



         if($authUser->phone == $request->to_phone){
             return fail('Invalid Phone', null);
         }

        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account){
           return fail('phoneis not set up', null);
        }


        if(!$from_account->wallet || !$to_account->wallet){
            return fail('Your wallet is incomlpete', null);
        }

        if($from_account->wallet->amount < $amount){
              return fail('Your wallet is not enough', null);
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

        // from
        $title = "E-money Transfered!";
        $message='Your e-money transfered ' . $amount . 'MMK to ' . $to_account->name ;
        $sourceable_id= $from_account_transaction->id;
        $sourceable_type=Transaction::class;
        $web_link=url('user/transactionDetail/');
           $deep_link = [
         'target'=>'transactionDetail',
         'parameter'=>[
            'trx_id'=> $from_account_transaction->trx_id
         ]
        ];

        Notification::send([$from_account], new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));

        // to
        $title = "E-money Received!";
        $message='Your wallet received ' . $amount . 'MMK From' . $from_account->name ;
        $sourceable_id=$to_account_transaction->id;
        $sourceable_type=Transaction::class;
        $web_link=url('user/transactionDetail/');
           $deep_link = [
         'target'=>'transactionDetail',
         'parameter'=>[
            'trx_id'=> $to_account_transaction->trx_id
         ]
        ];

        Notification::send([$to_account], new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));



        DB::commit();

        return success('Successfully Transfer', [
            'trx_id'=> $from_account_transaction->trx_id
        ]);

        }catch(\Exception $error){
            DB::rollback();
            return fail('Someting Went Wrong' . $error->getMessage(), null);
        }

}

public function scan_pay(Request $request)
{
    $from_account = auth()->user();
    $to_account = User::where('phone', $request->to_phone)->first();

    if (!$to_account) {
        return fail('QR code invalid', null);
    }

    return success('success', [
        'from_name'  => $from_account->name,
        'from_phone' => $from_account->phone,
        'to_phone'   => $to_account->phone,
        'to_name'    => $to_account->name,
    ]);
}

public function scan_confirm(TransferValidate $request){
   $authUser = auth()->user();
        $from_account = $authUser;
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $user = Auth::user();
        $hash_value = $request->hash_value;


            $str = $to_phone.$amount.$description;
            $hash_value2 = hash_hmac('sha256',$str,'yemarnpay123#1234');

            if($hash_value !== $hash_value2){
                return fail('Fail amount', null);

            }



         if($authUser->phone == $request->to_phone){
            return fail('Fail phone', null);
         }

        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account){
            return fail('Fail to Phone', null);

        }


        if(!$from_account->wallet || !$to_account->wallet){
            return fail('Fail Data', null);

        }

        if($from_account->wallet->amount < $amount){
            return fail('Fail  lower amount', null);

        }

         return success('success', [
        'from_name'  => $from_account->name,
        'from_phone' => $from_account->phone,
        'to_phone'   => $to_account->phone,
        'to_name'    => $to_account->name,
    ]);


}

public function ScanComplete(TransferValidate $request){

      if(!$request->password){
        return fail('Please fill your password', null);
    }
      $authUser = auth()->user();
     if(!Hash::check($request->password, $authUser->password)){
     return fail('The password is incorrect.', null);
     }


        $from_account = $authUser;
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $user = Auth::user();
        $hash_value = $request->hash_value;


            $str = $to_phone.$amount.$description;
            $hash_value2 = hash_hmac('sha256',$str,'yemarnpay123#1234');

            // if($hash_value !== $hash_value2){
            // return fail('Your hash value is invalid', null);
            // }



         if($authUser->phone == $request->to_phone){
             return fail('Invalid Phone', null);
         }

        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account){
           return fail('phoneis not set up', null);
        }


        if(!$from_account->wallet || !$to_account->wallet){
            return fail('Your wallet is incomlpete', null);
        }

        if($from_account->wallet->amount < $amount){
              return fail('Your wallet is not enough', null);
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

        // from
        $title = "E-money Transfered!";
        $message='Your e-money transfered ' . $amount . 'MMK to ' . $to_account->name ;
        $sourceable_id= $from_account_transaction->id;
        $sourceable_type=Transaction::class;
        $web_link=url('user/transactionDetail/');
           $deep_link = [
         'target'=>'transactionDetail',
         'parameter'=>[
            'trx_id'=> $from_account_transaction->trx_id
         ]
        ];

        Notification::send([$from_account], new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));

        // to
        $title = "E-money Received!";
        $message='Your wallet received ' . $amount . 'MMK From' . $from_account->name ;
        $sourceable_id=$to_account_transaction->id;
        $sourceable_type=Transaction::class;
        $web_link=url('user/transactionDetail/');
           $deep_link = [
         'target'=>'transactionDetail',
         'parameter'=>[
            'trx_id'=> $to_account_transaction->trx_id
         ]
        ];

        Notification::send([$to_account], new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));



        DB::commit();

        return success('Successfully Transfer', [
            'trx_id'=> $from_account_transaction->trx_id
        ]);

        }catch(\Exception $error){
            DB::rollback();
            return fail('Someting Went Wrong' . $error->getMessage(), null);
        }

}

}
