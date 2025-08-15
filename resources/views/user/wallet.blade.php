@extends('user.layouts.app_plain')
@section('title', 'Wallet')

@section('content')

<div class="wallet">

     <div class="card" style="background: #5842E3; color: #fff;">
        <div class="card-body" >
            <div class="mb-4">
                <span style="text-transform: uppercase; display:inline-block; margin-bottom:5px; color: #EDEDF5;">Balance</span>
                <h4 style="font-size:22px; font-weight:900;">{{number_format($authUser->wallet ? $authUser->wallet()->amount : 0)}} mmk</h4>
            </div>
            <div class="mb-4">
                <span style="text-transform: uppercase; display:inline-block; margin-bottom:5px;r: #EDEDF5;">Account Number</span>
                <h5 style="font-size: 18px; font-weight:900;">{{$authUser->wallet ? $authUser->wallet()->account_number : '-'}}</h5>
            </div>
            <div>
                <p style="font-size: 16px; text-transform:uppercase; font-weight:900; ">{{$authUser->name}}</p>
            </div>
        </div>

    </div>
</div>

@endsection
