@extends('layout.layout-admin')

@section('event-upload')

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <div class="container mb-5">
        <div class="upload-card">
            <h2 class="text-center mb-5 text-secondary tracking-widest uppercase" style="letter-spacing: 4px;">
                MUNICIPALITY EVENTS
            </h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" id="eventForm">
                @csrf

                <div class="mb-4">
                    <label class="form-label label-caps">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label label-caps">Caption</label>
                    <textarea name="caption" class="form-control" rows="5" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label label-caps">Event Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label label-caps">Media Upload</label>

                    <div class="image-placeholder text-center p-5 rounded"
                        style="border: 2px dashed #ccc; background-color: #f8f9fa; transition: all 0.3s ease;">
                        <img src="https://cdn-icons-png.flaticon.com/512/1160/1160358.png" width="60"
                            style="opacity: 0.2; margin-bottom: 15px;">
                        <h6 class="text-secondary mb-3">Drag & Drop your images and videos here</h6>
                        <button type="button" class="btn btn-browse btn-outline-dark px-4 fw-bold">
                            Or Browse Files
                        </button>
                    </div>

                    <div id="image-preview-container" class="row g-3 mt-4 justify-content-center"></div>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-dark w-100 py-3 fw-bold mt-3"
                    style="letter-spacing: 2px;">POST EVENT</button>
            </form>
        </div>

        <div class="mb-4 mt-4 text-center scroll-fade-in">
            <a href="{{ route('admin.events.event-uploaded') }}" class="btn btn-outline-dark shadow-sm px-4 fw-bold ">
                <i class="fas fa-file-lines pe-3"></i> Go to Uploaded Events
            </a>
        </div>
    </div>

    
@endsection