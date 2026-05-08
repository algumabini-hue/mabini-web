

    <div class="container-fluid px-4 px-xl-5 scroll-fade-in mb-5 mt-5">

        {{-- THE FRAMED WRAPPER --}}
        

            <div class="position-relative z-1">

                <div class="row mb-5 text-center">
                    <div class="col-12">
                        <h2 class="fw-bolder text-uppercase mb-3" style="letter-spacing: 2px;">
                            A Journey Through Time
                        </h2>
                        <hr class="divider-custom mx-auto mb-4">
                        <p class="lead text-muted">Explore the rich heritage and origins of our beloved municipality.</p>
                    </div>
                </div>

                {{-- THE DYNAMIC GRID --}}
                <div class="row g-4">
                    @foreach($historyItems as $index => $item)
                      <div class="col-12 col-md-6 col-lg-4 scroll-fade-in">
                          <div class="card event-card shadow-soft h-100 border-0 rounded-3 overflow-hidden hover-lift">

                              {{-- IMAGE WITH LIGHTBOX TRIGGER --}}
                              <div class="position-relative overflow-hidden lightbox-trigger"
                                  style="height: 250px;"
                                  onclick="openHistoryLightbox({{ $index }})">

                                  {{-- Hover zoom effect image --}}
                                  <img src="{{ asset($item['image']) }}" class="desc-img w-100 h-100" style="object-fit: cover;" alt="{{ $item['title'] }}">

                                  {{-- Small overlay icon indicating it can be expanded --}}
                                  <div class="position-absolute top-0 end-0 m-2 bg-dark bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                      <i class="fas fa-expand text-white"></i>
                                  </div>
                              </div>

                              {{-- TEXT CONTENT --}}
                              <div class="card-body bg-white text-center p-4">
                                  <h5 class="fw-bold text-uppercase mb-3 text-dark" style="letter-spacing: 1px;">{{ $item['title'] }}</h5>
                                  <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.6;">
                                      {{ $item['description'] }}
                                  </p>
                              </div>

                          </div>
                      </div>
                    @endforeach
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

        {{-- Prev and Next Navigation Buttons --}}
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
        const galleryImages = @json($lightboxImages);
        let currentImageIndex = 0;
        let lightboxModalInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('imageLightbox');
            if(modalEl) {
                document.body.appendChild(modalEl); // Fixes stacking issues
            }
            lightboxModalInstance = new bootstrap.Modal(modalEl);
        });

        function openHistoryLightbox(index) {
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

            if (galleryImages.length > 1) {
                prevBtn.style.display = 'flex';
                nextBtn.style.display = 'flex';
            } else {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
            }
        }
    </script>

    {{-- CSS for Lightbox and Cards --}}
    <style>
        .divider-custom {
            border-top: 3px solid #198754; /* Bootstrap Success Green */
            opacity: 1;
            width: 80px;
        }

        .desc-img {
            transition: transform 0.4s ease;
        }

        .lightbox-trigger {
            cursor: zoom-in;
        }

        .lightbox-trigger:hover .desc-img {
            transform: scale(1.05); /* Smooth zoom on hover */
        }

        .modal-backdrop.show {
            opacity: 0.9 !important;
            background-color: #000 !important;
            z-index: 9999 !important;
        }
        
        .modal {
            z-index: 10000 !important;
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
            z-index: 10005 !important;
            transition: all 0.3s ease;
        }

        .lightbox-btn:hover {
            background-color: rgba(255, 255, 255, 0.3);
            border-color: #ffffff;
            transform: scale(1.1);
        }

        .lightbox-close-btn { top: 25px; right: 30px; }
        .lightbox-close-btn:hover { background-color: #e74c3c; border-color: #e74c3c; }

        .lightbox-nav-btn { top: 50%; transform: translateY(-50%); }
        .lightbox-nav-btn:hover { transform: translateY(-50%) scale(1.1); }

        .lightbox-prev { left: 30px; }
        .lightbox-next { right: 30px; }

        @media(max-width: 768px) {
            .lightbox-prev { left: 10px; }
            .lightbox-next { right: 10px; }
            .lightbox-close-btn { top: 15px; right: 15px; }
        }
    </style>
