@extends('user.layouts.app_plain')
@section('title', 'QR')

@section('content')

<div class="QR">

     <div class="card">
        <div class="card-body" >
            <div class="visible-print text-center">
                <p class="mt-2">Scan QR to pay me.</p>
    {!! QrCode::size(200)->generate($authUser->phone); !!}
    <p class="mt-3 a">{{$authUser->name}}</p>

</div>
    </div>
</div>

@endsection
