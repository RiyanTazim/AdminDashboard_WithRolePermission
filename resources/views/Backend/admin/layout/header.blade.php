<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">

        <ul class="navbar-nav">
            @php
                $id = Auth::user()->id;
                $profileData = App\Models\User::find($id);
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle"
                        src="{{ !empty($profileData->photo) ? url('upload/user_images/' . $profileData->photo) : url('/upload/no_image.jpg') }}"
                        alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle"
                                src="{{ !empty($profileData->photo) ? url('upload/user_images/' . $profileData->photo) : url('/upload/no_image.jpg') }}"
                                alt="">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ $profileData->name }}</p>
                            <p class="tx-12 text-muted">{{ $profileData->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href="@role('Admin|Super Admin'){{ route('admin.profile') }}@else{{ route('user.profile') }}@endrole"
                                class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>

                        <li class="dropdown-item py-2">
                            <a href="@role('Admin|Super Admin'){{ route('admin.change.password') }}@else{{ route('user.change.password') }}@endrole"
                                class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="edit"></i>
                                <span>Change Password</span>
                            </a>
                        </li>

                        @role('Admin|Super Admin')
                            <li class="dropdown-item py-2">
                                <a href="{{ route('admin.user.list') }}" class="text-body ms-0">
                                    <i class="me-2 icon-md" data-feather="users"></i>
                                    <span>Check User's List</span>
                                </a>
                            </li>
                        @endrole

                        <li class="dropdown-item py-2">
                            <a href="@role('Admin|Super Admin'){{ route('admin.logout') }}@else{{ route('user.logout') }}@endrole"
                                class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </li>
        </ul>
    </div>
</nav>
