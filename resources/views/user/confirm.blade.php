@extends('user.layouts.app_plain')
@section('title', 'Transfer Confirm')

@section('content')

<div class="transfer Confirmation">

     <div class="card" style="">
        <div class="card-body" >
            <form action="" method="POST">
                @csrf
            <div class="form-group">
                <label for=""><strong>From</strong></label>
                <p class="mb-1">{{$user->name}}</p>
                <p class="mb-1">{{$user->phone}}</p>
            </div>
             <div class="form-group">
                <label for=""><strong>Phone</strong></label>
            <p class="text-muted mb-1">{{$to_phone}}</p>
            </div>
            <div class="form-group">
                <label for=""><strong>Amount</strong></label>
               <p class="text-muted mb-1">{{number_format($amount)}} mmk</p>
            </div>
            <div class="form-group">
                <label for=""><strong>Description</strong></label>
               <p class="text-muted mb-1">{{$description}}</p>
            </div>

            <button type="submit" style="background: #5842E3; color:#fff;" class="btn btn-block mt-3">Confirm</button>
            </form>
    </div>
</div>

@endsection
