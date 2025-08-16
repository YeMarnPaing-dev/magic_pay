@extends('user.layouts.app_plain')
@section('title', 'Transfer')

@section('content')

<div class="transfer">

     <div class="card" style="">
        <div class="card-body" >
            <form action="{{route('confirm#transfer')}}" method="POST">
                @csrf
            <div class="form-group">
                <label for="">From</label>
                <p class="mb-1">{{$user->name}}</p>
                <p class="mb-1">{{$user->phone}}</p>
            </div>
             <div class="form-group">
                <label for="">To</label>
                <input type="text" name="to_phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Amount</label>
                <input type="number" name="amount" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Description</label>
               <textarea name="description" class="form-control" id="" ></textarea>
            </div>

            <button type="submit" style="background: #5842E3; color:#fff;" class="btn btn-block mt-3">Continue</button>
            </form>
    </div>
</div>

@endsection
