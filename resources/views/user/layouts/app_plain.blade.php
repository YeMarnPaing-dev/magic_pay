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
</head>
<body>
    <div class="header-menu">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
            <div class="col-4 text-center "></div>
           <div class="col-4 text-center "><a href=""><h3> @yield('title')</h3></div>
              <div class="col-4 text-center "><a href=""><i class="fa-solid fa-bell"></i></a></div>
            </div>
        </div>
    </div>
</div>

@yield('content')


<div class="bottom-menu">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
            <div class="col-4 text-center "><a href="" ><i class="fa-solid fa-house" ></i> <p>Home</p></a></div>
           <div class="col-4 text-center "><a href=""><i class="fa-solid fa-qrcode" ></i><p>Scan</p></a></div>
              <div class="col-4 text-center "><a href=""><i class="fa-solid fa-user"></i><p>Account</p></a></div>
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
