@extends('adminlayout.adminpanellayout')
@section('adminpanel-content')


    <section class="p-2 p-md-3 overflow-hidden">
        {{-- Alerts for Success/Error --}}

        @include('admin.alert-message')

        @include('admin.filteradmin')
        <div class="row mt-4">

            <div class="mb-3 mb-md-4 mt-3 mt-md-4 text-center scroll-fade-in">
                <a href="{{ route('ordinance') }}" class="btn btn-outline-dark shadow-sm px-3 px-md-4 fw-bold w-100 w-md-auto" data-uid="true">
                    <i class="fas fa-file-lines pe-3"></i> Go to Upload Page
                </a>
            </div>



            @foreach($ordinances as $ordinance)
                <div class="col-12 col-md-6 col-lg-4 mb-4 scroll-fade-in"> {{-- Added mb-4 for spacing --}}

                    {{-- Added position-relative so the stretched-link stays contained within the card --}}
                    <div class="card ordinance-card shadow-soft h-100 p-4 position-relative hover-lift scroll-fade-in">

                        {{-- Attachment Count Badge --}}
                        @if($ordinance->attachments && count($ordinance->attachments) > 0)
                            <div class="position-absolute" style="top: 15px; right: 15px; z-index: 5;">
                                <button type="button" class="badge bg-primary rounded-pill attachment-badge-btn"
                                    title="Click to view attachments" style="font-size: 0.75rem; border: none; cursor: pointer;"
                                    data-ordinance-id="{{ $ordinance->id }}"
                                    data-attachments="{{ json_encode($ordinance->attachments) }}">
                                    <i class="fas fa-file-pdf pe-1"></i>{{ count($ordinance->attachments) }}
                                </button>
                            </div>
                        @endif

                        {{-- Added d-flex and flex-column so the mt-auto on the footer pushes it perfectly to the bottom --}}
                        <div class="card-body p-0 mt-4 d-flex flex-column">

                            {{-- THE MAGIC LINK --}}
                            <a href="{{ url('/ord-uploaded/description/' . $ordinance->id) }}"
                                class="stretched-link text-decoration-none text-dark" data-uid="true">

                                {{-- DATE IMPLEMENTED --}}
                                <div class="ord-header fs-6 text-muted mb-2 text-uppercase"
                                    style="letter-spacing: 1px; font-size: 0.85rem;">
                                    <i class="far fa-calendar-alt pe-1"></i>
                                    {{ $ordinance->date_implemented ? \Carbon\Carbon::parse($ordinance->date_implemented)->format('F d, Y') : 'Date Not Specified' }}
                                </div>

                                {{-- SUBJECT (In Bold) --}}
                                <div class="ord-body fs-5 fw-bold mb-3 scroll-fade-in text-dark">
                                    {{ $ordinance->subject }}
                                </div>
                            </a>

                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- The Pagination Links --}}
        <div class="d-flex justify-content-center mt-4 mt-md-5 mb-3 mb-md-4 overflow-auto">
            {{-- appends(request()->query()) tells Laravel to carry over the ?year=x&month=y to the next page --}}
            {{ $ordinances->appends(request()->query())->links() }}
        </div>

    </section>

    {{-- ATTACHMENTS VIEWER MODAL --}}
    <div class="modal fade" id="attachmentListModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Attachments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle" id="attachmentListTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="font-size: 0.85rem;"><i class="fas fa-file pe-2"></i>File Name</th>
                                    <th style="font-size: 0.85rem;">Type</th>
                                    <th style="font-size: 0.85rem;">Size</th>
                                </tr>
                            </thead>
                            <tbody id="attachmentListBody">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ATTACHMENT DETAIL VIEWER MODAL --}}
    <div class="modal fade" id="attachmentDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="detailFileName"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div id="detailPreview"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-primary" id="detailDownloadBtn" target="_blank" download>
                        <i class="fas fa-download pe-1"></i>Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle attachment badge clicks
            const attachmentBadges = document.querySelectorAll('.attachment-badge-btn');

            attachmentBadges.forEach(badge => {
                badge.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent card link from triggering

                    const attachmentsJson = this.dataset.attachments;
                    const attachments = JSON.parse(attachmentsJson);

                    // Populate the list modal
                    const tableBody = document.getElementById('attachmentListBody');
                    tableBody.innerHTML = '';

                    attachments.forEach((attachment, index) => {
                        const row = document.createElement('tr');
                        row.style.cursor = 'pointer';
                        row.className = 'attachment-list-row';
                        row.innerHTML = `
                            <td style="font-size: 0.9rem;">
                                <i class="fas fa-file-pdf pe-2 text-danger"></i>
                                ${attachment.original_name}
                            </td>
                            <td style="font-size: 0.85rem;">
                                <span class="badge bg-info">${attachment.original_name.split('.').pop().toUpperCase()}</span>
                            </td>
                            <td style="font-size: 0.85rem;">
                                ${(attachment.file_size / 1024 / 1024).toFixed(2)} MB
                            </td>
                        `;

                        // Add click handler to view detail
                        row.addEventListener('click', function() {
                            showAttachmentDetail(attachment);
                        });

                        tableBody.appendChild(row);
                    });

                    // Show list modal
                    const listModal = new bootstrap.Modal(document.getElementById('attachmentListModal'));
                    listModal.show();
                });
            });

            // Function to show attachment detail
            function showAttachmentDetail(attachment) {
                const filePath = attachment.file_path;
                const fileName = attachment.original_name;
                const fileType = attachment.original_name.split('.').pop().toLowerCase();
                const fileSize = (attachment.file_size / 1024 / 1024).toFixed(2);

                // Update modal header and download button
                document.getElementById('detailFileName').textContent = fileName;
                document.getElementById('detailDownloadBtn').href = '/storage/' + filePath;
                document.getElementById('detailDownloadBtn').download = fileName;

                const previewDiv = document.getElementById('detailPreview');
                previewDiv.innerHTML = '';

                const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                const pdfExtensions = ['pdf'];

                if (imageExtensions.includes(fileType)) {
                    const img = document.createElement('img');
                    img.src = '/storage/' + filePath;
                    img.style.maxWidth = '100%';
                    img.style.height = 'auto';
                    img.className = 'img-fluid rounded';
                    previewDiv.appendChild(img);
                } else if (pdfExtensions.includes(fileType)) {
                    const iframe = document.createElement('iframe');
                    iframe.src = '/storage/' + filePath;
                    iframe.style.width = '100%';
                    iframe.style.height = '600px';
                    iframe.style.border = 'none';
                    iframe.style.borderRadius = '0.375rem';
                    previewDiv.appendChild(iframe);
                } else {
                    const fileInfo = document.createElement('div');
                    fileInfo.className = 'alert alert-info';
                    fileInfo.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-file fa-3x mb-3 text-info"></i>
                            <h5>${fileName}</h5>
                            <p class="mb-1"><strong>Type:</strong> ${fileType.toUpperCase()}</p>
                            <p class="mb-3"><strong>Size:</strong> ${fileSize} MB</p>
                            <p class="text-muted">Click the Download button to view or save this file</p>
                        </div>
                    `;
                    previewDiv.appendChild(fileInfo);
                }

                // Hide list modal and show detail modal
                bootstrap.Modal.getInstance(document.getElementById('attachmentListModal')).hide();
                const detailModal = new bootstrap.Modal(document.getElementById('attachmentDetailModal'));
                detailModal.show();

                // When detail modal closes, show list modal again
                document.getElementById('attachmentDetailModal').addEventListener('hidden.bs.modal', function() {
                    const listModal = new bootstrap.Modal(document.getElementById('attachmentListModal'));
                    listModal.show();
                }, { once: true });
            }
        });
    </script>

@endsection
