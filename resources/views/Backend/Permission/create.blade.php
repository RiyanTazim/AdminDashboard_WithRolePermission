@extends('Backend.admin.admin_dashboard')

@section('admin')
    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Add New User</h4>
                        </div>
                        <div class="card-body">
                            <form id="permissionForm" action="{{ route('permission.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Permission Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                </div>

                                @error('name')
                                    <div class="text-danger mb-3">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <button type="submit" class="btn btn-secondary w-100 border border-white">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
