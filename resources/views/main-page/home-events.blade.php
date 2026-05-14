<div class="container  scroll-fade-in mb-5 mt-5">

    {{-- HEADER ROW: Heading on Left, Button on Right --}}
    <div class="row align-items-center mb-4">

        {{-- Left Side: Heading --}}
        <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
            <h3 class="modern-accent-heading mb-0">LATEST EVENTS</h3>
        </div>

        {{-- Right Side: Button --}}
        <div class="col-12 col-md-6 text-center text-md-end">
            <a class="btn btn-theme-dark px-4 py-2 shadow-sm rounded-pill fw-bold text-uppercase"
                href="{{ route('events') }}" style="letter-spacing: 1px; font-size: 0.9rem;">
                <i class="fas fa-calendar-alt pe-2"></i> View All 
            </a>
        </div>

    </div>

    {{-- THE ENVELOPE FRAME --}}
    <div class="border border-2 rounded-4 p-4 p-md-5 shadow-sm bg-white position-relative">

        <div class="row g-4">

            @foreach($latestEvents as $event)
                <div class="col-md-4 col-sm-6 scroll-fade-in">
                    <a href="{{ route('events.events-desc', $event->id) }}" class="text-decoration-none">

                        <div class="card event-card shadow-soft border-0 h-100 rounded-3">

                            <div class="position-relative overflow-hidden rounded-top-3" style="height: 250px;">

                                @php
                                    $thumbnail = null;
                                    $isVideo = false;

                                    if (!empty($event->images) && is_array($event->images)) {
                                        // 1. Search specifically for an IMAGE first
                                        foreach ($event->images as $media) {
                                            if (preg_match('/\.(jpg|jpeg|png|gif|svg|webp|avif)$/i', $media)) {
                                                $thumbnail = $media;
                                                break;
                                            }
                                        }

                                        // 2. If no image exists, grab the first VIDEO as a fallback
                                        if (!$thumbnail) {
                                            foreach ($event->images as $media) {
                                                if (preg_match('/\.(mp4|mov|avi|webm|ogg)$/i', $media)) {
                                                    $thumbnail = $media;
                                                    $isVideo = true;
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                @endphp

                                @if($thumbnail && !$isVideo)
                                    <img src="{{ asset('storage/' . $thumbnail) }}" class="card-img-top w-100 h-100"
                                        style="object-fit: cover;" alt="{{ $event->title }}">

                                @elseif($thumbnail && $isVideo)
                                    <video src="{{ asset('storage/' . $thumbnail) }}" class="card-img-top w-100 h-100"
                                        style="object-fit: cover;" muted playsinline></video>
                                    <span class="badge bg-danger position-absolute shadow-sm"
                                        style="top: 10px; right: 10px; z-index: 10; font-size: 0.75rem;"><i
                                            class="bi bi-play-fill"></i> VIDEO</span>

                                @else
                                    <img src="{{ asset('images/default-placeholder.png') }}" class="card-img-top w-100 h-100"
                                        style="object-fit: cover;">
                                @endif

                                <div class="card-img-overlay d-flex align-items-end p-0">
                                    <div class="bg-dark bg-opacity-50 text-white w-100 p-2">
                                        <small
                                            class="text-uppercase">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</small>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body bg-white text-center rounded-bottom-3">
                                <h6 class="card-title text-dark fw-bold mb-0">"{{ strtoupper($event->title) }}"</h6>
                            </div>

                        </div>
                    </a>
                </div>
            @endforeach

        </div>

    </div> {{-- End of the Envelope Frame --}}

</div>