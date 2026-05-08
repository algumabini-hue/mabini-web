@extends('adminlayout.adminpanellayout')
@section('adminpanel-content')

<section class="ordinance-section px-3 px-md-0">
    <div class="container-fluid container-md px-2 px-md-0 py-3 py-md-5">
        {{-- Page Header --}}
        <div class="mb-3 mb-md-5 text-center">
            <div class="col-md-12 ordinance-title">
                <h1 class="fw-bold text-dark mb-2 mb-md-2"
                    style="letter-spacing: 2px; font-size: clamp(1.25rem, 5vw, 2.5rem);">
                    <i class="fas fa-scroll pe-2 mt-3"></i>ORDINANCES
                </h1>
                <p class="text-secondary fs-6 fs-md-5">Browse all municipal ordinances and resolutions</p>
            </div>
            {{-- Admin Navigation Buttons --}}
            @auth
            <div class="mt-3 mt-md-4 d-flex gap-2 justify-content-center flex-column flex-sm-row flex-wrap">
                <a href="{{ route('ord-upload') }}" class="btn btn-success fw-bold px-3 px-md-4 py-2 shadow-sm"
                    data-uid="true">
                    <i class="fas fa-plus pe-2"></i><span class="d-none d-sm-inline">Upload New</span><span
                        class="d-sm-none">Upload</span>
                </a>
                <a href="{{ route('ord-uploaded') }}" class="btn btn-primary fw-bold px-3 px-md-4 py-2 shadow-sm"
                    data-uid="true">
                    <i class="fas fa-list pe-2"></i><span class="d-none d-sm-inline">Manage</span><span
                        class="d-sm-none">List</span>
                </a>
            </div>
            @endauth

            {{-- Filter Section --}}
            @include('admin.filteradmin')

            {{-- Ordinances Grid --}}
            <div class="row mt-4">
                @forelse($ordinances as $ordinance)
                <div class="col-12 col-md-6 col-lg-4 mb-4 scroll-fade-in">
                    {{-- Ordinance Card --}}
                    <div class="card ordinance-card shadow-soft h-100 p-4 position-relative hover-lift">
                        <div class="card-body p-0 mt-4 d-flex flex-column">
                            {{-- Linked Title to View Details --}}
                            <a href="{{ route('ord-description', $ordinance->id) }}"
                                class="stretched-link text-decoration-none text-dark" data-uid="true">

                                {{-- DATE IMPLEMENTED --}}
                                <div class="ord-header fs-6 text-muted mb-2 text-uppercase"
                                    style="letter-spacing: 1px; font-size: 0.85rem;">
                                    <i class="far fa-calendar-alt pe-1"></i>
                                    {{ $ordinance->date_implemented ?
                                    \Carbon\Carbon::parse($ordinance->date_implemented)->format('F d, Y') : 'Date Not
                                    Specified' }}
                                </div>

                                {{-- SUBJECT (Bold Title) --}}
                                <div class="ord-body fs-5 fw-bold mb-3 scroll-fade-in text-dark">
                                    {{ $ordinance->subject }}
                                </div>
                            </a>

                            {{-- DESCRIPTION FOOTER --}}
                            <div
                                class="ord-footer text-uppercase fs-6 mt-auto pt-3 border-top scroll-fade-in text-secondary">
                                {{ \Illuminate\Support\Str::limit($ordinance->description, 100) }}
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle pe-2"></i>
                        <strong>No ordinances available yet.</strong> Please check back later.
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-5 mb-4">
                {{ $ordinances->appends(request()->query())->links() }}
            </div>
        </div>
</section>

@endsection
