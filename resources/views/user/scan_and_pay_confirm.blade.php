@extends('user.layouts.app_plain')
@section('title', 'Scan and Pay Confirm')

@section('content')

    <div class="transfer Confirmation">

        <div class="card" style="">
            <div class="card-body">
                @include('user.flash')
                <form action="{{ route('scan#Complete') }}" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="hash_value" value="{{ $hash_value }}">
                    <input type="hidden" name="to_phone" value="{{ $to_account->phone }}">
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <input type="hidden" name="description" value="{{ $description }}">
                    <div class="form-group">
                        <label for=""><strong>From</strong></label>
                        <p class="mb-1">{{ $from_account->name }}</p>
                        <p class="mb-1">{{ $from_account->phone }}</p>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>To</strong></label>
                        <p class="text-muted mb-1">{{ $to_account->name }}</p>
                        <p class="text-muted mb-1">{{ $to_account->phone }}</p>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Amount</strong></label>
                        <p class="text-muted mb-1">{{ number_format($amount) }} mmk</p>
                    </div>
                    <div class="form-group">
                        <label for=""><strong>Description</strong></label>
                        <p class="text-muted mb-1">{{ $description }}</p>
                    </div>

                    <button type="submit" style="background: #5842E3; color:#fff;"
                        class="confirm-btn btn btn-block mt-3">Confirm</button>
                </form>
            </div>
        </div>

    @endsection
    @section('script')

        <script>
            $(document).ready(function() {
                $('.confirm-btn').on('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Please fill your password",
                        icon: "info",
                        html: ` <input type="password" class='form-control password text-center' />  `,
                        showCancelButton: true,
                        reverseButtons:true,
                        focusConfirm: false,
                        cancelButtonAriaLabel: "Thumbs down"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var password = $('.password').val();
                             $.ajax({
                        url: '/user/passwordCheck?password=' + password,
                        type: 'GET',
                        success: function(res) {
                            if(res.status == 'success'){
                            $('#form').submit();
                            }else{
                                Swal.fire({
                              icon:'error',
                              title:'Oops...',
                              text:res.message,
                                });
                            }
                        }
                    });
                        }
                    });
                })
            });
        </script>

    @endsection
