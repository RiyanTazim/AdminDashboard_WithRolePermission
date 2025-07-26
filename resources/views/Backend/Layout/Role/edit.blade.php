@extends('Backend.master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Edit Role: {{ $role->name }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('role.update', $role->id) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Role Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $role->name) }}" required>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Assign Permissions <span class="text-danger">*</span></label>
                                    <div class="border p-2" style="max-height: 250px; overflow-y: auto;">
                                        @if ($permissions->isNotEmpty())
                                            @foreach ($permissions as $permission)
                                                <div class="form-check mb-1">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        id="permission_{{ $permission->id }}"
                                                        {{ in_array($permission->name, $hasPermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    @error('permissions')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-secondary w-100">Update Role</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
