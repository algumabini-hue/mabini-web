<div class="container scroll-fade-in mb-5">

    {{-- HEADER ROW: Heading on Left, Button on Right --}}
    <div class="row align-items-center mb-4">

        {{-- LEFT COLUMN: The Heading --}}
        <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
            <h3 class="modern-accent-heading mb-0">Latest Ordinances</h3>
        </div>

        {{-- RIGHT COLUMN: The Button --}}
        <div class="col-12 col-md-6 text-center text-md-end scroll-fade-in">
            <a class="btn btn-theme-dark px-4 py-2 shadow-sm rounded-pill fw-bold text-uppercase"
                style="letter-spacing: 1px; font-size: 0.9rem;" href="{{ route('ordinances') }}">
                <i class="fas fa-file-contract pe-2"></i> View All
            </a>
        </div>

    </div>

    {{-- THE FRAMED WRAPPER: Added border, rounded corners, and a white background --}}
    <div class="ordinance-watermark-wrapper border border-2 rounded-4 p-4 p-md-5 bg-white shadow-sm">

        <div class="row position-relative z-1">
            @foreach($ordinances as $ordinance)
                <div class="col-12 col-md-6 col-lg-6 mb-4 scroll-fade-in">

                    {{-- 1. ADJUST HEIGHT HERE: Changed from 300px to 220px (Tweak this number as you like!) --}}
                    <div class="card ordinance-card shadow-soft p-4 position-relative hover-lift scroll-fade-in"
                        style="height: 220px;">

                        <div class="card-body p-0 mt-3 d-flex flex-column h-100">

                            <a href="{{ route('ordinances.show', $ordinance->id) }}"
                                class="stretched-link text-decoration-none text-dark">

                                {{-- DATE IMPLEMENTED --}}
                                <div class="ord-header fs-6 text-muted mb-3 text-uppercase"
                                    style="letter-spacing: 1px; font-size: 0.85rem;">
                                    <i class="far fa-calendar-alt pe-1"></i>
                                    {{ $ordinance->date_implemented ? \Carbon\Carbon::parse($ordinance->date_implemented)->format('F d, Y') : 'Date Not Specified' }}
                                </div>

                                {{-- SUBJECT --}}
                                {{-- 2. ADJUST LINE CLAMP HERE: Lowered from 7 to 4 to match the shorter card --}}
                                <div class="ord-body text-uppercase fs-5 fw-bold mb-0 scroll-fade-in text-dark"
                                    style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $ordinance->subject }}
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</div>