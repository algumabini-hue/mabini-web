@extends('adminlayout.adminpanellayout')
@section('adminpanel-content')

    <div class="container-fluid px-3 px-md-4 py-4 py-md-5 mb-5">

        @include('admin.alert-message')

        <form action="{{ route('ord-upload.store') }}" method="POST" enctype="multipart/form-data" id="ordinanceForm">
            @csrf

            {{-- Top Header Bar --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mb-4 mb-md-5">
                <a href="{{ url()->previous() }}"
                    class="btn btn-white border border-dark rounded fw-bold px-3 px-md-4 text-dark w-100 w-md-auto"
                    style="box-shadow: 2px 2px 0px rgba(0,0,0,0.1);" data-uid="true">
                    BACK
                </a>

                <h4 class="mb-0 fw-bold text-secondary text-center w-100" style="letter-spacing: 2px; font-size: 1.5rem;">
                    ORDINANCE UPLOAD</h4>

                <button type="submit" id="submitBtn" class="btn fw-bold px-3 px-md-4 text-dark w-100 w-md-auto"
                    style="background-color: #6eff6e; border: 1px solid #4ade4a; box-shadow: 2px 2px 0px rgba(0,0,0,0.1);">
                    UPLOAD
                </button>
            </div>

            {{-- The Upload Grid --}}
            <div class="row g-3 g-md-4">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-12">
                        <div class="card shadow-sm" style="border-radius: 12px; border: 1px solid #e0e0e0;">

                            <div class="card-header text-white text-center py-2"
                                style="background-color: #333; border-radius: 12px 12px 0 0;">
                                <h6 class="mb-0 fw-bold" style="letter-spacing: 2px;">ORDINANCE ENTRY {{ $i + 1 }}</h6>
                            </div>

                            <div class="card-body p-3 p-md-5">

                                {{-- Section 1: Core Details --}}
                                <div class="row g-3 mb-4">
                                    <div class="col-12 col-md-4">
                                        <label class="form-label fw-bold text-dark"
                                            style="font-size: 0.8rem; letter-spacing: 1px;">DATE IMPLEMENTED</label>
                                        <input type="date" name="ordinances[{{ $i }}][date_implemented]"
                                            class="form-control py-2" style="border: 1.5px solid #333; border-radius: 6px;">
                                    </div>

                                    <div class="col-12 col-md-8">
                                        <label class="form-label fw-bold text-dark"
                                            style="font-size: 0.8rem; letter-spacing: 1px;">SUBJECT / TITLE <span
                                                class="text-danger">*</span></label>
                                        <textarea name="ordinances[{{ $i }}][subject]" class="form-control" rows="2"
                                            placeholder="e.g., An Ordinance Regulating..."
                                            style="border: 1.5px solid #333; border-radius: 6px; resize: vertical;"></textarea>
                                    </div>
                                </div>

                                <hr class="my-4" style="border-color: #ccc;">

                                {{-- Section 2: Custom Dropzone --}}
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-dark" style="font-size: 0.9rem; letter-spacing: 1px;">
                                        <i class="fas fa-camera pe-2 text-success"></i>UPLOAD PHOTOS OR SCANNED PAGES
                                    </label>

                                    {{-- Custom Drop Area --}}
                                    <div class="custom-dropzone mt-2 text-center p-5 rounded position-relative"
                                        id="dropzone-{{ $i }}"
                                        style="border: 2px dashed #ccc; background-color: #f8f9fa; transition: all 0.3s ease; overflow: hidden;">

                                        {{-- Invisible file input stretches over the whole box --}}
                                        <input type="file" name="ordinances[{{ $i }}][attachments][]"
                                            class="position-absolute top-0 start-0 w-100 h-100 file-input"
                                            id="fileInput{{ $i }}" accept="image/jpeg, image/png, image/jpg, application/pdf"
                                            multiple capture="environment" style="opacity: 0; cursor: pointer; z-index: 10;">

                                        <img src="https://cdn-icons-png.flaticon.com/512/1160/1160358.png" width="60"
                                            style="opacity: 0.2; margin-bottom: 15px;">
                                        <h6 class="text-secondary mb-2">Drag & Drop photos/PDFs here</h6>
                                        <button type="button" class="btn btn-outline-dark px-4 fw-bold mt-2"
                                            style="position: relative; z-index: 5;">
                                            Or Browse Files
                                        </button>
                                    </div>

                                    {{-- Container for previews --}}
                                    <div class="row g-3 mt-3 preview-container" id="previewContainer{{ $i }}"></div>

                                </div>

                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </form>

        <div class="mb-4 mt-5 text-center scroll-fade-in">
            <a href="{{ route('ord-uploaded') }}" class="btn btn-outline-dark shadow-sm px-4 py-2 fw-bold w-100 w-md-auto"
                data-uid="true">
                <i class="fas fa-file-lines pe-2"></i> Go to Uploaded Ordinances
            </a>
        </div>
    </div>

    {{-- Call our new external script --}}
    <script src="{{ asset('js/ordinance-dropzone.js') }}"></script>

    <style>
        /* Drag active effect */
        .custom-dropzone.drag-active {
            background-color: #e9ecef !important;
            border-color: #198754 !important;
            border-width: 3px !important;
        }

        /* Thumbnail wrapper styles */
        .preview-wrapper {
            position: relative;
            width: 100%;
            padding-top: 100%;
            /* Perfect square */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: #fff;
            border: 1px solid #dee2e6;
        }

        .preview-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 24px;
            height: 24px;
            padding: 0;
            border-radius: 50%;
            font-size: 12px;
            line-height: 1;
            z-index: 20;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection