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
  const contactCtx = document.getElementById('userChart').getContext('2d');

  const contactData = {
      labels: {!! json_encode($userlabels) !!},
      datasets: [{
          label: 'User per Month',
          data: {!! json_encode($userdata) !!},
          fill: false,
          borderColor: 'rgb(75, 192, 192)',
          tension: 0.1
      }]
  };

  new Chart(contactCtx, {
      type: 'line',
      data: contactData,
      options: {
          responsive: true,
          scales: {
              y: {
                  beginAtZero: true,
                  ticks: { stepSize: 1 }
              }
          }
      }
  });
</script>
@endsection
