@extends('Backend.admin.admin_dashboard')

@section('admin')
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Permission List</h5>
                            <a href="{{ route('permission.create') }}" class="btn btn-light btn-sm">Add New</a>
                        </div>

                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="text-white">{{ Session::get('success') }}</div>
                            @endif

                            @if ($permissions->isEmpty())
                                <p class="text-muted mb-0">No permissions found.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Permission Name</th>
                                                {{-- <th>Created At</th> --}}
                                                <th style="width: 250px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $index => $permission)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $permission->name }}</td>
                                                    {{-- <td>{{ $permission->created_at->format('d M Y') }}</td> --}}
                                                    <td>
                                                        <a href="{{ route('permission.edit', $permission->id) }}"
                                                            class="btn btn-sm btn-inverse-warning" title="Edit"><i
                                                                data-feather="edit"></i></a>
                                                        <a href="{{ route('permission.delete', $permission->id) }}"
                                                            class="btn btn-sm btn-inverse-danger delete-confirm"
                                                            title="Delete">
                                                            <i data-feather="trash-2"></i>
                                                        </a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <div class="d-flex mt-3 ms-auto justify-content-end">
                                {{ $permissions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-confirm').forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.getAttribute('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    });
</script>

@endsection
