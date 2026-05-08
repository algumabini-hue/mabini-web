@extends('layout.layout-admin')
@section('event-description')
    <div class="container mt-5 pb-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Gallery</a></li>
                <li class="breadcrumb-item active">{{ $event->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-12 mb-4">
                <h1 class="display-5 fw-bold text-uppercase">{{ $event->title }}</h1>
                <p class="text-muted"><i class="bi bi-calendar-event"></i>
                    {{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}</p>
                <hr>
                <p class="lead" style="white-space: pre-line;">{{ $event->caption }}</p>
            </div>

            <div class="col-12">
                <h4 class="mb-3 text-secondary">Event Photos</h4>
                <div class="row g-3">
                    @if(!empty($event->images))
                        @foreach($event->images as $image)
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm overflow-hidden">
                                    <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded" alt="Event Photo"
                                        style="width: 100%; height: 400px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection