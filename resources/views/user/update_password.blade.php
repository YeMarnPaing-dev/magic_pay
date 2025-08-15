@extends('user.layouts.app_plain')
@section('title', 'Update Password')

@section('content')


    <div class="update-password">
        <div class="card mb-3">
            <div class="card-body ">

                <form action="{{ route('password#store') }}" method="POST">
                    @csrf
                     @include('user.flash')
                    <div class="text-center">
                        <img style="width:300px" src="{{ asset('frontend/image/undraw_secure-login_m11a (1).png') }}"
                            alt="">
                    </div>

                    <div class="form-group">
                        <label for="">Old Password</label>
                        <input type="password"
                            class="form-control @error('old')
                    is-invalid
                    @enderror"
                            name="old" id="">
                        @error('old')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password"
                            class="form-control @error('new')
                    is-invalid
                    @enderror"
                            name="new" id="">
                        @error('new')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" style="background: #5842E3; color:white;" class="btn  btn-block mt-3">Update
                        Passwords</button>
                </form>

            </div>
        </div>


    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {

        });
    </script>

@endsection
