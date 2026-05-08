Dropzone.autoDiscover = false;

document.addEventListener("DOMContentLoaded", function () {

    let customPreviewTemplate = `
        <div class="dz-preview dz-file-preview col-auto mb-3">
            <div class="preview-wrapper" style="position: relative; display: inline-block; overflow: hidden; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 140px; height: 140px;">
                <button type="button" class="btn btn-danger btn-sm remove-btn" data-dz-remove
                        style="position: absolute; top: -5px; right: -5px; z-index: 30; width: 26px; height: 26px; padding: 0; line-height: 1; border-radius: 50%; font-size: 14px;">&times;</button>
                <div class="media-container w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                    <img data-dz-thumbnail class="img-thumbnail w-100 h-100 p-0 border-0" style="object-fit: cover; border-radius: 8px;" />
                </div>
                <div class="file-progress-overlay d-none" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 10;"></div>
                <div class="file-progress-text d-none" style="position: absolute; top: 30%; left: 0; width: 100%; text-align: center; color: white; font-weight: 900; font-size: 1.4rem; text-shadow: 0 2px 5px rgba(0,0,0,1); z-index: 20;">0%</div>
                <div class="file-progress-bar d-none w-100 px-3" style="position: absolute; bottom: 12px; left: 0; z-index: 20;">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div style="font-size: 0.7rem; color: #e9ecef; font-weight: bold; text-shadow: 1px 1px 3px rgba(0,0,0,0.9);">
                            <span data-dz-size></span>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger py-0 px-2 cancel-upload-btn" data-dz-remove style="font-size: 0.6rem; font-weight: bold; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.5);">CANCEL</button>
                    </div>
                    <div class="progress shadow-sm" style="height: 8px; border-radius: 4px; background: rgba(255,255,255,0.3);">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" data-dz-uploadprogress style="width: 0%;"></div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Attached Dropzone specifically to the dashed box
    let myDropzone = new Dropzone(".image-placeholder", {
        url: "/events/upload-temp",
        autoProcessQueue: false,
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 20,
        maxFilesize: 500,
        acceptedFiles: "image/*,video/*",
        previewTemplate: customPreviewTemplate,
        previewsContainer: "#image-preview-container",
        clickable: ".btn-browse",

        init: function () {
            let dz = this;
            let submitBtn = document.getElementById('submitBtn');
            let form = document.getElementById('eventForm');

            submitBtn.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // IMPROVED LOGIC: Check if new files are queued OR if old photos still exist
                let hasNewFiles = dz.getQueuedFiles().length > 0;
                let hasExistingFiles = document.querySelectorAll('input[name="existing_images[]"]').length > 0;

                if (hasNewFiles) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> UPLOADING...';
                    dz.processQueue();
                } else if (hasExistingFiles) {
                    // No new files, but we have old ones? Just submit the form (Update text only)
                    form.submit();
                } else {
                    alert("Please select at least one image or video to upload.");
                }
            });

            this.on("addedfile", function (file) {
                if (file.type.match(/video.*/)) {
                    let mediaContainer = file.previewElement.querySelector('.media-container');
                    let fileUrl = URL.createObjectURL(file);
                    mediaContainer.innerHTML = `
                        <video src="${fileUrl}" class="img-thumbnail w-100 h-100 p-0 border-0" style="object-fit: cover; border-radius: 8px;" muted></video>
                        <div style="position: absolute; top: 8px; left: 8px; background: rgba(220,53,69,0.9); color: white; font-size: 0.7rem; padding: 3px 8px; border-radius: 4px; font-weight: bold; pointer-events: none; z-index: 5; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                            <i class="bi bi-play-fill"></i> VIDEO
                        </div>
                    `;
                }
            });

            this.on("sending", function (file, xhr, formData) {
                // THE CRITICAL FIX: Prevent the PUT method error during temp uploads
                if (formData.has('_method')) {
                    formData.delete('_method');
                }

                formData.append("_token", document.querySelector('input[name="_token"]').value);
                file.previewElement.querySelector('.remove-btn').style.display = 'none';
                file.previewElement.querySelector('.file-progress-overlay').classList.remove('d-none');
                file.previewElement.querySelector('.file-progress-text').classList.remove('d-none');
                file.previewElement.querySelector('.file-progress-bar').classList.remove('d-none');
            });

            this.on("uploadprogress", function (file, progress, bytesSent) {
                let percent = Math.round(progress);
                file.previewElement.querySelector('.file-progress-text').innerText = percent + "%";
            });

            this.on("success", function (file, response) {
                file.previewElement.querySelector('.file-progress-text').innerText = "DONE";
                file.previewElement.querySelector('.progress-bar').classList.remove('progress-bar-animated');
                let cancelBtn = file.previewElement.querySelector('.cancel-upload-btn');
                if (cancelBtn) cancelBtn.style.display = 'none';

                let hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'temp_files[]';
                hiddenInput.value = response.filePath;
                form.appendChild(hiddenInput);

                dz.processQueue();
            });

            this.on("canceled", function (file) {
                dz.processQueue();
            });

            this.on("queuecomplete", function () {
                if (dz.getUploadingFiles().length === 0 && dz.getQueuedFiles().length === 0) {
                    let successfulUploads = document.querySelectorAll('input[name="temp_files[]"]').length;
                    let hasExistingFiles = document.querySelectorAll('input[name="existing_images[]"]').length > 0;

                    if (successfulUploads > 0 || hasExistingFiles) {
                        form.submit();
                    } else {
                        submitBtn.disabled = false;
                        submitBtn.innerText = "POST EVENT";
                    }
                }
            });

            this.on("error", function (file, message) {
                alert("Error uploading " + file.name + ": " + (message.message || message));
                submitBtn.disabled = false;
                submitBtn.innerText = "POST EVENT";
            });
        }
    });
});