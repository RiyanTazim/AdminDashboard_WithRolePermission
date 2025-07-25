@extends('Backend.admin.admin_dashboard')


@section('admin')
    <div class="pc-container">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h4 class="mb-0">Add Permission</h4>
                        </div>
                        <div class="card-body">
                            <form id="permissionForm" action="{{ route('admin.user.store') }}" method="POST"
                                autocomplete="off">
                                @csrf
                                <input type="text" name="fakeusernameremembered" style="display:none">
                                <input type="password" name="fakepasswordremembered" style="display:none">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" autocomplete="off"
                                        class="form-control @error('name') is-invalid @enderror">

                                    @error('name')
                                        <div class="text-danger mb-3">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">Username<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" autocomplete="off"
                                        class="form-control @error('username') is-invalid @enderror">

                                    @error('username')
                                        <div class="text-danger mb-3">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" autocomplete="off"
                                        class="form-control @error('email') is-invalid @enderror">

                                    @error('email')
                                        <div class="text-danger mb-3">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="" class="form-label">New Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        autocomplete="off">
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Confirm New Password --}}
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" autocomplete="off">
                                    @error('password_confirmation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Assign Role <span class="text-danger">*</span></label>
                                    @if ($roles->isNotEmpty())
                                        @foreach ($roles as $role)
                                            <div class="form-check mb-1">
                                                <input type="checkbox" class="form-check-input" name="roles[]"
                                                    value="{{ $role->name }}" id="role_{{ $role->id }}"
                                                    {{-- {{ $user->hasRole($role->name) ? 'checked' : '' }} --}}>
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    {{ $role->name }}
                                                </label>
                                                @error('roles')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
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
