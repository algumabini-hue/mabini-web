@extends('adminlayout.adminpanellayout')
@section('adminpanel-content')

    <div class="container-fluid px-3 px-md-4 py-4 py-md-5 mb-5">

        {{-- Alerts for Success/Error --}}
        @include('admin.alert-message')

        {{-- CRITICAL FIX: Added enctype="multipart/form-data" to allow file uploads on update --}}
        <form action="{{ route('ord-update', ['id' => $ordinance->id, 'uid' => request('uid')]) }}" method="POST"
            enctype="multipart/form-data" id="ordinanceEditForm">
            @method('PUT')

            {{-- Top Header Bar --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-4 mb-md-5">
                <a href="{{ url()->previous() }}" class="btn btn-white border border-dark rounded fw-bold px-3 px-md-4 text-dark w-100 w-md-auto"
                    style="box-shadow: 2px 2px 0px rgba(0,0,0,0.1);" data-uid="true">
                    BACK
                </a>

                <h4 class="mb-0 fw-bold text-secondary text-center w-100" style="letter-spacing: 2px; font-size: 1.5rem;">EDIT ORDINANCE</h4>

                <button type="submit" id="submitBtn" class="btn fw-bold px-3 px-md-4 text-dark w-100 w-md-auto" data-uid="true"
                    style="background-color: #6eff6e; border: 1px solid #4ade4a; box-shadow: 2px 2px 0px rgba(0,0,0,0.1);">
                    SAVE CHANGES
                </button>
            </div>

            {{-- The Form Box --}}
            <div class="row justify-content-center">
                <div class="col-12"> 
                    <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e0e0e0;">

                        <div class="card-header text-white text-center py-2"
                            style="background-color: #333; border-radius: 12px 12px 0 0;">
                            <h6 class="mb-0 fw-bold" style="letter-spacing: 2px;">ORDINANCE DETAILS</h6>
                        </div>

                        <div class="card-body p-3 p-md-5">

                            {{-- Section 1: Core Details --}}
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-bold text-dark" style="font-size: 0.8rem; letter-spacing: 1px;">DATE IMPLEMENTED</label>

                                    {{-- FIX: Formatted the date string to YYYY-MM-DD so the input can read it --}}
                                    <input type="date" name="date_implemented"
                                        value="{{ old('date_implemented', $ordinance->date_implemented ? \Carbon\Carbon::parse($ordinance->date_implemented)->format('Y-m-d') : '') }}"
                                        class="form-control py-2" style="border: 1.5px solid #333; border-radius: 6px;">
                                </div>

                                <div class="col-12 col-md-8">
                                    <label class="form-label fw-bold text-dark"
                                        style="font-size: 0.8rem; letter-spacing: 1px;">SUBJECT / TITLE <span class="text-danger">*</span></label>
                                    <textarea name="subject" class="form-control" rows="2" required
                                        style="border: 1.5px solid #333; border-radius: 6px; resize: vertical;">{{ old('subject', $ordinance->subject) }}</textarea>
                                </div>
                            </div>

                            <hr class="my-4" style="border-color: #ccc;">

                            {{-- Section 2: EXISTING Attachments --}}
                            @if(!empty($ordinance->attachments) && count($ordinance->attachments) > 0)
                                <div class="mb-5">
                                    <label class="form-label fw-bold text-dark" style="font-size: 0.9rem; letter-spacing: 1px;">
                                        <i class="fas fa-folder-open pe-2 text-primary"></i>CURRENT ATTACHMENTS
                                    </label>
                                    <p class="text-muted small mb-3">Click on an image to preview it. Click the red "X" to permanently delete it.</p>

                                    <div class="row g-3">
                                        @foreach($ordinance->attachments as $index => $attachment)
                                            @php
        $ext = strtolower(pathinfo($attachment['original_name'], PATHINFO_EXTENSION));
        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                            @endphp

                                            <div class="col-6 col-sm-4 col-md-3 col-lg-2 existing-attachment-card">
                                                <div class="preview-wrapper position-relative shadow-sm rounded border" style="padding-top: 100%; overflow: hidden; background: #f8f9fa;">

                                                    {{-- Delete Button --}}
                                                    <button type="button" data-uid="true" class="btn btn-danger remove-btn" 
                                                        onclick="removeExistingAttachment(this, '{{ $attachment['file_path'] }}')"
                                                        title="Delete this file">
                                                        <i class="fas fa-times"></i>
                                                    </button>

                                                    @if($isImage)
                                                        <img src="{{ asset('storage/' . $attachment['file_path']) }}" 
                                                             class="position-absolute top-0 start-0 w-100 h-100 lightbox-trigger" 
                                                             style="object-fit: cover; cursor: zoom-in;"
                                                             onclick="openLightbox('{{ asset('storage/' . $attachment['file_path']) }}')"
                                                             alt="Attachment">
                                                    @else
                                                        <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-light position-absolute w-100 top-0 start-0 p-2 text-center border-0">
                                                            <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                                            <span style="font-size: 0.65rem; word-break: break-all; line-height: 1;">{{ $attachment['original_name'] }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Section 3: NEW Attachments Dropzone --}}
                            <div class="mb-2">
                                <label class="form-label fw-bold text-dark" style="font-size: 0.9rem; letter-spacing: 1px;">
                                    <i class="fas fa-camera pe-2 text-success"></i>ADD NEW PHOTOS OR SCANNED PAGES
                                </label>

                                <div class="custom-dropzone mt-2 text-center p-4 p-md-5 rounded position-relative" id="dropzone-edit"
                                    style="border: 2px dashed #ccc; background-color: #f8f9fa; transition: all 0.3s ease; overflow: hidden;">

                                    <input type="file" name="new_attachments[]" 
                                        class="position-absolute top-0 start-0 w-100 h-100 file-input" 
                                        id="fileInputEdit" 
                                        accept="image/jpeg, image/png, image/jpg, application/pdf"
                                        multiple
                                        capture="environment" 
                                        style="opacity: 0; cursor: pointer; z-index: 10;">

                                    <img src="https://cdn-icons-png.flaticon.com/512/1160/1160358.png" width="60" style="opacity: 0.2; margin-bottom: 15px;">
                                    <h6 class="text-secondary mb-2">Drag & Drop photos/PDFs here</h6>
                                    <button type="button" class="btn btn-outline-dark px-4 fw-bold mt-2" style="position: relative; z-index: 5;">
                                        Or Browse Files
                                    </button>
                                </div>

                                {{-- Container for previews of newly selected files --}}
                                <div class="row g-3 mt-3 preview-container" id="previewContainerEdit"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- LIGHTBOX MODAL FOR IMAGE PREVIEW --}}
    <div class="modal fade" id="imageLightbox" tabindex="-1" aria-hidden="true">
        <button type="button" class="lightbox-close-btn" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times fs-5"></i>
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

    {{-- Script for handling Dropzone and Deletions --}}
    <script>
        // 1. Lightbox Logic
        function openLightbox(imageSrc) {
            document.getElementById('lightboxMainImage').src = imageSrc;
            new bootstrap.Modal(document.getElementById('imageLightbox')).show();
        }

        // 2. Existing File Deletion Logic
        function removeExistingAttachment(btnElement, filePath) {
            if(confirm("Are you sure you want to remove this file? It will be deleted when you save changes.")) {
                // Hide the card visually
                btnElement.closest('.existing-attachment-card').style.display = 'none';

                // Create a hidden input to tell the backend to delete this file
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_attachments[]';
                input.value = filePath;
                document.getElementById('ordinanceEditForm').appendChild(input);
            }
        }

        // 3. New File Dropzone Logic
        document.addEventListener('DOMContentLoaded', function() {
            const dropzone = document.getElementById('dropzone-edit');
            const fileInput = document.getElementById('fileInputEdit');
            const previewContainer = document.getElementById('previewContainerEdit');

            let dt = new DataTransfer();

            if(!dropzone || !fileInput) return;

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
                dropzone.addEventListener(eventName, () => dropzone.classList.add('drag-active'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
                dropzone.addEventListener(eventName, () => dropzone.classList.remove('drag-active'), false);
            });

            dropzone.addEventListener('drop', function(e) {
                handleFiles(e.dataTransfer.files);
            }, false);

            fileInput.addEventListener('change', function(e) {
                handleFiles(e.target.files);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function handleFiles(files) {
                for(let i = 0; i < files.length; i++) {
                    dt.items.add(files[i]);
                }
                fileInput.files = dt.files;
                updatePreviews();
            }

            function updatePreviews() {
                previewContainer.innerHTML = '';
                Array.from(fileInput.files).forEach((file, fileIndex) => {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-sm-4 col-md-3 col-lg-2';

                    const wrapper = document.createElement('div');
                    wrapper.className = 'preview-wrapper position-relative shadow-sm rounded border';
                    wrapper.style.paddingTop = '100%';
                    wrapper.style.overflow = 'hidden';
                    wrapper.style.background = '#fff';

                    if(file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'position-absolute top-0 start-0 w-100 h-100';
                            img.style.objectFit = 'cover';
                            wrapper.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    } else {
                        wrapper.innerHTML = `
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-light position-absolute w-100 top-0 start-0 p-2 text-center border-0">
                                <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                <span style="font-size: 0.65rem; word-break: break-all; line-height: 1;">${file.name}</span>
                            </div>
                        `;
                    }

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'btn btn-danger remove-btn';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.onclick = function(e) {
                        e.preventDefault();
                        removeFile(fileIndex);
                    };

                    wrapper.appendChild(removeBtn);
                    col.appendChild(wrapper);
                    previewContainer.appendChild(col);
                });
            }

            function removeFile(indexToRemove) {
                const newDt = new DataTransfer();
                const currentFiles = fileInput.files;
                for(let i = 0; i < currentFiles.length; i++) {
                    if(i !== indexToRemove) {
                        newDt.items.add(currentFiles[i]);
                    }
                }
                dt = newDt;
                fileInput.files = dt.files;
                updatePreviews();
            }

            // Submit Button Feedback
            const form = document.getElementById('ordinanceEditForm');
            const submitBtn = document.getElementById('submitBtn');
            if(form && submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> SAVING...';
                });
            }
        });
    </script>

    <style>
        .custom-dropzone.drag-active {
            background-color: #e9ecef !important;
            border-color: #198754 !important;
            border-width: 3px !important;
        }

        .remove-btn {
            position: absolute;
            top: -8px; right: -8px;
            width: 26px; height: 26px;
            padding: 0; border-radius: 50%;
            font-size: 14px; line-height: 1;
            z-index: 20;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }



        /* Lightbox specific styles */
        .lightbox-close-btn {
            position: fixed;
            top: 25px;
            right: 30px;
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
        .lightbox-close-btn:hover {
            background-color: #e74c3c;
            border-color: #e74c3c;
            transform: scale(1.1);
        }
        .modal-backdrop.show {
            opacity: 0.9 !important;
            background-color: #000 !important;
        }
    </style>

@endsection