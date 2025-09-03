<nav class="topbar-custom">
    <div class="left">
        <button class="icon-btn" data-sidebar-toggle aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="center">
        <!-- bisa kosong / judul halaman -->
    </div>

    <div class="right">
        <a class="icon-btn" href="#"><i class="bi bi-bell-fill"></i></a>

        <div class="dropdown relative">
            <button id="topbar-profile-btn" class="icon-btn">
                <i class="bi bi-person-circle"></i>
            </button>
            <div id="topbar-profile-menu"
                class="dropdown-menu absolute right-0 mt-2 w-48 bg-white shadow-md rounded-md hidden">
                <a href="{{ route('profile.edit') }}">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
