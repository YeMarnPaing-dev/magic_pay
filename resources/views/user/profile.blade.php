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
                    <span class="mr-3">
                      <a href="{{route('update#password')}}">  <i style="color: #555; text-decoration:none;" class="fa-solid fa-angles-right">
                        </i></a>
                    </span>

                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center ">
                    <span>Logout</span>
                    <button type="submit"
                        style="background:none; border:none; margin-right:5px; cursor:pointer; color:inherit;">
                        <i class="logout fa-solid fa-arrow-right-from-bracket"></i>
                    </button>

                </div>
                <hr>

            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
  $(document).ready(function () {
    $(document).on('click', '.logout', function (e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out of your account.",
            icon: "warning",
            showCancelButton: true,
            reverseButtons:true,
            confirmButtonColor: "#5842E3",
            cancelButtonColor: "#555",
            confirmButtonText: "Yes, Logout!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('logout') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function () {
                        window.location.href = "{{ route('login') }}";
                    },
                    error: function () {
                        Swal.fire("Error", "Logout failed. Please try again.", "error");
                    }
                });
            }
        });
    });
});
    </script>

@endsection
