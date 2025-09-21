@extends('admin.layouts.app')
@section('title', 'Wallets Add Amount')
@section('admin-wallet-active', 'mm-active')
@section('content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-wallet icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Add Amount</div>
            </div>
        </div>
    </div>





   <div class="content py-3">

        <div class="card">
            <div class="card-body">
               <form action="{{ route('wallet#addStore') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="user_id">User</label>
        <select name="user_id" id="user_id" class="user_id form-control">
            <option value="">Please Choose</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->phone }})
                </option>
            @endforeach
        </select>
        @error('user_id')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}">
        @error('amount')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        @error('description')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="d-flex justify-content-center">
        <button type="button" class="btn btn-secondary mr-2 back-btn">Cancel</button>
        <button type="submit" class="btn btn-primary">Confirm</button>
    </div>
</form>

            </div>
        </div>

    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {
            $('.user_id').select2();
        });
    </script>

@endsection
