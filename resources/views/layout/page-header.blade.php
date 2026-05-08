{{-- page-header.css --}}

<header class="hero-section scroll-fade-in" style="background-image: url('{{ asset($bgImage ?? 'images/bg.jpg') }}');">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-md-10 col-lg-10 py-5">

                <h1 class="hero-title fw-900 text-white text-shadow scroll-fade-in">
                    {!! $title ?? 'Welcome to the Website of<br>Sangguniang Bayan ng Mabini, Pangasinan' !!}
                </h1>

            </div>
        </div>
    </div>
</header>