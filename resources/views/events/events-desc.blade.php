@extends('layout.master')
@section('events')

            @php
    $videoExtensions = ['mp4', 'mov', 'avi', 'webm', 'ogg'];
    $photos = [];
    $videos = [];

    if (!empty($event->images)) {
        foreach ($event->images as $media) {
            $ext = strtolower(pathinfo($media, PATHINFO_EXTENSION));
            if (in_array($ext, $videoExtensions)) {
                $videos[] = $media;
            } else {
                $photos[] = $media;
            }
        }
    }
            @endphp

                @include('layout.custom-header', [
                    'title' => '',
                    'bgImage' => 'images/gallery-cover.jpg'
                ])

            <div class="container-fluid px-4 px-xl-5 scroll-fade-in mb-5 mt-5">

                {{-- THE FRAMED WRAPPER: Replaces desc-white-box and adds watermark --}}
                <div class="event-watermark-wrapper border border-2 rounded-4 p-4 p-md-5 bg-white shadow-sm position-relative">

                    {{-- Z-index wrapper keeps content above the watermark --}}
                    <div class="position-relative z-1">

                        <div class="custom-path mb-5 text-uppercase">
                            <a href="{{ route('events') }}" class="path-link"><i class="bi bi-arrow-left me-2"></i>Gallery</a>
                            <span class="path-separator">/</span>
                            <span class="path-current">{{ $event->title }}</span>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-10 col-lg-8">
                                <h1 class="display-4 fw-bolder text-uppercase mb-3" style="letter-spacing: 2px;">
                                    {{ $event->title }}
                                </h1>
                                <p class="desc-date mb-4">
                                    <i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::parse($event->date)->format('F d, Y') }}
                                </p>

                                <hr class="divider-custom mb-4">

                                <p class="lead desc-caption" style="white-space: pre-line;">{{ $event->caption }}</p>
                            </div>
                        </div>

                        @if(count($photos) > 0)
                            <div class="row mb-5">
                                <div class="col-12">
                                    <h4 class="mb-4 text-uppercase fw-bold" style="letter-spacing: 1.5px; color: #555;">
                                        Event Photos
                                    </h4>
                                    <div class="row g-4">
                                        @foreach($photos as $image)
                                            <div class="col-md-6 scroll-fade-in">
                                                <div class="event-card shadow-soft w-100 lightbox-trigger"
                                                    onclick="openLightbox('{{ asset('storage/' . $image) }}')">
                                                    <img src="{{ asset('storage/' . $image) }}" class="desc-img w-100" alt="Event Photo">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(count($videos) > 0)
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h4 class="mb-4 text-uppercase fw-bold" style="letter-spacing: 1.5px; color: #555;">
                                        Event Videos
                                    </h4>
                                    <div class="row g-4">
                                        @foreach($videos as $video)
                                            <div class="col-md-6 scroll-fade-in">
                                                <div class="event-card shadow-soft w-100 p-2 bg-white border-0" style="border-radius: 8px;">
                                                    <video class="w-100" controls style="border-radius: 4px; background-color: #000;">
                                                        <source src="{{ asset('storage/' . $video) }}"
                                                            type="video/{{ pathinfo($video, PATHINFO_EXTENSION) }}">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div> {{-- End Z-1 Wrapper --}}

                </div> {{-- End of Framed Wrapper --}}

            </div>

            {{-- LIGHTBOX MODAL --}}
            <div class="modal fade" id="imageLightbox" tabindex="-1" aria-hidden="true">
                <button type="button" class="lightbox-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                    </svg>
                </button>

                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content bg-transparent border-0">
                        <div class="modal-body p-0 text-center position-relative">
                            <img id="lightboxMainImage" src="" class="img-fluid"
                                style="max-height: 90vh; object-fit: contain; box-shadow: 0 10px 40px rgba(0,0,0,0.8);">
                        </div>
                    </div>
                </div>
            </div>
@endsection