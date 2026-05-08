// Function to open the modal for a specific position
function openOfficialModal(positionKey, positionTitle) {
    // Set the current position key
    document.getElementById('modal-current-key').value = positionKey;

    // Set the position title in the modal
    document.getElementById('modal-position').value = positionTitle;

    // Load existing data if available (from hidden inputs)
    document.getElementById('modal-name').value = document.getElementById('hidden-name-' + positionKey).value || '';
    document.getElementById('modal-dept').value = document.getElementById('hidden-dept-' + positionKey).value || '';
    document.getElementById('modal-dob').value = document.getElementById('hidden-dob-' + positionKey).value || '';
    document.getElementById('modal-pob').value = document.getElementById('hidden-pob-' + positionKey).value || '';
    document.getElementById('modal-civil').value = document.getElementById('hidden-civil-' + positionKey).value || '';
    document.getElementById('modal-citizen').value = document.getElementById('hidden-citizen-' + positionKey).value || '';
    document.getElementById('modal-desc').value = document.getElementById('hidden-desc-' + positionKey).value || '';

    // Reset photo preview and handle existing photos
    const photoPreview = document.getElementById('modal-photo-preview');
    const photoPlaceholder = document.getElementById('modal-photo-placeholder');
    const existingPhotoPath = document.getElementById('existing-photo-path-' + positionKey).value;

    // Reset file input
    document.getElementById('modal-photo-input').value = '';

    if (existingPhotoPath && existingPhotoPath.trim() !== '') {
        // Use the photo path URL to display image (faster than base64)
        photoPreview.src = existingPhotoPath;
        photoPreview.style.display = 'block';
        photoPreview.classList.remove('d-none');
        photoPlaceholder.style.display = 'none';
        photoPlaceholder.classList.add('d-none');
    } else {
        // Show placeholder for new/empty position
        photoPreview.src = '';
        photoPreview.style.display = 'none';
        photoPreview.classList.add('d-none');
        photoPlaceholder.style.display = 'flex';
        photoPlaceholder.classList.remove('d-none');
    }

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('officialModal'));
    modal.show();
}

// Store file references globally to use during form submission
const officialFiles = {};

// Function to save the information from modal to hidden inputs and update preview
function saveDraftInformation() {
    const positionKey = document.getElementById('modal-current-key').value;

    // Save to hidden inputs
    document.getElementById('hidden-name-' + positionKey).value = document.getElementById('modal-name').value;
    document.getElementById('hidden-dept-' + positionKey).value = document.getElementById('modal-dept').value;
    document.getElementById('hidden-dob-' + positionKey).value = document.getElementById('modal-dob').value;
    document.getElementById('hidden-pob-' + positionKey).value = document.getElementById('modal-pob').value;
    document.getElementById('hidden-civil-' + positionKey).value = document.getElementById('modal-civil').value;
    document.getElementById('hidden-citizen-' + positionKey).value = document.getElementById('modal-citizen').value;
    document.getElementById('hidden-desc-' + positionKey).value = document.getElementById('modal-desc').value;

    // Update preview card name
    const namePreview = document.getElementById('preview-name-' + positionKey);
    const nameValue = document.getElementById('modal-name').value;
    namePreview.textContent = nameValue || 'NAME';
    namePreview.style.color = nameValue ? '#333' : '#999';

    // Handle photo file input and update preview
    const photoInput = document.getElementById('modal-photo-input');
    const photoPreview = document.getElementById('modal-photo-preview');
    const cardPreviewImg = document.getElementById('preview-img-' + positionKey);

    if (photoInput.files && photoInput.files[0]) {
        // Store the file reference
        officialFiles[positionKey] = photoInput.files[0];

        // Create or update the file input in the form
        const fileInputContainer = document.getElementById('file-input-container-' + positionKey);
        fileInputContainer.innerHTML = ''; // Clear existing

        // Create a hidden file input to be submitted with the form
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'file';
        hiddenInput.name = 'officials[' + positionKey + '][photo]';
        hiddenInput.id = 'file-' + positionKey;
        hiddenInput.style.display = 'none';
        hiddenInput.className = 'd-none';

        // We'll use JavaScript to set the files
        fileInputContainer.appendChild(hiddenInput);

        // Update card preview image with new upload
        const reader = new FileReader();
        reader.onload = function(e) {
            cardPreviewImg.src = e.target.result;
        };
        reader.readAsDataURL(photoInput.files[0]);
    }
    // If no new file, keep existing card image as is (don't change it)

    // Close the modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('officialModal'));
    modal.hide();
}

// Function to preview image in modal
function previewModalImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const photoPreview = document.getElementById('modal-photo-preview');
            const photoPlaceholder = document.getElementById('modal-photo-placeholder');

            photoPreview.src = e.target.result;
            photoPreview.style.display = 'block';
            photoPreview.classList.remove('d-none');
            photoPlaceholder.style.display = 'none';
            photoPlaceholder.classList.add('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
