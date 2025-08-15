@extends('user.layouts.app_plain')
@section('title', 'Magic Pay')

@section('content')

<div class="home">

<div class="row">
    <div class="col-12">
        <p class="profile mb-3">
            <img  src="https://ui-avatars.com/api/?background=5842E3&color=fff&name={{$user->name}}" alt="">
            <h5 class="profile">{{$user->name}}</h5>
            <p class="text-muted profile">{{$user->wallet ? number_format($user->wallet->amount) : 0}} mmk</p>
        </p>
    </div>

    <div class="col-6">
        <div class="card " >
            <div class="card-body">
                <img style="width:30px; height:30px; margin-right:15px" src="{{asset('frontend/image/qr-code-scan.png')}}" alt="">
                <span>Scan & Pay</span>
            </div>
        </div>
    </div>
     <div class="col-6">
        <div class="card " >
            <div class="card-body">
                <img style="width:30px; height:30px; margin-right:15px" src="{{asset('frontend/image/qr.png')}}" alt="">
                <span>Receive QR</span>
            </div>
        </div>
     </div>
</div>

</div>

@endsection
