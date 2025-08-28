@extends('user.layouts.app_plain')
@section('title', 'Transfer')

@section('content')

    <div class="transfer">

        <div class="card" style="">
            <div class="card-body">
                <form action="{{ route('confirm#transfer') }}" method="GET">

                    <div class="form-group">
                        <label for="">From</label>
                        <p class="mb-1">{{ $user->name }}</p>
                        <p class="mb-1">{{ $user->phone }}</p>
                    </div>

                    <div class="form-group">
                        <label for="">To <span class="text-success to_account_info"></span></label>
                        <div class="input-group">

                            <input type="text" name="to_phone" value="{{ old('to_phone') }}"
                                class="form-control to_phone @error('to_phone')  is-invalid @enderror">
                            <span class="input-group-text btn verify-btn"><i class="fa-solid fa-circle-check"></i></span>
                               @error('to_phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="">Amount</label>
                        <input type="number" name="amount" value="{{ old('amount') }}"
                            class="form-control @error('amount')  is-invalid @enderror">
                        @error('amount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control @error('description')  is-invalid @enderror" id="">
                {{ old('description') }}
               </textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" style="background: #5842E3; color:#fff;"
                        class="btn btn-block mt-3">Continue</button>
                </form>
            </div>
        </div>

    @endsection

    @section('script')

        <script>
            $(document).ready(function() {
                $('.verify-btn').on('click', function() {
                    var phone = $('.to_phone').val().trim();
                    if (phone === '') {
                        alert('Please enter a phone number');
                        return;
                    }

                    $.ajax({
                        url: '/user/to-account-verify?phone=' + phone,
                        type: 'GET',
                        success: function(res) {
                            if(res.status == 'success'){
                                $('.to_account_info').text('('+res.data['name']+')');
                            }else{
                                 $('.to_account_info').text('('+res.message+')');
                            }
                        }
                    });
                });
            });
        </script>

    @endsection
