@extends('layout.master')

@section('events')

    <header class="custom-hero-section scroll-fade-in" style="background-image: url('{{ asset('images/search.jpg') }}');">
        <div class="custom-hero-overlay"></div>
        <div class="container custom-hero-content">
            <div class="row justify-content-center text-center">
                <div class="col-12 col-md-10 col-lg-10 py-5">

                    

                </div>
            </div>
        </div>
    </header>

        <div class="container mt-5 pb-5 scroll-fade-in">



            <div class="mb-5">
                <h2 class="text-uppercase tracking-widest text-secondary">Search Results</h2>
                <p class="lead">Showing results for: <span class="fw-bold text-dark">"{{ $searchTerm }}"</span></p>
            </div>

            @if(!empty($staticPagesFound))
                <h4 class="fw-bold mb-3 border-bottom pb-2">Pages Found ({{ count($staticPagesFound) }})</h4>
                <div class="list-group mb-5 shadow-sm">
                    @foreach($staticPagesFound as $page)
                        <a href="{{ $page['route'] }}" class="list-group-item list-group-item-action p-4 border-0 mb-1">
                            <div class="d-flex w-100 align-items-center">
                                <div class="me-4">
                                    <i class="bi {{ $page['icon'] }} text-success" style="font-size: 2.5rem;"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 fw-bold text-dark text-uppercase">{{ $page['title'] }}</h5>
                                    <p class="mb-0 text-muted" style="font-size: 0.95rem;">
                                        {{ $page['description'] }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($officials->isNotEmpty())
                <h4 class="fw-bold mb-3 border-bottom pb-2">Officials Found ({{ $officials->count() }})</h4>
                <div class="row g-4 mb-5">
                    @foreach($officials as $official)
                        <div class="col-md-4 col-sm-6">
                            <a href="#" class="text-decoration-none">
                                <div class="card shadow-sm h-100 border-0 event-card">
                                    <div class="card-body bg-white text-center p-4">
                                        <div class="mb-3">
                                            <i class="bi bi-person-circle text-secondary" style="font-size: 3rem;"></i>
                                        </div>
                                        <h5 class="card-title text-dark fw-bold mb-1 text-uppercase">{{ $official->name }}</h5>
                                        <p class="text-success fw-bold mb-1" style="font-size: 0.9rem;">{{ $official->position }}</p>
                                        @if($official->department)
                                            <small class="text-muted">{{ $official->department }}</small>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($ordinances->isNotEmpty())
                <h4 class="fw-bold mb-3 border-bottom pb-2">Ordinances Found ({{ $ordinances->count() }})</h4>
                <div class="list-group mb-5 shadow-sm">
                    @foreach($ordinances as $ordinance)
                        <a href="{{ route('ordinances.show', $ordinance->id) }}"
                            class="list-group-item list-group-item-action p-4 border-0 mb-1">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1 fw-bold text-dark">{{ $ordinance->subject }}</h5>
                                    <p class="mb-0 text-muted" style="font-size: 0.9rem;">
                                        {{ Str::limit($ordinance->description, 100) }}
                                    </p>
                                </div>
                                <small class="text-muted fw-bold ms-3" style="min-width: 100px; text-align: right;">
                                    {{ \Carbon\Carbon::parse($ordinance->date_implemented)->format('M d, Y') }}
                                </small>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            @if($events->isNotEmpty())
                <h4 class="fw-bold mb-3 border-bottom pb-2">Events Found ({{ $events->count() }})</h4>
                <div class="row g-4 mb-5">
                    @foreach($events as $event)
                        <div class="col-md-4 col-sm-6">
                            <a href="{{ route('events.events-desc', $event->id) }}" class="text-decoration-none">
                                <div class="card shadow-sm h-100 border-0 event-card">
                                    <div class="card-body bg-white text-center p-4">
                                        <small class="text-muted d-block mb-2"
                                            style="font-family: 'Courier New', Courier, monospace; font-weight: bold;">
                                            <i
                                                class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                                        </small>
                                        <h6 class="card-title text-dark fw-bold mb-0 text-uppercase">"{{ $event->title }}"</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($ordinances->isEmpty() && $events->isEmpty() && $officials->isEmpty() && empty($staticPagesFound))
                <div class="text-center py-5 mt-5 bg-white shadow-sm rounded border">
                    <i class="bi bi-search display-1 text-muted mb-3 opacity-25"></i>
                    <h3 class="text-muted fw-bold">No results found</h3>
                    <p class="text-muted mb-4">We couldn't find any Pages, Officials, Ordinances, or Events matching <span
                            class="text-dark fw-bold">"{{ $searchTerm }}"</span>.</p>
                    <a href="{{ route('home') }}" class="btn btn-dark px-4 py-2 rounded-pill fw-bold">Return to Home</a>
                </div>
            @endif

        </div>
@endsection