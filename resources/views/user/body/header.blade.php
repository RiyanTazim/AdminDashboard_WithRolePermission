<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <ul class="navbar-nav">
            @php
                $id = Auth::user()->id;
                $profileData = App\Models\User::find($id);

                $primaryPath = public_path('upload/user_images/' . $profileData->photo);
                $fallbackPath = public_path('upload/admin_images/' . $profileData->photo);

                if (file_exists($primaryPath)) {
                    $imagePath = asset('upload/user_images/' . $profileData->photo);
                } elseif (file_exists($fallbackPath)) {
                    $imagePath = asset('upload/admin_images/' . $profileData->photo);
                } else {
                    $imagePath = asset('upload/no_image.jpg'); // optional fallback image
                }
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" src="{{ $imagePath }}" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle" src="{{ $imagePath }}" alt="">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ $profileData->name }}</p>
                            <p class="tx-12 text-muted">{{ $profileData->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href="{{ route('user.profile') }}" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="{{ route('user.change.password') }}" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="edit"></i>
                                <span>Change Password</span>
                            </a>
                        </li>
                        {{-- <li class="dropdown-item py-2">
                            <a href="javascript:;" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="repeat"></i>
                                <span>Switch User</span>
                            </a>
                        </li> --}}
                        <li class="dropdown-item py-2">
                            <a href="{{ route('user.logout') }}" class="text-body ms-0">
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
