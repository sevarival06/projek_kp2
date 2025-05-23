<!-- Navbar with User Dropdown -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-inline text-gray-600 small">{{ Auth::user()->nama ?? 'Guest User' }}</span>
                <!-- <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}" alt="Profile"> -->
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Edit Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Keluar
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Siap untuk keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih "Keluar" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Navbar Styles */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1020;
}

/* Navbar should align with content wrapper */
@media (min-width: 768px) {
    .navbar {
        margin-left: 0.0rem;
        width: calc(100% - 0.0rem);
        transition: margin 0.3s ease, width 0.3s ease;
    }

    body.sidebar-toggled .navbar {
        margin-left: 80px; /* sesuaikan dengan lebar sidebar saat toggle */
        width: calc(100% - 80px);
    }
}

@media (max-width: 767.98px) {
    .navbar {
        margin-left: 0;
        width: 100%;
        padding-left: 60px; /* Memberikan ruang untuk tombol toggle */
    }
    
    /* Username yang selalu terlihat di mobile */
    .navbar .nav-item .nav-link span.small {
        display: inline-block !important;
        font-size: 0.85rem;
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Pastikan tombol toggle selalu terlihat di atas sidebar */
    #sidebarToggleTop {
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1040;
        background-color: #fff;
        border-radius: 50%;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    /* Saat sidebar terbuka, ubah ikon bars menjadi times (X) */
    body.sidebar-toggled #sidebarToggleTop .fa-bars:before {
        content: "\f00d"; /* Font Awesome icon untuk X */
    }
}

/* Improve visibility of toggle button */
#sidebarToggleTop {
    color: #4e73df;
    margin-right: 0.5rem;
    font-size: 1.2rem;
    cursor: pointer; /* Add cursor pointer for better UX */
}

#sidebarToggleTop:focus {
    outline: none;
}

/* User information styling */
.navbar .nav-item .nav-link {
    padding: 0.75rem 1rem;
}

.img-profile {
    height: 2rem;
    width: 2rem;
}

/* Style untuk dropdown menu */
.dropdown-menu {
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 0.85rem;
    color: #3a3b45;
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 0.25rem 1.5rem;
    clear: both;
    font-weight: 400;
    color: #3a3b45;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
}

.dropdown-item:hover, .dropdown-item:focus {
    color: #2e2f37;
    text-decoration: none;
    background-color: #f8f9fc;
}

.dropdown-item:active {
    color: #fff;
    text-decoration: none;
    background-color: #4e73df;
}

.dropdown-divider {
    height: 0;
    margin: 0.5rem 0;
    overflow: hidden;
    border-top: 1px solid #e3e6f0;
}

/* Animation for dropdown */
.animated--grow-in {
    animation-name: growIn;
    animation-duration: 200ms;
    animation-timing-function: transform cubic-bezier(0.18, 1.25, 0.4, 1), opacity cubic-bezier(0, 1, 0.4, 1);
}

@keyframes growIn {
    0% {
        transform: scale(0.9);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}
</style>

<script>
// This JavaScript should be loaded after both the sidebar and navbar are rendered
document.addEventListener('DOMContentLoaded', function() {
    // Shared toggle function for both buttons
    function toggleSidebar() {
        const sidebar = document.getElementById('accordionSidebar');
        sidebar.classList.toggle('toggled');
        document.body.classList.toggle('sidebar-toggled');
    }
    
    // Add event listener for the sidebar toggle button
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }
    
    // Add event listener for the top sidebar toggle button
    const sidebarToggleTop = document.getElementById('sidebarToggleTop');
    if (sidebarToggleTop) {
        sidebarToggleTop.addEventListener('click', toggleSidebar);
    }
    
    // Tambahkan juga kemampuan untuk menutup sidebar ketika klik di overlay
    document.addEventListener('click', function(event) {
        // Cek jika overlay yang diklik (body dengan class sidebar-toggled)
        if (document.body.classList.contains('sidebar-toggled') && 
            !event.target.closest('#accordionSidebar') && 
            !event.target.closest('#sidebarToggleTop')) {
            toggleSidebar();
        }
    });
    
    // Set initial state based on screen size
    function adjustForScreenSize() {
        const sidebar = document.getElementById('accordionSidebar');
        
        if (window.innerWidth < 768) {
            // On mobile, sidebar should be hidden by default
            sidebar.classList.remove('toggled');
            document.body.classList.remove('sidebar-toggled');
        } else {
            // On desktop, sidebar should be expanded by default
            sidebar.classList.remove('toggled');
            document.body.classList.remove('sidebar-toggled');
        }
    }
    
    // Call the function on page load
    adjustForScreenSize();
    
    // Listen for window resize events
    window.addEventListener('resize', adjustForScreenSize);
    
    // Implementasi dropdown toggle untuk user menu
    const userDropdown = document.getElementById('userDropdown');
    if (userDropdown) {
        userDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('show');
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function closeDropdown(event) {
                if (!event.target.closest('.nav-item.dropdown')) {
                    const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                    openDropdowns.forEach(dropdown => dropdown.classList.remove('show'));
                    document.removeEventListener('click', closeDropdown);
                }
            });
        });
    }
});
</script>