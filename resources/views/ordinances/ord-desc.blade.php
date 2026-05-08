@extends('layout.master')
@section('ordinances')

        {{-- 1. Gather all image attachments into a clean array for our Lightbox Gallery --}}
        @php
    $imageAttachments = [];
    if (!empty($ordinance->attachments)) {
        foreach ($ordinance->attachments as $attachment) {
            $ext = strtolower(pathinfo($attachment['original_name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                $imageAttachments[] = asset('storage/' . $attachment['file_path']);
            }
        }
    }
    $lightboxIndex = 0; // We'll use this to keep track of which image is which
        @endphp

        @include('layout.custom-header', [
        'title' => '',
        'bgImage' => 'images/ordinance.jpg'
    ])

        <div class="container-fluid py-5 px-md-5 min-vh-100 ordinance-typography">
            <div class="row justify-content-center ">
                <div class="col-12 col-xl-10"> {{-- Restrained width slightly for better reading focus --}}

                    <div class="mb-4 text-start">
                        {{--
                            1. Checks if the previous URL is different from the current page (prevents refresh loops).
                            2. If they came from a search, it sends them back to the exact search results.
                            3. If they opened a bookmark/new tab, it defaults to route('ordinances').
                        --}}
                        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('ordinances') }}"
                            class="btn btn-outline-dark shadow-sm px-4 fw-bold">
                            <i class="fa-solid fa-arrow-left me-2"></i> Back
                        </a>
                    </div>

                    <div class="ordinance-document mb-5 p-4 p-md-5 shadow-soft rounded bg-white">

                        <div class="container-fluid d-flex align-items-center justify-content-center mb-5 px-3">

                            {{-- The Left Logo (Bayan ng Mabini) --}}
                            <img src="{{ asset('/images/logo.png') }}" alt="Bayan ng Mabini Logo" class="img-fluid me-3 me-md-5 shrink-0"
                                style="width: 140px; height: 140px; object-fit: contain;">

                            {{-- The Text Block --}}
                            <div class="d-flex flex-column text-center committee-header">
                                <span>COMMITTEE ON JUSTICE HUMAN RIGHTS,</span>
                                <span>LAWS AND ORDINANCES</span>
                            </div>

                            {{-- The Right Logo (Sangguniang Bayan) --}}
                            <img src="{{ asset('/images/sb.png') }}" alt="Sangguniang Bayan Logo" class="img-fluid ms-3 ms-md-5 shrink-0"
                                style="width: 140px; height: 140px; object-fit: contain; transform: scale(1.11);">

                        </div>

                        <div class="ordinance-content">

                            {{-- DATE IMPLEMENTED (Top Right) --}}
                            <div class="text-end mb-4 mb-md-5 fw-bold text-uppercase" style="font-size: clamp(0.9rem, 3vw, 1.1rem); letter-spacing: 1px;">
                                {{ $ordinance->date_implemented ? \Carbon\Carbon::parse($ordinance->date_implemented)->format('F d, Y') : 'DATE NOT SPECIFIED' }}
                            </div>

                            {{-- SUBJECT --}}
                            @if(!empty($ordinance->subject))
                                <div class="mb-5">
                                    <h5 class="fw-bold text-uppercase mb-2 text-secondary" style="letter-spacing: 1px;">SUBJECT:</h5>
                                    <p class="ordinance-title text-uppercase ps-md-4 mb-0 fw-bold fs-5" style="border-left: 4px solid #198754;">
                                        {!! nl2br(e($ordinance->subject)) !!}
                                    </p>
                                </div>
                            @endif

                            {{-- SCANNED DOCUMENT VIEWER --}}
                            @if(!empty($ordinance->attachments))
                                <hr class="my-5 border-2 opacity-25">

                                <h5 class="fw-bold text-center mb-4 text-uppercase" style="letter-spacing: 2px;">
                                    <i class="fas fa-file-scan pe-2 text-success"></i> Scanned Document Pages
                                </h5>

                                {{-- The Gray "Desk" Background for the pages to sit on --}}
                                <div class="d-flex flex-column align-items-center gap-5 bg-light p-4 p-md-5 rounded-4" style="box-shadow: inset 0 4px 10px rgba(0,0,0,0.05);">

                                    @foreach($ordinance->attachments as $index => $attachment)
                                        @php
            $ext = strtolower(pathinfo($attachment['original_name'], PATHINFO_EXTENSION));
            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                        @endphp

                                        @if($isImage)
                                            {{-- 2. Pass the INDEX to the lightbox instead of the URL --}}
                                            <div class="document-page bg-white position-relative lightbox-trigger"
                                                style="width: 100%; max-width: 850px; min-height: 600px; border: 1px solid #d1d5db; box-shadow: 0 10px 25px rgba(0,0,0,0.15);"
                                                onclick="openOrdinanceLightbox({{ $lightboxIndex }})">

                                                <span class="badge bg-dark position-absolute top-0 start-0 m-2 shadow-sm">Page {{ $index + 1 }}</span>

                                                <img src="{{ asset('storage/' . $attachment['file_path']) }}"
                                                    alt="Document Page {{ $index + 1 }}"
                                                    class="w-100 h-100"
                                                    style="object-fit: contain;">
                                            </div>
                                            @php $lightboxIndex++; @endphp {{-- Increment index only for images --}}

                                        @elseif($ext === 'pdf')
                                            <div class="document-page bg-white position-relative"
                                                style="width: 100%; max-width: 850px; height: 1100px; border: 1px solid #d1d5db; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-2 shadow-sm z-1">PDF File</span>
                                                <iframe src="{{ asset('storage/' . $attachment['file_path']) }}" class="w-100 h-100 position-relative z-0" style="border: none;"></iframe>
                                            </div>
                                        @else
                                            <div class="alert alert-secondary w-100 text-center border-2 shadow-sm" style="max-width: 850px;">
                                                <i class="fas fa-file-word fa-3x mb-3 text-primary"></i>
                                                <h6 class="fw-bold">{{ $attachment['original_name'] }}</h6>
                                                <a href="{{ asset('storage/' . $attachment['file_path']) }}" class="btn btn-primary btn-sm mt-2 fw-bold" download>
                                                    <i class="fas fa-download pe-1"></i> Download Document
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- LIGHTBOX MODAL WITH NAVIGATION --}}
        <div class="modal fade" id="imageLightbox" tabindex="-1" aria-hidden="true">

            {{-- Close Button --}}
            <button type="button" class="lightbox-btn lightbox-close-btn" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times fs-5"></i>
            </button>

            {{-- Prev and Next Navigation Buttons (Hidden by default) --}}
            <button type="button" class="lightbox-btn lightbox-nav-btn lightbox-prev" id="lightboxPrevBtn" onclick="navigateLightbox(-1)" style="display: none;">
                <i class="fas fa-chevron-left fs-4"></i>
            </button>

            <button type="button" class="lightbox-btn lightbox-nav-btn lightbox-next" id="lightboxNextBtn" onclick="navigateLightbox(1)" style="display: none;">
                <i class="fas fa-chevron-right fs-4"></i>
            </button>

            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body p-0 text-center position-relative">
                        <img id="lightboxMainImage" src="" class="img-fluid"
                            style="max-height: 95vh; object-fit: contain; box-shadow: 0 0 80px rgba(0,0,0,1), 0 20px 50px rgba(0,0,0,0.9);">
                    </div>
                </div>
            </div>
        </div>

        {{-- Javascript for Lightbox Navigation --}}
    <script>
        // Using json_encode is safer for passing PHP arrays to JS
        const galleryImages = {!! json_encode($imageAttachments) !!};
        let currentImageIndex = 0;
        let lightboxModalInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            lightboxModalInstance = new bootstrap.Modal(document.getElementById('imageLightbox'));
        });

        
        function openOrdinanceLightbox(index) {
            currentImageIndex = index;
            updateLightboxView();
            lightboxModalInstance.show();
        }

        function navigateLightbox(direction) {
            currentImageIndex += direction;

            if (currentImageIndex < 0) {
                currentImageIndex = galleryImages.length - 1; 
            } else if (currentImageIndex >= galleryImages.length) {
                currentImageIndex = 0; 
            } 

            updateLightboxView();
        }

        function updateLightboxView() {
            const lightboxImage = document.getElementById('lightboxMainImage');
            lightboxImage.src = galleryImages[currentImageIndex];

            const prevBtn = document.getElementById('lightboxPrevBtn');
            const nextBtn = document.getElementById('lightboxNextBtn');

            // Shows buttons only if there are 2 or more images
            if (galleryImages.length > 1) {
                prevBtn.style.display = 'flex';
                nextBtn.style.display = 'flex';
            } else {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
            }
        }
    </script>

        {{-- CSS for Lightbox Navigation --}}
        <style>
            .lightbox-trigger {
                cursor: zoom-in;
                transition: transform 0.3s ease;
            }

            .lightbox-trigger:hover {
                transform: scale(1.01);
            }

            .modal-backdrop.show {
                opacity: 0.9 !important;
                background-color: #000 !important;
            }

            /* --- Shared Lightbox Button Styles --- */
            .lightbox-btn {
                position: fixed;
                background: rgba(0, 0, 0, 0.5);
                color: #ffffff;
                border: 2px solid rgba(255, 255, 255, 0.5);
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                z-index: 1060;
                transition: all 0.3s ease;
            }

            .lightbox-btn:hover {
                background-color: rgba(255, 255, 255, 0.3);
                border-color: #ffffff;
                transform: scale(1.1);
            }

            /* Close Button Position */
            .lightbox-close-btn {
                top: 25px;
                right: 30px;
            }
            .lightbox-close-btn:hover {
                background-color: #e74c3c;
                border-color: #e74c3c;
            }

            /* Navigation Buttons Position */
            .lightbox-nav-btn {
                top: 50%;
                transform: translateY(-50%);
            }
            .lightbox-nav-btn:hover {
                transform: translateY(-50%) scale(1.1);
            }

            .lightbox-prev {
                left: 30px;
            }

            .lightbox-next {
                right: 30px;
            }

            /* Shift nav buttons closer to edges on mobile phones */
            @media(max-width: 768px) {
                .lightbox-prev { left: 10px; }
                .lightbox-next { right: 10px; }
                .lightbox-close-btn { top: 15px; right: 15px; }
            }
        </style>

@endsection