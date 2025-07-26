@extends('Backend.master')


@section('admin')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <div class="page-content">

        <div class="row profile-body">
            <!-- left wrapper start -->
            <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <img class="wd-100 rounded-circle"
                                src="{{ !empty($user->photo) ? url('upload/user_images/' . $user->photo) : url('upload/no_image.jpg') }}"
                                alt="profile">
                            <div class="ms-3">
                                <span class="h4 d-block">{{ $user->name }}</span>
                                <small class="text-muted">{{ $user->roles->pluck('name')->implode(', ') }}</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">UserName:</label>
                            <p class="text-muted">{{ $user->username }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                            <p class="text-muted">{{ $user->phone }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
                            <p class="text-muted">{{ $user->address }}</p>
                        </div>
                        <div class="mt-3 d-flex social-links">
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="github"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="twitter"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                                <i data-feather="instagram"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- left wrapper end -->
            <!-- middle wrapper start -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <div class="row">

                    <div class="card">
                        <div class="card-body">

                            <h6 class="card-title">Update User Profile</h6>

                            <form class="forms-sample" method="POST" action="{{ route('user.profile.update', $user->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" id=""
                                        autocomplete="off" value="{{ old('username', $user->username) }}">
                                    @error('username')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id=""
                                        autocomplete="off" value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id=""
                                        autocomplete="off" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" id=""
                                        autocomplete="off" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" id=""
                                        autocomplete="off" value="{{ old('address', $user->address) }}">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Photo</label>
                                    <input class="form-control" type="file" name="photo" id="image">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Photo</label>
                                    <img id="showImage" class="wd-80 rounded-circle"
                                        src="{{ !empty($user->photo) ? url('upload/user_images/' . $user->photo) : url('/upload/no_image.jpg') }}"
                                        alt="profile">
                                    @error('photo')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Assign Role <span class="text-danger">*</span></label>
                                    @if ($roles->isNotEmpty())
                                        @foreach ($roles as $role)
                                            <div class="form-check mb-1">
                                                <input type="checkbox" class="form-check-input" name="roles[]"
                                                    value="{{ $role->name }}" id="role_{{ $role->id }}"
                                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}>
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

                                <button type="submit" class="btn btn-primary me-2">Update Profile</button>
                            </form>

                        </div>
                    </div>

                </div>
                <!-- middle wrapper end -->

            </div>

        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#image').change(function(e) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files['0']);
                });
            });
        </script>
    @endsection
