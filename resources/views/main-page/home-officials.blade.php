<div class="container mt-5 scroll-fade-in mb-5">



    <div class="row justify-content-center">
        <div class="col-12 col-lg-11">

            <a href="{{ route('officials') }}" class="text-decoration-none d-block officials-link-wrapper">

                {{-- The Envelope Frame (no changes here) --}}
                <div
                    class="officials-card position-relative overflow-hidden border border-2 rounded-4 p-4 p-md-5 shadow-sm bg-white">

                    {{-- CSS Vintage Border Wrapper (no changes here) --}}
                    <div class="css-vintage-border-container p-4">

                        {{-- Image Wrapper --}}
                        <div class="officials-img-wrapper position-relative z-0 overflow-hidden rounded-3">

                            {{-- 1. The Main Photo --}}
                            <img src="{{ asset('images/councilors.png') }}" alt="Municipality Officials"
                                class="officials-img">

                            {{--
                            2. Separate Text Container
                            The hover effect will be applied to this container.
                            --}}
                            <div class="officials-text-left position-absolute" style="bottom: 30px; left: 40px;">
                                <h2 class="text-white">MUNICIPAL OFFICIALS</h2>
                                <p class="text-white">TERM 2025 - 2028</p>
                            </div>

                            {{--
                            3. Separate Logo Container
                            The hover effect will be applied to this container.
                            --}}
                            <div class="officials-seal-framed position-absolute">
                                <img src="{{ asset('images/logo.png') }}" alt="Seal of Mabini" class="officials-seal">
                            </div>

                        </div>

                    </div>

                </div>

            </a>

        </div>
    </div>

</div>