<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

    <meta name="msapplication-tap-highlight" content="no">





    @yield('extra_css')


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

    {{-- google fonts  --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">

        <link rel="stylesheet" href="{{asset('frontend/css/user.css')}}">
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
        <link rel="stylesheet" href="{{asset('frontend/css/transaction.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body style="background: #ebeaf4;overflow-x: hidden;">


    <!-- Header -->
    <div class="header-menu">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="row align-items-center">
                    <div class="col-2 text-center">
                        @if (!request()->is('user/user'))
                            <a href="javascript:void(0);" class="back-btn">
                                <i class="fa-solid fa-backward"></i>
                            </a>
                        @endif

                    </div>
                    <div class="col-8 text-center">
                        <h3>@yield('title')</h3>
                    </div>
                    <div class="col-2 text-center">
                        <a href="{{route('noti#index')}}"><i class="fa-solid fa-bell"></i>
                            <span style="position: absolute; top: -8px;right: 8px;padding:3px " class="badge badge-pill badge-danger">{{$unread_noti_count}}</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="d-flex justify-content-center">
            <div class="col-md-8 " style="margin: 60px 0px">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bottom Menu -->
    <div class="bottom-menu">
        <a href="{{route('scan#pay')}}" class="scan" style=" width: 60px;
    height: 60px;
    background: #5842E3;
    border-radius:100%;
    position:fixed;
    bottom:40px;
    right:0;
    left:0;
    margin:0 auto;
    display:flex;
    justify-content:center;
    align-items:center;

    ">
            <div class="inside" style="
           width: 52px;
    height: 52px;
    background: #fff;
    border-radius: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
     "


    >
                <i style="margin:0;" class="fa-solid fa-qrcode"></i>
            </div>
        </a>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row text-center">
                    <div class="col-3">
                        <a href="{{ route('user#login') }}">
                            <i class="fa-solid fa-house"></i>
                            <p>Home</p>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="{{route('transaction#list')}}">
                            <i class="fa-solid fa-arrow-right-arrow-left"></i>
                            <p>Transaction</p>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="{{route('user#wallet')}}">
                           <i class="fa-solid fa-wallet"></i>
                            <p>Wallet</p>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('profile#user') }}">
                            <i class="fa-solid fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>



{{-- sweet alert  --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap4.js"></script>

{{-- sweet alert  --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="asset('frontend/js/jquery.jscroll.min.js')"></script> --}}

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<script  src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script  src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


{{-- modal  --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<script>
    $(document).ready(function() {
        let token = document.head.querySelector('meta[name="csrf-token"]');

        if (token) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token.content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
        } else {
            console.error('CSRF token not found in <meta> tag.');
        }

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        @if (session('create'))
            Toast.fire({
                icon: "success",
                title: " {{ session('create') }}"
            });
        @endif

        @if (session('update'))
            Toast.fire({
                icon: "success",
                title: " {{ session('update') }}"
            });
        @endif

        $('.back-btn').on('click', function(e) {
            e.preventDefault();
            window.history.go(-1);
            return false;
        });
    })
</script>

@yield('script')

</html>
