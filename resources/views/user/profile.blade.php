@extends('user.layouts.app_plain')
@section('title', 'Profile')

@section('content')


    <div class="account">
        <div class="profile mb-3">
            <img src="https://ui-avatars.com/api/?background=5842E3&color=fff&name=John+Doe" alt="">
        </div>

        <div class="card mb-3">
            <div class="card-body pr-0">
                <div class="d-flex justify-content-between">
                    <span>Username</span>
                    <span class="mr-3">{{ $user->name }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Phone</span>
                    <span class="mr-3">{{ $user->phone }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Email</span>
                    <span class="mr-3">{{ $user->email }}</span>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body pr-0">
                <div class="d-flex justify-content-between">
                    <span>Update Password</span>
                    <span class="mr-3"><i class="fa-solid fa-angles-right"></i></span>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Logout</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                        @csrf
                        <button type="submit"
                         style="background:none; border:none; margin-right:5px; cursor:pointer; color:inherit;" >
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
                <hr>

            </div>
        </div>
    </div>

@endsection
