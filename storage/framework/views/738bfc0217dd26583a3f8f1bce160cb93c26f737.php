<?php
    $current_page = \Route::currentRouteName();
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo e(route('dashboard')); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="mx-3 sidebar-brand-text">Tableau de bord Admin </div>
    </a>

    <!-- Divider -->
    <hr class="my-0 sidebar-divider">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo e(request()->is('admin') ? 'active' : ''); ?>">
        <a class="nav-link" href="<?php echo e(route('admin.index')); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>
    <?php if((Auth::user()->hasPermission('services-display'))): ?>
        <!-- Divider -->
        <hr class="sidebar-divider">


            <!-- Heading -->
            <div class="sidebar-heading">
                Abonnements
            </div>
            <!-- Nav Item - Services -->

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.subscriptions')); ?>">
                    <i class="fas fa-fw fa-tv"></i>
                    <span>Abonnements</span></a>
            </li>
    <?php endif; ?>

    <?php if((Auth::user()->hasPermission('services-display'))): ?>
        <!-- Divider -->
        <hr class="sidebar-divider">


            <!-- Heading -->
            <div class="sidebar-heading">
                Services
            </div>
            <!-- Nav Item - Services -->

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('admin.services')); ?>">
                    <i class="fas fa-fw fa-tv"></i>
                    <span>Services</span></a>
            </li>
    <?php endif; ?>

    <?php if((Auth::user()->hasPermission('customers-display'))): ?>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <div class="sidebar-heading">
            Clients
        </div>
        <!-- Nav Item - Clients -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('admin.customers')); ?>">
                <i class="fas fa-fw fa-table"></i>
                <span>Clients</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    <?php endif; ?>

    <!-- Divider -->
    

    <?php if((Auth::user()->hasPermission('users-display'))): ?>
            <!-- Heading -->
            <div class="sidebar-heading">
                Utilisateurs
            </div>
        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#UsersUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-users"></i>
                <span>gestion des Utilisateurs</span>
            </a>
            <div id="UsersUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="py-2 bg-white rounded collapse-inner">
                    <a class="collapse-item" href="<?php echo e(route('admin.users')); ?>">Utilisateurs</a>
                    <a class="collapse-item" href="<?php echo e(route('admin.roles')); ?>">Roles</a>
                    <a class="collapse-item" href="<?php echo e(route('admin.permissions')); ?>">Permissions</a>
                </div>
            </div>
        </li>
    <?php endif; ?>


    <!-- Divider -->
    <hr class="sidebar-divider">

<?php if(1==0): ?>
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
                <a class="collapse-item" href="<?php echo e(route('admin.index')); ?>">Buttons</a>
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

<?php endif; ?>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="border-0 rounded-circle" id="sidebarToggle"></button>
    </div>

    

</ul>
<!-- End of Sidebar -->
<?php /**PATH C:\xampp\htdocs\tv-subscriptions-management\resources\views/partial/backend/sidebar.blade.php ENDPATH**/ ?>