@extends('layout.layout-admin')
@section('event-upload')
    <div class="container event-grid-container mt-5">
        <h2 class="text-center mb-4 uppercase tracking-widest">Municipality Events Gallery</h2>

        <div class="row g-4">
            @foreach($events as $event)
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('events.show', $event->id) }}" class="text-decoration-none">
                        <div class="card event-card shadow-soft border-0 h-100">
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                @if(!empty($event->images) && count($event->images) > 0)
                                    <img src="{{ asset('storage/' . $event->images[0]) }}" class="card-img-top w-100 h-100"
                                        style="object-fit: cover;" alt="{{ $event->title }}">
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
                            <div class="card-body bg-white text-center">
                                <h5 class="card-title text-dark fw-bold mb-0">"{{ strtoupper($event->title) }}"</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection