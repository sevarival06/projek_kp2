<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-text mx-3">AMS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi Surat
    </div>

    <!-- Surat Masuk -->
    <li class="nav-item {{ request()->is('surat-masuk*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('surat-masuk.index') }}">
            <i class="fas fa-fw fa-envelope-open-text"></i>
            <span>Surat Masuk</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Akun
    </div>

    <!-- Pengaturan Profil -->
    <li class="nav-item {{ request()->is('profile*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profile.edit') }}">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Pengaturan Profil</span>
        </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Visible on Desktop) -->
    <!-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->
</ul>
<!-- End of Sidebar -->

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
/* Sidebar Styles */
.sidebar {
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    width: 225px;
    z-index: 1030;
    transition: all 0.3s ease;
}

#content-wrapper {
    margin-left: 225px;
    transition: margin 0.3s ease;
}

/* Toggled State for Desktop */
.sidebar.toggled {
    width: 6.5rem !important;
}

.sidebar.toggled .nav-item .nav-link span {
    display: none;
}

.sidebar.toggled .sidebar-brand-text {
    display: none;
}

.sidebar.toggled .sidebar-heading {
    text-align: center;
    font-size: 0.65rem;
}

body.sidebar-toggled #content-wrapper {
    margin-left: 6.5rem !important;
}

/* Mobile Styles (less than 768px) */
@media (max-width: 767.98px) {
    .sidebar {
        transform: translateX(-225px);
        width: 225px !important;
    }

    #content-wrapper {
        margin-left: 0 !important;
    }

    /* When sidebar is toggled on mobile */
    .sidebar.toggled {
        transform: translateX(0);
    }

    /* Prevent content from shifting on mobile */
    body.sidebar-toggled #content-wrapper {
        margin-left: 0 !important;
    }

    /* Overlay effect when sidebar is open on mobile */
    body.sidebar-toggled::before {
        content: "";
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 1020;
    }
}

/* Sidebar Toggle Button */
#sidebarToggle {
    background-color: rgba(255, 255, 255, 0.2);
    cursor: pointer;
}

#sidebarToggle:hover {
    background-color: rgba(255, 255, 255, 0.3);
}
</style>