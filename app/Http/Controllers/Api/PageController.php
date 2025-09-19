<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DetailResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\TransactionResource;

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
}
