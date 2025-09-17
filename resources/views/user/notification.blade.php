@extends('user.layouts.app_plain')
@section('title', 'Notifications')

@section('content')

    <div >
     <div class="infinite-scroll">
            @foreach ($notification as $noti)
            @php
                // $data = json_decode($notification->data,true);
            @endphp
                <a style="text-decoration: none;" href="{{ url('user/notification/' . $noti->id) }}">
                    <div class="card mb-2">
                        <div class="card-body p-2">
                    <h5> <i  class="fas fa-bell @if (is_null($noti->read_at) )
                   text-danger
                    @endif"></i> {{ \Illuminate\Support\Str::limit($noti->data['title'], 10, '...') }}</h5>
                    <p class="mb-1">{{ \Illuminate\Support\Str::limit($noti->data['message'], 30, '...') }}</p>
                    <p class="text-muted">{{$noti->created_at->format('j-F-Y h:i:s A')}}</p>

                        </div>
                    </div>
                </a>
            @endforeach

            <div> {{ $notification->links() }}</div>
        </div>

    </div>




@endsection

@section('script')

    <script>
        $(document).ready(function() {
            $('.date').daterangepicker({
                "singleDatePicker": true,
                "autoApply": true,
                "locale": {
                    "format": "YYYY/MM/DD",

                },
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                    'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });



            $('.date').on('apply.daterangepicker', function(ev, picker) {
             var date = $('.date').val();
             var type = $('.type').val();
             history.pushState(null, '', `?date=${date}&type=${type}`);
                window.location.reload();


            });

            $('.type').change(function() {
                 var date = $('.date').val();
             var type = $('.type').val();
             history.pushState(null, '', `?date=${date}&type=${type}`);
                window.location.reload();
            })



        });
    </script>

@endsection
