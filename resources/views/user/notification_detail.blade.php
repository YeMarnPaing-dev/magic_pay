@extends('user.layouts.app_plain')
@section('title', 'Notifications_Detail')

@section('content')

    <div >
        <div class="card">
            <div class="card-body text-center">
                <div class="text-center">
                    <img style="width: 220px" src="{{asset('frontend/image/notification.png')}}" alt="">
                </div>
                <h6>{{$notification->data['title']}}</h6>
                <p class="text-muted mb-1">{{$notification->data['message']}}</p>
                <p class="mb-1">{{Carbon\Carbon::parse($notification->created_at->format('Y-m-d H:i:s' ))}}</p>
                <a style="background: #5842E3" href="{{$notification->data['web_link']}}" class="btn btn-sm text-white">Continue</a>
            </div>
        </div>


    </div>




@endsection


