@extends('admin.layouts.app')
@section('title','User-List')
@section('admin-user-active','mm-active')
@section('content')

  <div class="app-page-title">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-users icon-gradient bg-mean-fruit">
                                        </i>
                                    </div>
                                    <div>Admin-Users</div>
                                </div>
                                 </div>
                        </div>

                        <div class="py-3">
                            <a href="{{route('admin-user.create')}}" class="btn btn-primary"><i class="fas fa-plus-circle px-1"></i>Create Admin User</a>
                        </div>

                        <div class="content">

                               <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered Datatable">
                                        <thead>
                                            <tr class="bg-light">
                                                <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
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

$(document).ready(function(){
new DataTable('.Datatable',{
    ajax: '/admin/admin-user/datatable/ssd',
    processing: true,
    serverSide: true,
    columns:[
        {
            data: "name",
            name: "name"
        },
         {
            data: "email",
            name: "email"
        },
         {
            data: "phone",
            name: "phone"
        },
    ]
});
});

</script>

@endsection
