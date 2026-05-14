@extends('adminlayout.adminpanellayout')
@section('adminpanel-content')

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <div class="container mb-5" style="min-height: 85vh;">
        <div class="upload-card">
            <h2 class="text-center mb-5 text-secondary tracking-widest uppercase" style="letter-spacing: 4px;">
                {{ isset($editingEvent) ? 'EDIT EVENT' : 'MUNICIPALITY EVENTS' }}
            </h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ isset($editingEvent) ? route('municipality.update', $editingEvent) : route('events.store') }}"
                method="POST" enctype="multipart/form-data" id="eventForm">
                @csrf
                @if (isset($editingEvent))
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label class="form-label label-caps">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $editingEvent->title ?? '' }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label label-caps">Caption</label>
                    <textarea name="caption" class="form-control" rows="5"
                        required>{{ $editingEvent->caption ?? '' }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label label-caps">Event Date</label>
                    <input type="date" name="date" class="form-control"
                        value="{{ isset($editingEvent) ? $editingEvent->date->format('Y-m-d') : '' }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label label-caps">Media Upload</label>

                    @if(isset($editingEvent) && !empty($editingEvent->images))
                        <div class="mb-4 p-3 rounded" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                            <h6 class="text-secondary mb-3 fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;">PREVIOUSLY
                                UPLOADED MEDIA</h6>
                            <div class="row g-2">
                                @foreach($editingEvent->images as $image)
                                    @php
                                        $isVideo = preg_match('/\.(mp4|mov|avi|webm|ogg)$/i', $image);
                                    @endphp
                                    <div class="col-auto existing-media-item">
                                        <div class="position-relative shadow-sm"
                                            style="width: 120px; height: 120px; border-radius: 8px; overflow: hidden; background: #000;">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                onclick="this.closest('.existing-media-item').remove()"
                                                style="z-index: 10; padding: 0.1rem 0.4rem; font-size: 0.8rem;">&times;</button>

                                            @if($isVideo)
                                                <video src="{{ asset('storage/' . $image) }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;" muted></video>
                                                <span class="position-absolute bottom-0 start-0 m-1 badge bg-danger"
                                                    style="font-size: 0.6rem;">VIDEO</span>
                                            @else
                                                <img src="{{ asset('storage/' . $image) }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            @endif

                                            <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

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

                <button type="submit" id="submitBtn" data-uid="true" class="btn btn-dark w-100 py-3 fw-bold mt-3"
                    style="letter-spacing: 2px;">{{ isset($editingEvent) ? 'UPDATE EVENT' : 'POST EVENT' }}</button>
            </form>
        </div>

        <div class="mb-4 mt-4 text-center scroll-fade-in">
            <a href="{{ route('municipality.uploaded') }}" class="btn btn-outline-dark shadow-sm px-4 fw-bold ">
                <i class="fas fa-file-lines pe-3"></i> Go to Uploaded Events
            </a>
        </div>
    </div>

@endsection