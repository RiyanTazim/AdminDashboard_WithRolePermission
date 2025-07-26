@extends('Backend.master')

@push('links')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
@endpush

@push('scriptTop')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

@section('admin')

    <div class="container py-5">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <h4 class="mb-0">User List</h4>
                <a href="{{ route('admin.user.create') }}" class="btn btn-light btn-sm">Add New User</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">SL</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">User Name</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">role</th>
                                <th class="text-center">photo</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- ✅ jQuery FIRST -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- ✅ DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <!-- ✅ Initialize DataTable -->
    <script>
        $(document).ready(function() {

            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.user.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username',
                        className: 'text-center'
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'text-center'
                    },
                    {
                        data: 'roles',
                        name: 'roles'
                    },
                    {
                        data: 'photo',
                        name: 'photo',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
                drawCallback: function(settings) {
                    if (window.feather) {
                        feather.replace(); // 🟢 Replaces feather icons after each redraw
                    }
                }
            });

            $('.dataTables_filter input').attr('placeholder', 'Search...');

        });
        const deleteRouteBase = "{{ route('user.profile.delete', ':id') }}";

        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var deleteUrl = deleteRouteBase.replace(':id', id); // Replace placeholder

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: "GET",
                        success: function(response) {
                            $('#userTable').DataTable().ajax.reload();
                            Swal.fire('Deleted!', 'Your data has been deleted.',
                                'success');
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });

        });
    </script>
@endpush

@push('styles')
    <style>
        /* Prevent unnecessary horizontal scroll */
        #articleTable_wrapper {
            overflow-x: auto;
        }

        table.dataTable {
            width: 100% !important;
        }

        .select {
            color: #ffffff !important;
        }

        .dataTables_wrapper .dataTables_length select {
            color: #ffffff !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            color: #ffffff
        }
    </style>
@endpush
