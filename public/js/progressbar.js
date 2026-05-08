// 1. Wait for the page to load
document.addEventListener("DOMContentLoaded", function () {

    let selectedFiles = [];
    const fileInput = document.getElementById('fileInput');
    const container = document.getElementById('image-preview-container');
    let xhr;

    if (!fileInput || !container) {
        console.error("Missing fileInput or container in HTML!");
        return;
    }

    // 2. HANDLE FILE SELECTION & PREVIEWS
    fileInput.addEventListener('change', function (event) {
        try {
            const newFiles = Array.from(event.target.files);
            selectedFiles = [...selectedFiles, ...newFiles];
            renderPreviews();
        } catch (err) {
            alert("Error loading files: " + err.message);
        }
    });

    function renderPreviews() {
        container.innerHTML = '';
        const dataTransfer = new DataTransfer();

        selectedFiles.forEach((file, index) => {
            dataTransfer.items.add(file);
            const fileUrl = URL.createObjectURL(file);
            const isVideo = file.type.startsWith('video/');

            const col = document.createElement('div');
            col.className = 'col-auto mb-3';

            let mediaHtml = isVideo
                ? `<video src="${fileUrl}" class="img-thumbnail" style="height: 120px; width: 120px; object-fit: cover; border-radius: 8px;" muted></video>
                       <div style="position: absolute; top: 5px; left: 5px; background: rgba(0,0,0,0.7); color: white; font-size: 0.65rem; padding: 2px 6px; border-radius: 4px; font-weight: bold; pointer-events: none; z-index: 5;">
                           <i class="bi bi-play-fill"></i> VIDEO
                       </div>`
                : `<img src="${fileUrl}" class="img-thumbnail" style="height: 120px; width: 120px; object-fit: cover; border-radius: 8px;">`;

            col.innerHTML = `
                    <div class="preview-wrapper" style="position: relative; display: inline-block; overflow: hidden; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <button type="button" class="btn btn-danger btn-sm remove-btn" 
                                style="position: absolute; top: -5px; right: -5px; z-index: 30; width: 24px; height: 24px; padding: 0; line-height: 1; border-radius: 50%;" 
                                onclick="removeImage(${index})">&times;</button>
                        ${mediaHtml}
                        <div class="file-progress-overlay d-none" id="overlay-${index}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 10;"></div>
                        <div class="file-progress-text d-none" id="text-${index}" style="position: absolute; top: 35%; left: 0; width: 100%; text-align: center; color: white; font-weight: 900; font-size: 1.2rem; text-shadow: 0 2px 5px rgba(0,0,0,1); z-index: 20;">0%</div>
                        <div class="file-progress-bar d-none w-100 px-2" id="bar-container-${index}" style="position: absolute; bottom: 12px; left: 0; z-index: 20;">
                            <div class="progress shadow-sm" style="height: 8px; border-radius: 4px; background: rgba(255,255,255,0.4);">
                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" id="bar-${index}" role="progressbar" style="width: 0%;"></div>
                            </div>
                        </div>
                    </div>
                `;
            container.appendChild(col);
        });

        fileInput.files = dataTransfer.files;
    }

    window.removeImage = function (index) {
        if (fileInput.files[index]) {
            URL.revokeObjectURL(URL.createObjectURL(fileInput.files[index]));
        }
        selectedFiles.splice(index, 1);
        renderPreviews();
    };

    // 3. HANDLE THE FORM SUBMISSION
    let form = document.getElementById('eventForm');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Stop standard reload instantly

            // THE ALARM SYSTEM: If anything fails here, it pops up an alert!
            try {
                let formData = new FormData(form);
                let submitBtn = document.getElementById('submitBtn');
                let progressContainer = document.getElementById('progress-container');

                if (progressContainer) {
                    progressContainer.classList.remove('d-none');
                    progressContainer.classList.add('d-block');
                }

                submitBtn.disabled = true;

                // Hide Red X buttons
                document.querySelectorAll('.remove-btn').forEach(btn => btn.style.display = 'none');

                // Show Overlays
                selectedFiles.forEach((file, i) => {
                    let overlay = document.getElementById('overlay-' + i);
                    let text = document.getElementById('text-' + i);
                    let barContainer = document.getElementById('bar-container-' + i);

                    if (overlay) overlay.classList.remove('d-none');
                    if (text) text.classList.remove('d-none');
                    if (barContainer) barContainer.classList.remove('d-none');
                });

                xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Accept', 'application/json');

                // The Cascading Math Magic
                xhr.upload.onprogress = function (event) {
                    if (event.lengthComputable) {
                        let currentLoaded = event.loaded;

                        selectedFiles.forEach((file, index) => {
                            let bar = document.getElementById('bar-' + index);
                            let text = document.getElementById('text-' + index);

                            if (bar && text) {
                                if (currentLoaded >= file.size) {
                                    bar.style.width = '100%';
                                    text.innerText = '100%';
                                    bar.classList.remove('progress-bar-animated');
                                    currentLoaded -= file.size;
                                } else if (currentLoaded > 0) {
                                    let percent = Math.round((currentLoaded / file.size) * 100);
                                    bar.style.width = percent + '%';
                                    text.innerText = percent + '%';
                                    currentLoaded = 0;
                                } else {
                                    bar.style.width = '0%';
                                    text.innerText = '0%';
                                }
                            }
                        });

                        let globalBar = document.getElementById('progress-bar');
                        let globalText = document.getElementById('progress-text');
                        if (globalBar && globalText) {
                            let totalPercent = Math.round((event.loaded / event.total) * 100);
                            globalBar.style.width = totalPercent + '%';
                            globalText.innerText = 'Uploading Package... ' + totalPercent + '%';
                        }
                    }
                };

                xhr.onload = function () {
                    if (xhr.status === 200 || xhr.status === 201) {
                        selectedFiles.forEach((file, i) => {
                            let text = document.getElementById('text-' + i);
                            if (text) text.innerText = 'DONE';
                        });
                        setTimeout(function () { window.location.reload(); }, 1500);
                    } else {
                        let response = JSON.parse(xhr.responseText);
                        alert(response.message || 'An error occurred. Check file sizes.');
                        resetUI();
                    }
                };

                xhr.onabort = function () {
                    alert('Upload cancelled by user.');
                    resetUI();
                };

                xhr.send(formData);

            } catch (error) {
                // IF THE SCRIPT CRASHES, IT WILL TELL US WHY HERE!
                alert("JavaScript Error detected: " + error.message);
                console.error(error);
            }

            function resetUI() {
                let submitBtn = document.getElementById('submitBtn');
                let progressContainer = document.getElementById('progress-container');

                if (submitBtn) submitBtn.disabled = false;
                if (progressContainer) {
                    progressContainer.classList.remove('d-block');
                    progressContainer.classList.add('d-none');
                }

                document.querySelectorAll('.remove-btn').forEach(btn => btn.style.display = 'block');
                selectedFiles.forEach((file, i) => {
                    let overlay = document.getElementById('overlay-' + i);
                    let text = document.getElementById('text-' + i);
                    let barContainer = document.getElementById('bar-container-' + i);
                    let bar = document.getElementById('bar-' + i);

                    if (overlay) overlay.classList.add('d-none');
                    if (text) text.classList.add('d-none');
                    if (barContainer) barContainer.classList.add('d-none');
                    if (bar) bar.style.width = '0%';
                });
            }
        });
    }

    let cancelBtn = document.getElementById('cancel-btn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            if (xhr) xhr.abort();
        });
    }
});