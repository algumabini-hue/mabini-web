<nav id="main-navbar" class="navbar navbar-expand-lg transparent-nav py-2 fixed-top"
    data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container-fluid px-4">

        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="navbar-logo me-2">
            <div class="d-flex flex-column navbar-brand-text lh-1">
                <span class="brand-text-sm">Republic of the Philippines</span>
                <span class="brand-text-md fw-bold">PROVINCE OF PANGASINAN</span>
                <span class="brand-text-lg fw-bolder">MUNICIPALITY OF MABINI</span>
            </div>
        </a>

        <button class="navbar-toggler custom-toggler collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="icon-bar top-bar"></span>
            <span class="icon-bar middle-bar"></span>
            <span class="icon-bar bottom-bar"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="ms-auto d-flex flex-column flex-lg-row align-items-lg-center mt-3 mt-lg-0">
                <a class="nav-link fw-bold  me-lg-4 mb-2 mb-lg-0" href="{{ route('home') }}">HOME</a>
                <a class="nav-link fw-bold  me-lg-4 mb-2 mb-lg-0" href="{{ route('history') }}">MUNICIPALITY</a>
                <a class="nav-link fw-bold  me-lg-4 mb-2 mb-lg-0" href="{{ route('ordinances') }}">ORDINANCES</a>
                <a class="nav-link fw-bold  me-lg-4 mb-2 mb-lg-0" href="{{ route('officials') }}">OFFICIALS</a>
                <a class="nav-link fw-bold  me-lg-4 mb-2 mb-lg-0" href="{{ route('events') }}">EVENTS</a>

                {{-- NEW EXPANDING SEARCH BAR --}}
                <form action="{{ route('search') }}" method="GET" class="expandable-search-form ms-lg-3 mt-3 mt-lg-0">
                    <div class="search-container">
                        <input class="search-input" type="search" name="query" placeholder="Search..." value="{{ request('query') }}" required>
                        <button class="search-btn" type="submit" aria-label="Search">
                            {{-- Using FontAwesome. If you use Bootstrap Icons, change to: <i class="bi bi-search"></i> --}}
                            <i class="fas fa-search fs-6"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</nav>