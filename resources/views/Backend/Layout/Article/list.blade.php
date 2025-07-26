@extends('Backend.master')

@push('links')
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css" rel="stylesheet">
@endpush

@section('admin')
    <div class="container py-5">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <h5 class="mb-0">Articles List</h5>
                <a href="{{ route('dynamicpage.create') }}" class="btn btn-light btn-sm">Add New</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="articleTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">SL</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Content</th>
                                <th class="text-center">Author</th>
                                <th class="text-center" width="15%">Action</th>
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

            $('#articleTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('article.getData') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'body',
                        name: 'body'
                    },
                    {
                        data: 'author',
                        name: 'author',
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
            /* placeholder: #ffffff !important; */
            color: #ffffff
        }
    </style>
@endpush
