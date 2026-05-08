@extends('layout.layout-admin')
@section('ord-uploaded')


    <section class="p-2 overflow-hidden" id="">
        {{-- Alerts for Success/Error --}}

        @include('admin.alert-message')

        @include('admin.admin-filter')
        <div class="row mt-4">

            <div class="mb-4 mt-4 text-center scroll-fade-in">
                <a href="{{ route('admin.ordinances.ord-upload') }}" class="btn btn-outline-dark shadow-sm px-4 fw-bold ">
                    <i class="fas fa-file-lines pe-3"></i> Go to Upload Page
                </a>
            </div>



            @foreach($ordinances as $ordinance)
                <div class="col-12 col-md-6 col-lg-4 mb-4 scroll-fade-in"> {{-- Added mb-4 for spacing --}}

                    {{-- Added position-relative so the stretched-link stays contained within the card --}}
                    <div class="card ordinance-card shadow-soft h-100 p-4 position-relative hover-lift scroll-fade-in">

                        

                        {{-- Added d-flex and flex-column so the mt-auto on the footer pushes it perfectly to the bottom --}}
                        <div class="card-body p-0 mt-4 d-flex flex-column">

                            {{-- THE MAGIC LINK --}}
                            <a href="{{ route('admin.ordinances.show', $ordinance->id) }}"
                                class="stretched-link text-decoration-none text-dark">

                                {{-- DATE IMPLEMENTED --}}
                                <div class="ord-header fs-6 text-muted mb-2 text-uppercase"
                                    style="letter-spacing: 1px; font-size: 0.85rem;">
                                    <i class="far fa-calendar-alt pe-1"></i>
                                    {{ $ordinance->date_implemented ? \Carbon\Carbon::parse($ordinance->date_implemented)->format('F d, Y') : 'Date Not Specified' }}
                                </div>

                                {{-- SUBJECT (In Bold) --}}
                                <div class="ord-body fs-5 fw-bold mb-3 scroll-fade-in text-dark">
                                    {{ $ordinance->subject }}
                                </div>
                            </a>

                            {{-- DESCRIPTION FOOTER --}}
                            <div class="ord-footer text-uppercase fs-6 mt-auto pt-3 border-top scroll-fade-in text-secondary">
                                {{-- Limit characters on the card so it doesn't get too tall --}}
                                {{ \Illuminate\Support\Str::limit($ordinance->description, 100) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- The Pagination Links --}}
        <div class="d-flex justify-content-center mt-5 mb-4">
            {{-- appends(request()->query()) tells Laravel to carry over the ?year=x&month=y to the next page --}}
            {{ $ordinances->appends(request()->query())->links() }}
        </div>

    </section>

@endsection