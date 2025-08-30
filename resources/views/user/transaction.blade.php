@extends('user.layouts.app_plain')
@section('title', 'Transaction')

@section('content')

<div class="Transaction">
    <div class="infinite-scroll">
 @foreach ($transactions as $transaction)
<a style="text-decoration: none;" href="{{url('user/transactionDetail/' .  $transaction->trx_id)}}">
     <div class="card mb-2">
    <div class="card-body p-2">
      <div class="d-flex justify-content-between">
        <h6 class="mb-1">Trx Id:{{$transaction->trx_id}}</h6>
        <p class="mb-1 @if($transaction->type == 1)
            text-success
        @elseif ($transaction->type == 2)
            text-danger
        @endif">{{$transaction->amount}} <small>MMK</small></p>
      </div>
      <p class="mb-1">
        @if ($transaction->type ==1 )
        From
        @elseif ($transaction->type == 2)
        To
        @endif
        {{$transaction->source ? $transaction->source->name : ''}}
    </p>
    <p class="text-muted mb-1">{{$transaction->created_at->format('j-F-y H:i:s')}}</p>
    </div>
 </div>
</a>
 @endforeach

<div> {{$transactions->links()}}</div>
</div>

</div>

@endsection

{{-- @section('script')
<script>
    $('ul.pagination').hide();
    $(function() {
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            loadingHtml: '<img class="center-block" src="/images/loading.gif" alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });
</script>
@endsection --}}
