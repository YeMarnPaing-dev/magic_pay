@extends('admin.layouts.app')
@section('title', 'Wallets')
@section('admin-wallet-active', 'mm-active')
@section('content')

    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-wallet icon-gradient bg-mean-fruit">
                    </i>
                </div>
                <div>Wallets</div>
            </div>
        </div>
    </div>

    <div class="pt3">
        <a href="{{route('wallet#add')}}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add Amount</a>
         <a href="{{route('wallet#reduce')}}" class="btn btn-danger"><i class="fa-solid fa-minus"></i>Remove Amount</a>
    </div>



    <div class="content py-3">

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered Datatable">
                    <thead>
                        <tr class="bg-light">
                            <th>Account Person</th>
                            <th>Account Number</th>
                            <th>Amount(MMK)</th>
                            <th>Created_at</th>
                            <th>Update_at</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>


            </div>
        </div>

    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {
            var table = new DataTable('.Datatable', {
                ajax: '/admin/wallet/datatable/ssd',
                processing: true,
                serverSide: true,
                columns: [{
                        data: "account_person",
                        name: "account_person"
                    },
                    {
                        data: "account_number",
                        name: "account_number"
                    },
                    {
                        data: "amount",
                        name: "amount"
                    },

                        {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "updated_at",
                        name: "updated_at"
                    }

                ],
                order:[
                    [4,'desc']
                ]
            });


        });
    </script>

@endsection
