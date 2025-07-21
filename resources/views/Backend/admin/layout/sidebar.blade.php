<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            @if (auth()->user()->hasRole('admin'))
                Admin<span>UI</span>
            @else
                {{ ucfirst(auth()->user()->roles->pluck('name')->first()) }}<span>UI</span>
            @endif
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                @role('Admin|Super Admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    @else
                        <a href="{{ route('user.dashboard') }}" class="nav-link">
                        @endrole
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
            </li>
            <li class="nav-item nav-category">web apps</li>

            <li class="nav-item nav-category">Components</li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiComponent" role="button" aria-expanded="false"
                    aria-controls="uiComponents">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Profile Action</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="uiComponent">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            @role('Admin|Super Admin')
                                <a href="{{ route('admin.profile') }}" class="nav-link">Profile</a>
                            @else
                                <a href="{{ route('user.profile') }}" class="nav-link">Profile</a>
                            @endrole
                        </li>
                        <li class="nav-item">
                            @role('Admin|Super Admin')
                                <a href="{{ route('admin.change.password') }}" class="nav-link">Change Password</a>
                            @else
                                <a href="{{ route('user.change.password') }}" class="nav-link">Change Password</a>
                            @endrole
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="false"
                    aria-controls="uiComponents">
                    <i class="link-icon" data-feather="zap"></i>
                    <span class="link-title">Action</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="uiComponents">
                    @role('Admin|Super Admin')
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('admin.user.list') }}" class="nav-link"> User List</a>
                            </li>
                        </ul>
                    @endrole
                    @can('View')
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('permission.list') }}" class="nav-link"> Permission List</a>
                            </li>
                        </ul>
                    @endcan
                    @can('View')
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('role.list') }}" class="nav-link"> Role List</a>
                            </li>
                        </ul>
                    @endcan

                    @can('View')
                        <ul class="nav sub-menu">
                            <li class="nav-item">
                                <a href="{{ route('article.list') }}" class="nav-link"> Article List</a>
                            </li>
                        </ul>
                    @endcan
                </div>
            </li>


            {{-- <li class="nav-item nav-category">Docs</li>
            <li class="nav-item">
                <a href="https://www.nobleui.com/html/documentation/docs.html" target="_blank" class="nav-link">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Documentation</span>
                </a>
            </li> --}}
        </ul>
    </div>
</nav>
