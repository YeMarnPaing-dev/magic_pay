<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\TransactionResource;

class PageController extends Controller
{

    public function profile(){
     $user = auth()->user();
     $data = new ProfileResource($user);
     return success('success',$data);
    }

    public function transaction(){
    $authUser = auth()->guard('api')->user();

    $transactions = Transaction::with('user','source')
    ->where('user_id', $authUser->id)
    ->orderBy('created_at','desc')
    ->get();

    $data = TransactionResource::collection($transactions);
    return $data;
    }
}
