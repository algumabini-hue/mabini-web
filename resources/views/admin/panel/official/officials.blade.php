@extends('adminlayout.adminpanellayout')
@section('adminpanel-content')

    <div class="container-fluid px-2 px-sm-3 px-lg-5 py-3 py-sm-5">
        @include('admin.alert-message')

        {{-- The Main Form --}}
        <form action="{{ route('admin.officials.store') }}" method="POST" enctype="multipart/form-data" id="officialsForm">
            @csrf
            <div class="col-md-12 dashboard-title">
                <h1 class="display-4"><strong>OFFICIALS</strong></h1>
            </div>

            {{-- Top Header Bar --}}
            <div
                class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-4 mb-sm-5 border-bottom pb-3 border-2 border-primary">
            </div>

            {{-- The Org Chart Grid SK FEDERATION PRES. , ABC PRES, SB SEC--}}
            @php
    $positions = [
        'mayor' => 'Municipal Mayor',
        'vice_mayor' => 'Municipal Vice Mayor',
        'councilor_1' => 'Councilor 1',
        'councilor_2' => 'Councilor 2',
        'councilor_3' => 'Councilor 3',
        'councilor_4' => 'Councilor 4',
        'councilor_5' => 'Councilor 5',
        'councilor_6' => 'Councilor 6',
        'councilor_7' => 'Councilor 7',
        'councilor_8' => 'Councilor 8',
        'skf' => 'SKF President',
        'abc' => 'ABC President',
        'sbsec' => 'SB Secretary',
    ];
            @endphp

            <div class="row g-3 g-sm-4 g-lg-5 justify-content-center text-center">
                @foreach($positions as $key => $title)
                            @php
                    $official = $officials[$key] ?? null;
                    $photoPath = $official ? $official->photo_path : null;
                    $imageData = $official && $official->image ? $official->image : null;
                    $name = $official ? $official->name : null;
                            @endphp
                            <div class="col-12 col-sm-6 col-md-5 col-lg-4 col-xl-3">
                                {{-- Clickable Card that opens the Modal --}}
                                <div class="card border-primary border-2 shadow-sm official-card cursor-pointer h-100 position-relative"
                                    onclick="openOfficialModal('{{ $key }}', '{{ $title }}')"
                                    style="transition: 0.3s; cursor: pointer; border-style: {{ $official ? 'solid' : 'dashed' }};">

                                    {{-- Edit Badge (shown only if official exists) --}}
                                    @if($official)
                                    <div class="position-absolute top-0 inset-e-0 m-2">
                                        <span class="badge bg-success">Existing</span>
                                    </div>
                                    @endif

                                    <div class="card-body p-3 p-sm-4 d-flex flex-column">
                                        {{-- Image Preview Area --}}
                                        
                                            <img id="preview-img-{{ $key }}"
                                                src="{{ $photoPath ? asset($photoPath) : 'https://placehold.co/120x120/EFEFEF/666666?text=No\nPhoto' }}"
                                                alt="Photo for {{ $name ?? 'Official' }}" class="rounded-circle mb-3 border mx-auto d-block"
                                                style="width: 100px; height: 100px; max-width: 120px; object-fit: cover; display: block;" loading="lazy"
                                                onerror="this.onerror=null; this.src='https://placehold.co/120x120/EFEFEF/666666?text=No\nPhoto';">

                                        {{-- Name Preview Area --}}
                                        <div class="border rounded px-2 px-sm-3 py-2 mb-2 bg-light grow d-flex align-items-center justify-content-center"
                                            style="min-height: 40px;">
                                            <span id="preview-name-{{ $key }}" class="text-uppercase fw-bold text-center"
                                                style="font-size: 0.75rem; line-height: 1.2; {{ $name ? 'color: #333;' : 'color: #999;' }}">
                                                {{ $name ? $name : 'NAME' }}
                                            </span>
                                        </div>

                                        {{-- Position Label --}}
                                        <h6 class="fw-bold mb-0 text-uppercase text-center"
                                            style="letter-spacing: 1px; font-size: 0.85rem; line-height: 1.3;">
                                            {{ $title }}
                                        </h6>
                                    </div>
                                </div>

                                {{-- Hidden inputs to store the data for this specific position --}}
                                <input type="hidden" name="officials[{{ $key }}][name]" id="hidden-name-{{ $key }}"
                                    value="{{ $name ?? '' }}">
                                <input type="hidden" name="officials[{{ $key }}][position]" id="hidden-position-{{ $key }}"
                                    value="{{ $title }}">
                                <input type="hidden" name="officials[{{ $key }}][department]" id="hidden-dept-{{ $key }}"
                                    value="{{ $official ? $official->department : '' }}">
                                <input type="hidden" name="officials[{{ $key }}][dob]" id="hidden-dob-{{ $key }}"
                                    value="{{ $official ? $official->dob : '' }}">
                                <input type="hidden" name="officials[{{ $key }}][pob]" id="hidden-pob-{{ $key }}"
                                    value="{{ $official ? $official->pob : '' }}">
                                <input type="hidden" name="officials[{{ $key }}][civil_status]" id="hidden-civil-{{ $key }}"
                                    value="{{ $official ? $official->civil_status : '' }}">
                                <input type="hidden" name="officials[{{ $key }}][citizenship]" id="hidden-citizen-{{ $key }}"
                                    value="{{ $official ? $official->citizenship : '' }}">
                                <input type="hidden" name="officials[{{ $key }}][description]" id="hidden-desc-{{ $key }}"
                                    value="{{ $official ? $official->description : '' }}">
                                <input type="hidden" id="existing-photo-path-{{ $key }}" value="{{ $photoPath ?? '' }}">
                                {{-- Store flag only if image exists, don't store the base64 data in DOM to avoid glitching --}}
                                <input type="hidden" id="has-image-{{ $key }}" value="{{ $imageData ? 'true' : 'false' }}">
                                {{-- Note: We inject the file input via JS below to keep it linked to the main form --}}
                                <div id="file-input-container-{{ $key }}" class="d-none"></div>
                            </div>
                @endforeach
            </div>
            <button type="submit" class="btn fw-bold px-3 px-sm-4 py-2 text-dark shadow-sm w-100 w-sm-auto mt-4"
                style="background-color: #6eff6e; border: 1px solid #4ade4a;">
                UPLOAD
            </button>
        </form>
    </div>

    {{-- ================================================================= --}}
    {{-- THE MODAL (Acts as your Description Blade) --}}
    {{-- ================================================================= --}}
    <div class="modal fade" id="officialModal" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
            style="max-width: 700px; margin-top: 100px;">
            <div class="modal-content border-0 shadow-lg">

                <div
                    class="modal-header d-flex justify-content-center bg-light border-bottom-0 pb-0 pt-2 pt-sm-3 px-2 px-sm-4">
                    <h5 class="modal-title fw-bold text-secondary text-uppercase mb-0"
                        style="letter-spacing: 2px; font-size: 0.95rem;">
                        OFFICIALS
                    </h5>
                </div>

                <div class="modal-body px-2 px-sm-3 py-2 py-sm-3">
                    {{-- Holds the current position key being edited --}}
                    <input type="hidden" id="modal-current-key">

                    {{-- Name Input (Centered Top) --}}
                    <div class="row justify-content-center mb-3 mb-sm-4">
                        <div class="col-12 col-md-8 col-lg-6 text-center">
                            <input type="text" id="modal-name" class="form-control text-center py-2 text-uppercase"
                                placeholder="NAME" style="border: 1.5px solid #333; border-radius: 6px;">
                        </div>
                    </div>

                    <div class="row g-3 g-sm-4">
                        {{-- Photo Upload Section --}}
                        <div class="col-12 col-sm-6 col-md-5">
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center position-relative overflow-hidden mx-auto"
                                style="height: 160px; max-width: 200px; border: 1.5px dashed #ccc !important;">
                                <img id="modal-photo-preview" src="" class="img-fluid d-none"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                                <div id="modal-photo-placeholder" class="text-center text-muted">
                                    <i class="fa-solid fa-camera fa-2x mb-2"></i>
                                    <p class="mb-0" style="font-size: 0.8rem;">Click to upload photo</p>
                                </div>
                                <input type="file" id="modal-photo-input"
                                    accept="image/jpeg,image/png,image/webp,image/svg+xml,image/tiff,.jpg,.jpeg,.png,.webp,.svg,.tiff"
                                    class="position-absolute w-100 h-100 top-0 inset-s-0 opacity-0 cursor-pointer"
                                    onchange="previewModalImage(this)">
                            </div>
                        </div>

                        {{-- Form Inputs Section --}}
                        <div class="col-12 col-sm-6 col-md-7">
                            <div class="row g-1 g-sm-2">
                                <div class="col-12">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-5"><label class="fw-bold text-dark small">Position:</label></div>
                                        <div class="col-7"><input type="text" id="modal-position"
                                                class="form-control form-control-sm text-center bg-light" readonly></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-5"><label class="fw-bold text-dark small">Department:</label></div>
                                        <div class="col-7"><input type="text" id="modal-dept"
                                                class="form-control form-control-sm text-center"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-5"><label class="fw-bold text-dark small">Date Of Birth:</label></div>
                                        <div class="col-7"><input type="date" id="modal-dob"
                                                class="form-control form-control-sm text-center"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-5"><label class="fw-bold text-dark small">Place Of Birth:</label></div>
                                        <div class="col-7"><input type="text" id="modal-pob"
                                                class="form-control form-control-sm text-center"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-5"><label class="fw-bold text-dark small">Status:</label></div>
                                        <div class="col-7"><input type="text" id="modal-civil"
                                                class="form-control form-control-sm text-center"></div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-5"><label class="fw-bold text-dark small">Citizenship:</label></div>
                                        <div class="col-7"><input type="text" id="modal-citizen"
                                                class="form-control form-control-sm text-center"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description Section --}}
                    <div class="mt-2 mt-sm-3">
                        <textarea id="modal-desc" class="form-control p-2 p-sm-3 text-center" rows="3"
                            placeholder="DESCRIPTION"
                            style="border: 1.5px solid #333; border-radius: 6px; resize: vertical; font-size: 0.9rem;"></textarea>
                    </div>

                </div>

                <div class="modal-footer bg-light border-top py-2 px-2 px-sm-3 d-flex justify-content-between gap-2">
                    <button type="button"
                        class="btn btn-white border border-dark rounded fw-bold px-2 px-sm-3 py-1 text-dark shadow-sm btn-sm"
                        data-bs-dismiss="modal">
                        BACK
                    </button>
                    <button type="button" class="btn fw-bold px-2 px-sm-3 py-1 text-dark shadow-sm btn-sm"
                        onclick="saveDraftInformation()" style="background-color: #6eff6e; border: 1px solid #4ade4a;">
                        SAVE
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('js/admin/official-modal.js') }}"></script>
    <script>
        // Handle form submission with file support
            document.getElementById('officialsForm').addEventListener('submit', function(e) {
                // If we have stored files, create DataTransfer objects to assign them to the hidden inputs
                if (Object.keys(officialFiles).length > 0) {
                    for (const [positionKey, file] of Object.entries(officialFiles)) {
                        const fileInputId = 'file-' + positionKey;
                        const fileInput = document.getElementById(fileInputId);

                        if (fileInput) {
                            // Create a DataTransfer object and add the file
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;
                            console.log('Added file for position ' + positionKey + ':', file.name);
                        }
                    }
                }

                // Submit the form normally
                console.log('Form submitting...');
            });
    </script>
@endsection
