<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-users-gear"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>


    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>



    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{route("a-users")}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>ÜYE İŞLEMLERİ</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route("a-parks")}}">
            <i class="fas fa-fw fa-table"></i>
            <span>PARK İŞLEMLERİ</span></a>
    </li>

    <!-- Nav Item - Qrs-->
    <li class="nav-item">
        <a class="nav-link" href="{{route("a-qrs")}}">
            <i class="fas fa-fw fa-table"></i>
            <span>QR İŞLEMLERİ</span></a>
    </li>
    <!-- Nav Item - Rapor-->
    <li class="nav-item">
        <a class="nav-link" href="{{route("all-rapor")}}">
            <i class="fas fa-fw fa-table"></i>
            <span>RAPOR İŞLEMLERİ</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->
