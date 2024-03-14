<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">

    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="{{ config('app.name') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('avatars/avatar.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ URL::to('admin/profile') }}"
                    class="d-block text-theme">{{ Auth::guard('admin')->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul id="sidebarNav" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ URL::to('/admin') }}"
                        class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Staff --}}
                <li class="nav-item">
                    <a href="{{ URL::to('/admin/staff') }}"
                        class="nav-link {{ request()->is('admin/staff') || request()->is('admin/staff/*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users-gear"></i>
                        <p>Staff Management</p>
                    </a>
                </li>

                {{-- Users --}}
                {{-- <li class="nav-item">
                    <a href="{{ URL::to('/admin/users') }}"
                        class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>Users Management</p>
                    </a>
                </li> --}}

                {{-- Namaz Time --}}
                <li class="nav-item">
                    <a href="{{ route('admin.prayer-times.index') }}"
                        class="nav-link {{ request()->routeIs('admin.prayer-times.*') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-users"></i>
                        <p>Prayer Times</p>
                    </a>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="$('#logout-form').submit();" class="nav-link">
                        <i class="fa fa-right-from-bracket nav-icon"></i>
                        <p>Logout</p>
                    </a>
                    {{-- Logout --}}
                    <form action="{{ route('admin.logout') }}" id="logout-form" method="POST">
                        @csrf
                        @method('POST')
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
