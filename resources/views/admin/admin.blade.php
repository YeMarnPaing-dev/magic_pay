@extends('admin.layouts.app')
@section('title','Dashboard')
@section('home-active','mm-active')
@section('content')

  <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-display2 icon-gradient bg-mean-fruit">
                                        </i>
                                    </div>
                                    <div>Dashboard</div>
                                </div>
                                 </div>
                        </div>


                        <div class="container">
                            <div class="row">
                                <div class="col-6"><canvas id="userChart" width="200" height="100"></canvas></div>
                                <div class="col-6"></div>
                            </div>
                        </div>



@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

</script>
@endsection
