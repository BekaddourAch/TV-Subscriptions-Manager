@php
    $current_page = \Route::currentRouteName();
@endphp

<!-- Sidebar -->
<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-file"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">Gestion Des Abonnements</div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Statistiques</span></a>
    </li>
    @if((Auth::user()->hasPermission('services-display')))
        <!-- Divider -->
        <hr class="sidebar-divider">


            <!-- Heading -->
            <div class="sidebar-heading {{ $current_page=='admin.subscriptions' ? 'active' : '' }}">
                Abonnements
            </div>
            <!-- Nav Item - Services -->

            <li class="nav-item {{ $current_page=='admin.subscriptions' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.subscriptions') }}">
                    <i class="fas fa-fw fa-handshake"></i>
                    {{-- <i class="fas fa-handshake-alt"></i> --}}
                    <span>Abonnements</span></a>
            </li>
    @endif

    @if((Auth::user()->hasPermission('services-display')))
        <!-- Divider -->
        <hr class="sidebar-divider">


            <!-- Heading -->
            <div class="sidebar-heading {{ $current_page=='admin.services' ? 'active' : '' }}">
                Services
            </div>
            <!-- Nav Item - Services -->

            <li class="nav-item {{ $current_page=='admin.services' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.services') }}">
                    <i class="fas fa-fw fa-tv"></i>
                    <span>Services</span></a>
            </li>
    @endif

    @if((Auth::user()->hasPermission('customers-display')))
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <div class="sidebar-heading {{ $current_page=='admin.customers' ? 'active' : '' }}">
            Clients
        </div>
        <!-- Nav Item - Clients -->
        <li class="nav-item {{ $current_page=='admin.customers' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.customers') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Clients</span></a>
        </li>
        <!-- Divider -->
    @endif

    @if((Auth::user()->hasRole('superadmin')))
        <hr class="sidebar-divider d-none d-md-block">
        <div class="sidebar-heading {{ $current_page=='admin.settings' ? 'active' : '' }}">
            Configuration
        </div>
        <li class="nav-item {{ $current_page=='admin.settings' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.settings') }}">
                <i class="fas fa-fw fa-table"></i>
                <span>Configuration</span></a>
        </li>
        <hr class="sidebar-divider d-none d-md-block">
    @endif

    <!-- Divider -->
    {{-- <hr class="sidebar-divider"> --}}

    @if((Auth::user()->hasPermission('users-display')))

            <!-- Heading -->
            <div class="sidebar-heading {{ in_array($current_page,['admin.users','admin.roles','admin.permissions'])  ? 'active' : '' }}">
                Utilisateurs
            </div>
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item {{ in_array($current_page,['admin.users','admin.roles','admin.permissions'])  ? 'active' : '' }}">
            <a class="nav-link {{ in_array($current_page,['admin.users','admin.roles','admin.permissions']) ? '' : 'collapsed' }}" href="#" data-toggle="collapse" {{ in_array($current_page,['admin.users','admin.roles','admin.permissions']) ? 'aria-expanded="true"' : 'aria-expanded="false"' }} data-target="#UsersUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-users"></i>
                <span>Gestion des Utilisateurs</span>
            </a>
            <div id="UsersUtilities" class="collapse {{ in_array($current_page,['admin.users','admin.roles','admin.permissions'])  ? 'show' : '' }}" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar" style="z-index: 2">
                <div class="py-2 bg-white rounded collapse-inner">
                    <a class="collapse-item {{ in_array($current_page,['admin.users'])  ? 'active' : '' }}" href="{{ route('admin.users') }}">Utilisateurs</a>
                    <a class="collapse-item {{ in_array($current_page,['admin.roles'])  ? 'active' : '' }}" href="{{ route('admin.roles') }}">Roles</a>
                    <a class="collapse-item {{ in_array($current_page,['admin.permissions'])  ? 'active' : '' }}" href="{{ route('admin.permissions') }}">Permissions</a>
                </div>
            </div>
        </li>
    @endif


    <!-- Divider -->
    <hr class="sidebar-divider">

@if(1==0)
    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="py-2 bg-white rounded collapse-inner">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="{{ route('admin.index') }}">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="py-2 bg-white rounded collapse-inner">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li>

@endif
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="border-0 rounded-circle" id="sidebarToggle"></button>
    </div>

    {{-- <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="mb-2 sidebar-card-illustration" src="{{ asset('backend/img/undraw_rocket.svg') }}" alt="...">
        <p class="mb-2 text-center"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
    </div> --}}

</ul>
<!-- End of Sidebar -->
