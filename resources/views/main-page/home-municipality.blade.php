<div class="row m-0">

    <div class="col-12 p-0 scroll-fade-in">

        {{-- Added onclick here so the entire video acts as the toggle trigger on mobile --}}
        <div class="card home-video-card text-white border-0 shadow-lg overflow-hidden rounded-0" id="munVideoCard"
            onclick="toggleMissionVision()" style="cursor: pointer;">

            <video class="card-video" autoplay loop muted playsinline>
                <source src="{{ asset('videos/hero-video.mp4') }}" type="video/mp4">
            </video>

            <div class="card-img-overlay d-flex flex-column justify-content-center video-overlay-dark p-4 p-md-5">

                {{-- Removed the left and right arrows entirely --}}

                {{-- The New Welcome Text (Hidden by default, revealed on hover/click) --}}
                <div class="row content-wrapper mt-auto mb-auto hidden-content text-center">
                    <div class="col-12 scroll-fade-in px-md-5">
                        <h1 class="fw-bolder text-uppercase text-shadow"
                            style="letter-spacing: 2px; font-size: clamp(1.8rem, 4vw, 3.5rem); line-height: 1.4;">
                            Welcome to the <br>
                            <span style="color: #6eff6e;">Official Website of</span> <br>
                             the Sangguniang Bayan ng Mabini
                        </h1>
                        
                    </div>
                </div>

                <div class="row content-wrapper">
                    <div class="col-12 text-center pb-4 scroll-fade-in">
                        {{-- Added event.stopPropagation() so clicking the button doesn't trigger the toggle --}}
                        <a class="btn btn-theme-dark btn-lg px-5 shadow-lg rounded-pill fw-bold text-uppercase"
                            style="letter-spacing: 1px;" href="{{ route('history') }}"
                            onclick="event.stopPropagation();">
                            <i class="fas fa-landmark pe-2"></i> View History
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

{{-- Script to handle mobile clicks --}}
<script>
    function toggleMissionVision() {
        document.getElementById('munVideoCard').classList.toggle('content-active');
    }
</script>