@extends('Backend.master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Add New Roles</h4>
                        </div>
                        <div class="card-body">
                            <form id="permissionForm" action="{{ route('role.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Assign Permissions <span class="text-danger">*</span></label>
                                    <div class="border p-2" style="max-height: 250px; overflow-y: auto;">
                                        @if ($permissions->isNotEmpty())
                                            @foreach ($permissions as $permission)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permission[]"
                                                        value="{{ $permission->name }}"
                                                        id="permission_{{ $permission->id }}">
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
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
