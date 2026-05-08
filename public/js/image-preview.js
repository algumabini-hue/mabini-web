let selectedFiles = []; // Array to track files
const fileInput = document.getElementById('fileInput');
const container = document.getElementById('image-preview-container');

fileInput.addEventListener('change', function (event) {
    // Add newly selected files to our tracking array
    const newFiles = Array.from(event.target.files);
    selectedFiles = [...selectedFiles, ...newFiles];

    renderPreviews();
});

function renderPreviews() {
    container.innerHTML = ''; // Clear container

    // Create a new DataTransfer object to sync back to the input
    const dataTransfer = new DataTransfer();

    selectedFiles.forEach((file, index) => {
        dataTransfer.items.add(file); // Keep this file in the input

        // SUPER UPGRADE: Use ObjectURL instead of FileReader. 
        // It is instant and won't crash the browser on large video files!
        const fileUrl = URL.createObjectURL(file);

        // Check if the file is a video
        const isVideo = file.type.startsWith('video/');

        const col = document.createElement('div');
        col.className = 'col-auto mb-3'; // col-auto keeps the boxes tight

        // Build the correct media tag (Image or Video)
        let mediaHtml = '';
        if (isVideo) {
            // Muted video without controls acts just like an animated thumbnail
            mediaHtml = `
                <video src="${fileUrl}" class="img-thumbnail" style="height: 100px; width: 100px; object-fit: cover;" muted></video>
                <div style="position: absolute; bottom: 5px; left: 5px; background: rgba(0,0,0,0.7); color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; font-weight: bold; pointer-events: none;">
                    <i class="bi bi-play-fill"></i> VIDEO
                </div>
            `;
        } else {
            mediaHtml = `<img src="${fileUrl}" class="img-thumbnail" style="height: 100px; width: 100px; object-fit: cover;">`;
        }

        col.innerHTML = `
            <div class="preview-wrapper" style="position: relative; display: inline-block;">
                <button type="button" class="btn btn-danger btn-sm rounded-circle shadow-sm" 
                        style="position: absolute; top: -8px; right: -8px; z-index: 10; width: 24px; height: 24px; padding: 0; line-height: 1;" 
                        onclick="removeImage(${index})">&times;</button>
                
                ${mediaHtml}
            </div>
        `;
        container.appendChild(col);
    });

    // Crucial: Update the actual file input with our filtered list
    fileInput.files = dataTransfer.files;
}

function removeImage(index) {
    // Clean up the object URL to save memory before removing it from the array
    if (fileInput.files[index]) {
        URL.revokeObjectURL(URL.createObjectURL(fileInput.files[index]));
    }

    selectedFiles.splice(index, 1); // Remove from our array
    renderPreviews(); // Re-render
}