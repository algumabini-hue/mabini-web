
@include('layout.page-header', [
    'title' => 'Official Ordinances<br>Municipality of Mabini',
    'bgImage' => 'images/ordinances.jpg'
])

<div class="container-fluid px-4 px-xl-5 scroll-fade-in mb-5 mt-5">

    

    {{-- THE FRAMED WRAPPER --}}
    <div class="ordinance-watermark-wrapper border border-2 rounded-4 p-4 p-md-5 bg-white shadow-sm position-relative">

        {{-- ORDINANCE-SPECIFIC SEARCH BAR --}}
        <div class="row position-relative z-1 mb-5 justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">

                {{-- 1. ADDED ID: "ordinance-search-form" --}}
                <form id="ajax-search-form" action="{{ url()->current() }}" method="GET"
                    class="shadow-sm rounded-pill overflow-hidden border border-2 d-flex align-items-center">

                    {{-- Hidden inputs keep the dropdown filters active --}}
                    @if(request('year')) <input type="hidden" name="year" value="{{ request('year') }}"> @endif
                    @if(request('month')) <input type="hidden" name="month" value="{{ request('month') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                    <input type="search" name="search" class="form-control border-0 px-4 py-2 fs-6 shadow-none"
                        placeholder="Search specific ordinances by subject or keyword..."
                        value="{{ request('search') }}" aria-label="Search Ordinances">

                    <button class="btn btn-success px-4 fw-bold text-uppercase fs-6 rounded-0 h-100" type="submit"
                        style="letter-spacing: 1px;">
                        <i class="fas fa-search pe-2"></i> Search
                    </button>

                </form>

                {{-- 2. NEW: THE LOADING PROGRESS BAR (Hidden by default) --}}
                <div id="search-loading" class="mt-4 d-none text-center">
                    <div class="spinner-border text-success shadow-sm" style="width: 2.5rem; height: 2.5rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="text-success fw-bold mt-2 text-uppercase" style="font-size: 0.8rem; letter-spacing: 2px;">
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

        {{-- 3. ADDED WRAPPER ID: "ordinance-results-container" --}}
        <div id="ajax-results-container" style="transition: opacity 0.3s ease;">

            {{-- The Grid of Cards --}}
            <div class="row position-relative z-1">

                @foreach($ordinances as $ordinance)
                    <div class="col-12 col-md-6 col-lg-6 mb-4 scroll-fade-in">
                        {{-- Kept fixed 300px height --}}
                        <div class="card ordinance-card shadow-soft p-4 position-relative hover-lift scroll-fade-in"
                            style="height: 300px;">
                            <div class="card-body p-0 mt-3 d-flex flex-column h-100">

                                {{-- THE MAGIC LINK --}}
                                <a href="{{ route('ordinances.show', $ordinance->id) }}"
                                    class="stretched-link text-decoration-none text-dark">

                                    {{-- DATE IMPLEMENTED --}}
                                    <div class="ord-header fs-6 text-muted mb-3 text-uppercase"
                                        style="letter-spacing: 1px; font-size: 0.85rem;">
                                        <i class="far fa-calendar-alt pe-1"></i>
                                        {{ $ordinance->date_implemented ? \Carbon\Carbon::parse($ordinance->date_implemented)->format('F d, Y') : 'Date Not Specified' }}
                                    </div>

                                    {{-- SUBJECT --}}
                                    {{-- CHANGED: Increased line-clamp to 7 to fill the empty space! --}}
                                    <div class="ord-body text-uppercase fs-5 fw-bold mb-0 scroll-fade-in text-dark"
                                        style="display: -webkit-box; -webkit-line-clamp: 7; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $ordinance->subject }}
                                    </div>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- The Pagination Links (Moved inside the results container so it updates via AJAX too!) --}}
            <div class="d-flex justify-content-center mt-5 mb-4 scroll-fade-in">
                {{ $ordinances->appends(request()->query())->links() }}
            </div>

        </div> {{-- End of ordinance-results-container --}}

    </div> {{-- End of Framed Wrapper --}}

</div>

