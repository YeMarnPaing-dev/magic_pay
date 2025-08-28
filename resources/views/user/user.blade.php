@extends('user.layouts.app_plain')
@section('title', 'Magic Pay')

@section('content')

    <div class="home">

        <div class="row ">
            <div class="col-12 ">
                <p class="profile mb-3">
                    <img src="https://ui-avatars.com/api/?background=5842E3&color=fff&name={{ $user->name }}"
                        alt="">
                <h5 class="profile">{{ $user->name }}</h5>
                <p class="text-muted profile">{{ $user->wallet ? number_format($user->wallet->amount) : 0 }} mmk</p>
                </p>
            </div>

            <div class="col-6">
                <div class="card ">
                    <div class="card-body p-2">
                        <img style="width:25px; height:25px; margin-right:10px"
                            src="{{ asset('frontend/image/qr-code-scan.png') }}" alt="">
                        <span>Scan & Pay</span>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card ">
                    <div class="card-body p-2">
                        <img style="width:25px; height:25px; margin-right:10px" src="{{ asset('frontend/image/qr.png') }}"
                            alt="">
                        <span>Receive QR</span>
                    </div>
                </div>

            </div>
            <div class="col-12 mt-3">
                <div class="card mb-3">
                    <div class="card-body pr-0">
                        <div class="d-flex justify-content-between">

                            <span> <img style="width: 25px;height25px;margin-right:8px;" src="{{asset('frontend/image/money-transfer.png')}}" alt=""> Transfer</span>
                            <span class="mr-3">
                                <a href="{{route('transer#user')}}">
                                    <i style="color: #555; text-decoration:none;" class="fa-solid fa-angles-right"></i>
                                </a>
                            </span>

                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center ">
                            <span> <img style="width: 25px;height25px;margin-right:8px;" src="{{asset('frontend/image/wallet.png')}}" alt=""> Wallet</span>
                            <span class="mr-3">
                                <a href="">
                                    <i style="color: #555; text-decoration:none;" class="fa-solid fa-angles-right"></i>
                                </a>
                            </span>

                        </div>
                        <hr>

                        <div class="d-flex justify-content-between align-items-center ">
                            <span>
                                <img style="width: 25px;height25px;margin-right:8px;" src="{{asset('frontend/image/transaction.png')}}" alt="">
                                Transcation</span>
                            <span class="mr-3">
                                <a href="{{route('transaction#list')}}">
                                    <i style="color: #555; text-decoration:none;" class="fa-solid fa-angles-right"></i>
                                </a>
                            </span>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
