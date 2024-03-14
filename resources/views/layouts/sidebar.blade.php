<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4">

    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('avatars/avatar.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ URL::to('/profile') }}"
                    class="d-block text-theme">{{ Auth::user()->name }}</a>
            </div>
        </div>
        
        @if (Auth::guard('admin')->user())
            <div class="user-panel mt-0 pb-2 mb-2">
                <div class="info py-0 px-1">
                    <a href="{{ URL::to('admin/login-back') }}" class="d-block btn-block btn btn-primary btn-theme">
                        Login as {{ Auth::guard('admin')->user()->name }}
                    </a>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul id="sidebarNav" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ URL::to('/') }}"
                        class="nav-link {{ request()->is('/*') || request()->is('/') ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Logout --}}
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="$('#logout-form').submit();"
                        class="nav-link {{ request()->is('logout') ? 'active' : '' }}">
                        <i class="fa fa-right-from-bracket nav-icon"></i>
                        <p>Logout</p>
                    </a>
                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" id="logout-form" method="POST">
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
