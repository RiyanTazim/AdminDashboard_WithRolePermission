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
                            <h5 class="mb-0">Roles</h5>
                            <a href="{{ route('role.create') }}" class="btn btn-light btn-sm">Add New Role</a>
                        </div>

                        <div class="card-body">
                            @if ($roles->isEmpty())
                                <p class="text-muted mb-0">No Role found.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Role Name</th>
                                                <th>Role Permissions</th>
                                                <th style="width: 250px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $index => $role)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                                                    <td>
                                                        <a href="{{ route('role.edit', $role->id) }}"
                                                            class="btn btn-sm btn-inverse-warning" title="Edit"><i
                                                                data-feather="edit"></i></a>
                                                        <a href="{{ route('role.delete', $role->id) }}"
                                                            class="btn btn-sm btn-inverse-danger delete-confirm"
                                                            title="Delete"><i data-feather="trash-2"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                            <div class="d-flex mt-3 ms-auto justify-content-end">
                                {{ $roles->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-confirm').forEach(function(button) {
                button.addEventListener('click', function(e) {
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
