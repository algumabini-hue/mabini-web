@include('layout.page-header', [
    'title' => 'Events and Activities of the Sangguniang Bayan',
    'bgImage' => 'images/body.png'
])

<div class="container-fluid px-4 px-xl-5 scroll-fade-in mb-5 mt-5">

    

    {{-- THE FRAMED WRAPPER --}}
    <div class="event-watermark-wrapper border border-2 rounded-4 p-4 p-md-5 bg-white shadow-sm position-relative">

        {{-- EVENT-SPECIFIC SEARCH BAR --}}
        <div class="row position-relative z-1 mb-5 justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">

                {{-- Using generic IDs so your ajax.js can handle both pages easily --}}
                <form id="ajax-search-form" action="{{ url()->current() }}" method="GET"
                    class="shadow-sm rounded-pill overflow-hidden border border-2 d-flex align-items-center">

                    {{-- Hidden inputs keep the dropdown filters active --}}
                    @if(request('year')) <input type="hidden" name="year" value="{{ request('year') }}"> @endif
                    @if(request('month')) <input type="hidden" name="month" value="{{ request('month') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                    <input type="search" name="search" class="form-control border-0 px-4 py-2 fs-6 shadow-none"
                        placeholder="Search specific events by title or keyword..." value="{{ request('search') }}"
                        aria-label="Search Events">

                    <button class="btn btn-success px-4 fw-bold text-uppercase fs-6 rounded-0 h-100" type="submit"
                        style="letter-spacing: 1px;">
                        <i class="fas fa-search pe-2"></i> Search
                    </button>

                </form>

                {{-- THE LOADING CIRCLE --}}
                <div id="search-loading" class="mt-4 d-none text-center">
                    <div class="spinner-border text-success shadow-sm" style="width: 2.5rem; height: 2.5rem;"
                        role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-success fw-bold mt-2 text-uppercase"
                        style="font-size: 0.8rem; letter-spacing: 2px;">
                        Searching...
                    </div>
                </div>

            </div>
        </div>

        {{-- Visual Divider --}}
        <hr class="position-relative z-1 text-muted mb-5 opacity-25">

        {{-- The Filter Form --}}
        <div class="position-relative z-1 mb-4">
            @include('layout.filter')
        </div>

        {{-- RESULTS CONTAINER --}}
        <div id="ajax-results-container" style="transition: opacity 0.3s ease;">

            {{-- The Grid of Cards --}}
            <div class="row g-4 position-relative z-1">
                @foreach($events as $event)
                    <div class="col-md-4 col-sm-6 scroll-fade-in">
                        <a href="{{ route('events.events-desc', $event->id) }}" class="text-decoration-none">
                            <div class="card event-card shadow-soft border-0 h-100">
                                <div class="position-relative overflow-hidden" style="height: 250px;">

                                    @php
    $thumbnail = null;
    $isVideo = false;

    if (!empty($event->images) && is_array($event->images)) {
        foreach ($event->images as $media) {
            if (preg_match('/\.(jpg|jpeg|png|gif|svg|webp|avif)$/i', $media)) {
                $thumbnail = $media;
                break;
            }
        }
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
                                        <img src="{{ asset('images/default-placeholder.png') }}"
                                            class="card-img-top w-100 h-100" style="object-fit: cover;">
                                    @endif

                                    <div class="card-img-overlay d-flex align-items-end p-0">
                                        <div class="bg-dark bg-opacity-50 text-white w-100 p-2">
                                            <small
                                                class="text-uppercase">{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</small>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-body bg-white text-center">
                                    <h6 class="card-title text-dark fw-bold mb-0">"{{ strtoupper($event->title) }}"</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- The Pagination Links (Added appends to keep search queries in URL) --}}
            <div class="d-flex justify-content-center mt-5 mb-4 scroll-fade-in">
                {{ $events->appends(request()->query())->links() }}
            </div>

        </div> {{-- End of ajax-results-container --}}

    </div> {{-- End of Framed Wrapper --}}
</div>