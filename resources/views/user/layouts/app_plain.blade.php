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



    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">

    @yield('extra_css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">

    {{-- google fonts  --}}
 <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body style="background: #ebeaf4">


    <!-- Header -->
    <div class="header-menu" >
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row align-items-center">
                    <div class="col-4 text-center"></div>
                    <div class="col-4 text-center">
                        <h3>@yield('title')</h3>
                    </div>
                    <div class="col-4 text-center">
                        <a href=""><i class="fa-solid fa-bell"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-8 " style="margin: 60px 0px">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bottom Menu -->
    <div class="bottom-menu">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row text-center">
                    <div class="col-4">
                        <a href="{{route('user#login')}}">
                            <i class="fa-solid fa-house"></i>
                            <p>Home</p>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="">
                            <i class="fa-solid fa-qrcode"></i>
                            <p>Scan</p>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="{{route('profile#user')}}">
                            <i class="fa-solid fa-user"></i>
                            <p>Account</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap4.js"></script>

{{-- sweet alert  --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
</html>
