document.addEventListener('DOMContentLoaded', function () {

    // Initialize the logic for all 4 boxes
    for (let i = 0; i < 4; i++) {
        initCustomDropzone(i);
    }

    function initCustomDropzone(index) {
        const dropzone = document.getElementById(`dropzone-${index}`);
        const fileInput = document.getElementById(`fileInput${index}`);
        const previewContainer = document.getElementById(`previewContainer${index}`);

        // DataTransfer object acts like a virtual shopping cart for our files
        let dt = new DataTransfer();

        if (!dropzone || !fileInput) return;

        // 1. Handle Drag & Drop Visuals
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
            dropzone.addEventListener(eventName, () => dropzone.classList.add('drag-active'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
            dropzone.addEventListener(eventName, () => dropzone.classList.remove('drag-active'), false);
        });

        // 2. Handle File Drops
        dropzone.addEventListener('drop', function (e) {
            const files = e.dataTransfer.files;
            handleFiles(files);
        }, false);

        // 3. Handle Browse Clicks
        fileInput.addEventListener('change', function (e) {
            const files = e.target.files;
            handleFiles(files);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function handleFiles(files) {
            // Add new files to our virtual cart
            for (let i = 0; i < files.length; i++) {
                dt.items.add(files[i]);
            }

            // Sync virtual cart back to the hidden input so the backend can read it!
            fileInput.files = dt.files;

            // Update the UI
            updatePreviews();
        }

        function updatePreviews() {
            previewContainer.innerHTML = '';

            // Loop through all files currently in our input
            Array.from(fileInput.files).forEach((file, fileIndex) => {

                const col = document.createElement('div');
                col.className = 'col-6 col-sm-4 col-md-3 col-lg-2';

                const wrapper = document.createElement('div');
                wrapper.className = 'preview-wrapper';

                // Determine file type for preview
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        wrapper.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                } else {
                    // It's a PDF or Document
                    wrapper.innerHTML = `
                        <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-light position-absolute w-100 top-0 start-0 p-2 text-center">
                            <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                            <span style="font-size: 0.65rem; word-break: break-all; line-height: 1;">${file.name}</span>
                        </div>
                    `;
                }

                // Add Remove Button
                const removeBtn = document.createElement('button');
                removeBtn.className = 'btn btn-danger remove-btn';
                removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                removeBtn.onclick = function (e) {
                    e.preventDefault();
                    removeFile(fileIndex);
                };

                wrapper.appendChild(removeBtn);
                col.appendChild(wrapper);
                previewContainer.appendChild(col);
            });
        }

        function removeFile(indexToRemove) {
            // Rebuild the virtual cart without the deleted file
            const newDt = new DataTransfer();
            const currentFiles = fileInput.files;

            for (let i = 0; i < currentFiles.length; i++) {
                if (i !== indexToRemove) {
                    newDt.items.add(currentFiles[i]);
                }
            }

            // Sync it back to the input and update UI
            dt = newDt;
            fileInput.files = dt.files;
            updatePreviews();
        }
    }

    // Submit button UX feedback
    const form = document.getElementById('ordinanceForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> UPLOADING...';
        });
    }
});