@extends('admin.layouts.app')
@section('title', 'User-List')
@section('admin-user-active', 'mm-active')
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
        <a href="{{ route('admin-user.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle mr-1"></i>Create Admin
        </a>
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
                            <th>IP</th>
                            <th>User_Agent</th>
                            <th>Created_at</th>
                            <th>Update_at</th>
                            <th>Action</th>

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
                ajax: '/admin/admin-user/datatable/ssd',
                processing: true,
                serverSide: true,
                columns: [{
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
                    {
                        data: "ip",
                        name: "ip"
                    },
                    {
                        data: "user_agent",
                        name: "user_agent",
                        sortable: false,
                        searchable: false
                    },
                        {
                        data: "created_at",
                        name: "created_at"
                    },
                    {
                        data: "updated_at",
                        name: "updated_at"
                    },
                    {
                        data: "action",
                        name: "action",
                        sortable: false,
                        searchable: false
                    },

                ],
                order:[
                    [6,'desc']
                ]
            });

            $(document).on('click', '.delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/admin-user/' + id,
                            type: 'DELETE',
                            success: function() {
                                table.ajax.reload();
                            }
                        });
                        // Swal.fire({
                        //   title: "Deleted!",
                        //   text: "Your file has been deleted.",
                        //   icon: "success"
                        // });
                    }
                });
            });
        });
    </script>

@endsection
