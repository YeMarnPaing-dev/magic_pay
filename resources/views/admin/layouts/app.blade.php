<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />

    <meta name="msapplication-tap-highlight" content="no">

    <title>@yield('title')</title>

    @yield('extra_css')


    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap4.css">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
    <link href="{{ asset('admin/css/main.css') }}" rel="stylesheet">
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

        @include('admin.layouts.header')



        <div class="app-main">

            @include('admin.layouts.sidebar')

            <div class="app-main__outer">
                <div class="app-main__inner">
                    @yield('content')
                </div>
                <div class="app-wrapper-footer">
                    <div class="app-footer">
                        <div class="app-footer__inner">
                            <div class="app-footer-left">
                                <span>Copyright {{ date('Y') }} . All right reserve by PayMagic</span>
                            </div>
                            <div class="app-footer-right">
                                <span>Developed by YeMarnPaing</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <script type="text/javascript" src="{{ asset('admin/js/main.js') }}"></script>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap4.js"></script>

{{-- sweet alert  --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Laravel Javascript Validation -->
<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.back-btn').on('click', function() {
            window.history.go(-1);
            return false;
        })

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

        @if(session('create'))
        Toast.fire({
            icon: "success",
            title:" {{session('create')}}"
        });
        @endif
    })
</script>


@yield('script')

</html>
