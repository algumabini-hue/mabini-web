@extends('adminlayout.adminpanellayout')
@section('adminpanel-content')

<div class="container-fluid mt-5 mb-5">
    <!-- Include Filter Album Component -->
    @include('admin.filteralbum')

    <!-- Display success/error messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Events Grid -->
    <div class="row g-4">
        @forelse ($events as $event)
            <div class="col-md-6 col-lg-4">
                <!-- Album Card -->
                <div class="card album-card shadow-sm rounded-3 h-100 cursor-pointer"
                    data-event-id="{{ $event->id }}"
                    onclick="showAlbumModal(this)">

                    <!-- Album Thumbnail -->
                    @if ($event->images && count($event->images) > 0)
                        <div class="album-thumbnail position-relative overflow-hidden rounded-top"
                            style="height: 240px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">

                            @php
                                $firstImage = $event->images[0];
                                $isVideo = in_array(pathinfo($firstImage, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi', 'webm', 'ogg']);
                            @endphp

                            @if ($isVideo)
                                <video style="width: 100%; height: 100%; object-fit: cover;" controls>
                                    <source src="{{ asset('storage/' . $firstImage) }}" type="video/mp4">
                                </video>
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <i class="fas fa-play-circle" style="font-size: 48px; color: white; opacity: 0.8;"></i>
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $event->title }}"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            @endif

                            <!-- Media Count Badge -->
                            <span class="badge bg-dark position-absolute bottom-2 end-2">
                                <i class="fas fa-images"></i> {{ count($event->images) }}
                            </span>
                        </div>
                    @else
                        <div class="album-thumbnail position-relative overflow-hidden rounded-top"
                            style="height: 240px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="font-size: 64px; color: #ccc;"></i>
                        </div>
                    @endif

                    <!-- Card Body -->
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title mb-2" style="font-weight: 600; line-height: 1.3;">
                            {{ Str::limit($event->title, 60) }}
                        </h6>

                        <p class="card-text text-muted small mb-2" style="flex-grow: 1;">
                            {{ Str::limit($event->caption, 85) }}
                        </p>

                        <div class="mb-2">
                            <small class="text-primary d-block">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $event->date->format('M d, Y') }}
                            </small>
                            <small class="text-secondary d-block">
                                <i class="fas fa-clock me-1"></i>
                                {{ $event->created_at->diffForHumans() }}
                            </small>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('municipality.edit', $event) }}"
                                class="btn btn-outline-primary btn-sm grow"
                                onclick="event.stopPropagation();" data-uid="true">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>

                            <form action="{{ route('municipality.destroy', $event) }}" method="POST" class="grow"
                                onsubmit="return confirm('Are you sure you want to delete this event?');"
                                onclick="event.stopPropagation();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 10px;"></i>
                    <p class="mb-0"><strong>No events found.</strong> Start by uploading new events in the Municipality Events section.</p>
                    <a href="{{ route('municipality') }}" class="btn btn-primary btn-sm mt-2" data-uid="true">
                        <i class="fas fa-plus me-1"></i> Create New Event
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($events->hasPages())
        <nav aria-label="Page navigation" class="d-flex justify-content-center mt-5">
            {{ $events->links() }}
        </nav>
    @endif
</div>

<!-- Album Modal -->
<div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="albumModalLabel">Event Album</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="albumContent" style="max-height: 600px; overflow-y: auto;">
                    <!-- Content loaded dynamically -->
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .album-card {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .album-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
    }

    .album-thumbnail {
        transition: filter 0.3s;
    }

    .album-card:hover .album-thumbnail {
        filter: brightness(0.9);
    }
</style>

<script>
    function showAlbumModal(cardElement) {
        const eventId = cardElement.getAttribute('data-event-id');
        const albumContent = document.getElementById('albumContent');

        // Get event data from card
        const title = cardElement.querySelector('.card-title').textContent.trim();
        const caption = cardElement.querySelector('.card-text').textContent.trim();
        const dateText = cardElement.querySelector('.text-primary').textContent.trim();

        // Fetch images from server via API
        fetch(`/api/municipality-events/${eventId}`)
            .then(response => response.json())
            .then(data => {
                const event = data.event;

                let htmlContent = `
                    <div class="album-details">
                        <h5 class="mb-3">${event.title}</h5>
                        <p class="text-muted mb-4">${event.caption}</p>

                        <div class="mb-3">
                            <small class="text-secondary">
                                <i class="fas fa-calendar me-1"></i> ${event.date_formatted}
                            </small>
                        </div>

                        <h6 class="mt-4 mb-3">
                            <strong>Gallery (${event.images.length} files)</strong>
                        </h6>

                        <div class="row g-2">
                `;

                event.images.forEach((image, index) => {
                    const isVideo = /\.(mp4|mov|avi|webm|ogg)$/.test(image);
                    const fullPath = `/storage/${image}`;

                    if (isVideo) {
                        htmlContent += `
                            <div class="col-md-6 col-lg-4">
                                <video class="img-fluid rounded" style="width: 100%; aspect-ratio: 1; object-fit: cover;" controls>
                                    <source src="${fullPath}" type="video/mp4">
                                </video>
                            </div>
                        `;
                    } else {
                        htmlContent += `
                            <div class="col-md-6 col-lg-4">
                                <img src="${fullPath}" alt="Gallery ${index + 1}"
                                    class="img-fluid rounded cursor-pointer"
                                    style="width: 100%; aspect-ratio: 1; object-fit: cover;"
                                    onclick="openImagePreview('${fullPath}')">
                            </div>
                        `;
                    }
                });

                htmlContent += '</div></div>';

                albumContent.innerHTML = htmlContent;

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('albumModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error fetching event data:', error);
                albumContent.innerHTML = '<p class="text-danger">Error loading album. Please try again.</p>';
            });
    }

    function openImagePreview(imagePath) {
        const modal = document.createElement('div');
        modal.className = 'position-fixed w-100 h-100';
        modal.style.cssText = `
            top: 0; left: 0;
            background: rgba(0,0,0,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            cursor: pointer;
        `;

        const img = document.createElement('img');
        img.src = imagePath;
        img.style.cssText = `
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
        `;

        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.cssText = `
            position: absolute;
            top: 20px; right: 30px;
            background: none;
            border: none;
            color: white;
            font-size: 40px;
            cursor: pointer;
        `;

        closeBtn.onclick = () => modal.remove();
        modal.onclick = () => modal.remove();

        modal.appendChild(img);
        modal.appendChild(closeBtn);
        document.body.appendChild(modal);
    }
</script>

@endsection
