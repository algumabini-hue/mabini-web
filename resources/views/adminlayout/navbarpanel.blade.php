<link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">

<div class="container-fluid topdiv"></div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <div class="header-title d-flex">

            <div class="">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="d-inline-block align-text-top me-2" style="height: 75px;">
            </div>
            <div class="header-text">
                <p class="navtext mb-0 mt-3">Republic of the Philippines</p>
                <h6 class="navtext mb-0 mt-0">PROVINCE OF PANGASINAN</h6>
                <h5 class="navtext mb-0 mt-0">MUNICIPALITY OF MABINI</h5>
            </div>

        </div>
        {{-- tailwind-ignore: end-0 --}}
        <button class="navbar-toggler position-absolute top-0 end-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Large screens: show nav items inline and aligned to the end -->
        <div class="d-none d-lg-flex w-100">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @guest
                <li class="nav-item">
                    <a class="nav-link text-dark navigation" href="{{ route('login') }}"><strong>LOGIN</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark navigation" href="{{ route('signup') }}"><strong>SIGN UP</strong></a>
                </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link text-dark navigation" href="{{ route('dashboard') }}" data-uid="true"><strong>HOME</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark navigation" href="{{ route('municipality') }}" data-uid="true"><strong>EVENT UPLOADER</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark navigation" href="{{ route('municipality.uploaded') }}" data-uid="true"><strong>EVENT ALBUMS</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark navigation" href="{{ route('ordinance') }}" data-uid="true"><strong>ORDINANCES</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark navigation" href="{{ route('official') }}" data-uid="true"><strong>OFFICIALS</strong></a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link text-dark navlogout"><strong>LOGOUT</strong></button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Small screens: collapsed menu appears below the navbar as a full-width block -->
<div class="collapse bg-light w-100" id="adminNavbar">
    <div class="container-fluid ps-0">
        <ul class="navbar-nav py-2 ps-3 text-start w-100">
            @guest
            <li class="nav-item">
                <a class="nav-link text-dark navigation" href="{{ route('login') }}"><strong>LOGIN</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark navigation" href="{{ route('signup') }}"><strong>SIGN UP</strong></a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link text-dark navigation" href="{{ route('dashboard') }}" data-uid="true"><strong>HOME</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark navigation" href="{{ route('municipality') }}" data-uid="true"><strong>EVENT UPLOADER</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark navigation" href="{{ route('municipality.uploaded') }}" data-uid="true"><strong>EVENT ALBUMS</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark navigation" href="{{ route('ordinances') }}" data-uid="true"><strong>ORDINANCES</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark navigation" href="{{ route('officials') }}" data-uid="true"><strong>OFFICIALS</strong></a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-dark navlogout"><strong>LOGOUT</strong></button>
                </form>
            </li>
            @endguest
        </ul>
    </div>
</div>
