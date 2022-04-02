<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Menu</li>
        <li class="sidebar-item {{ (request()->is('home')) ? 'active' : '' }}">
            <a href="{{ route('home') }}" class='sidebar-link'>
                <i class="bi bi-house-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item ">
            <div class="card-body">
                <div class="badges">
                    @if (Auth::user()->role_name=='Admin')
                    <span>Name: <span class="fw-bolder">{{ Auth::user()->name }}</span></span>
                    <hr>
                    <span>Role Name:</span>
                    <span class="badge bg-success">Admin</span>
                    @endif
                    @if (Auth::user()->role_name=='Super Admin')
                    <span>Name: <span class="fw-bolder">{{ Auth::user()->name }}</span></span>
                    <hr>
                    <span>Role Name:</span>
                    <span class="badge bg-info">Super Admin</span>
                    @endif
                    @if (Auth::user()->role_name=='Normal User')
                    <span>Name: <span class="fw-bolder">{{ Auth::user()->name }}</span></span>
                    <hr>
                    <span>Role Name:</span>
                    <span class="badge bg-warning">User Normal</span>
                    @endif
                </div>
            </div>
        </li>

        <li class="sidebar-item {{ (request()->is('change/password')) ? 'active' : '' }}" >
            <a href="{{ route('change/password') }}" class='sidebar-link'>
                <i class="bi bi-shield-lock"></i>
                <span>Change Password</span>
            </a>
        </li>

        @if (Auth::user()->role_name=='Admin')
        <li class="sidebar-title">Page &amp; Controller</li>
        <li class="sidebar-item  has-sub  {{ (request()->is('userManagement')) ? 'active' : '' }} {{ (request()->is('activity/log')) ? 'active' : '' }} {{ (request()->is('activity/login/logout')) ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-hexagon-fill"></i>
                <span>Maintenance</span>
            </a>
            <ul class="submenu active">
                <li class="submenu-item">
                    <a href="{{ route('userManagement') }}">User Control</a>
                </li>
                <li class="submenu-item">
                    <a href="{{ route('activity/log') }}">User Activity Log</a>
                </li>
                <li class="submenu-item">
                    <a href="{{ route('activity/login/logout') }}">Activity Log</a>
                </li>
            </ul>
        </li>
        @endif

        <li class="sidebar-title">Forms &amp; Tables</li>
        <li class="sidebar-item  has-sub  {{ (request()->is('form/staff/new')) ? 'active' : '' }} {{ (request()->is('form/view/detail')) ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-file-earmark-medical-fill"></i>
                <span>Form Elements</span>
            </a>
            <ul class="submenu active">
                <li class="submenu-item active">
                    <a href="{{ route('form/staff/new') }}">Staff Input</a>
                </li>
                <li class="submenu-item">
                    <a href="{{ route('form/view/detail') }}">View Detail</a>
                </li>
            </ul>
        </li>
        <!--                <li class="sidebar-item">
                            <a href="{{ route('lock_screen') }}" class='sidebar-link'>
                                <i class="bi bi-lock-fill"></i>
                                <span>Lock Screen</span>
                            </a>
                        </li>-->
        <li class="sidebar-item">
            <a href="{{ route('logout') }}" class='sidebar-link'>
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
            </a>
        </li>
    </ul>
</div>