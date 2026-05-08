const officialModal = new bootstrap.Modal(document.getElementById('officialModal'));

// 1. Open the Modal and load existing draft data if it exists
function openOfficialModal(key, title) {
    // Set the active key and title
    document.getElementById('modal-current-key').value = key;
    document.getElementById('modal-position').value = title;

    // Load data from hidden inputs into the modal
    document.getElementById('modal-name').value = document.getElementById('hidden-name-' + key).value;
    document.getElementById('modal-dept').value = document.getElementById('hidden-dept-' + key).value;
    document.getElementById('modal-dob').value = document.getElementById('hidden-dob-' + key).value;
    document.getElementById('modal-pob').value = document.getElementById('hidden-pob-' + key).value;
    document.getElementById('modal-civil').value = document.getElementById('hidden-civil-' + key).value;
    document.getElementById('modal-citizen').value = document.getElementById('hidden-citizen-' + key).value;
    document.getElementById('modal-desc').value = document.getElementById('hidden-desc-' + key).value;

    // Reset file input in modal
    document.getElementById('modal-photo-input').value = "";

    // Show current image in modal
    const currentImgSrc = document.getElementById('preview-img-' + key).src;
    if (currentImgSrc && !currentImgSrc.includes('default-avatar.png')) {
        document.getElementById('modal-photo-preview').src = currentImgSrc;
        document.getElementById('modal-photo-preview').classList.remove('d-none');
        document.getElementById('modal-photo-placeholder').classList.add('d-none');
    } else {
        document.getElementById('modal-photo-preview').classList.add('d-none');
        document.getElementById('modal-photo-placeholder').classList.remove('d-none');
    }

    officialModal.show();
}

// 2. Image Preview inside the Modal
function previewModalImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('modal-photo-preview').src = e.target.result;
            document.getElementById('modal-photo-preview').classList.remove('d-none');
            document.getElementById('modal-photo-placeholder').classList.add('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// 3. Save "Draft" Info to Main Chart & Hidden Inputs
function saveDraftInformation() {
    const key = document.getElementById('modal-current-key').value;

    // Save text data to hidden form inputs
    const nameVal = document.getElementById('modal-name').value;
    document.getElementById('hidden-name-' + key).value = nameVal;
    document.getElementById('hidden-dept-' + key).value = document.getElementById('modal-dept').value;
    document.getElementById('hidden-dob-' + key).value = document.getElementById('modal-dob').value;
    document.getElementById('hidden-pob-' + key).value = document.getElementById('modal-pob').value;
    document.getElementById('hidden-civil-' + key).value = document.getElementById('modal-civil').value;
    document.getElementById('hidden-citizen-' + key).value = document.getElementById('modal-citizen').value;
    document.getElementById('hidden-desc-' + key).value = document.getElementById('modal-desc').value;

    // Update UI Chart Name
    document.getElementById('preview-name-' + key).innerText = nameVal ? nameVal : 'NAME';
    document.getElementById('preview-name-' + key).classList.remove('text-muted');

    // Move the file input physically into the main form so it gets submitted to the DB
    const fileInput = document.getElementById('modal-photo-input');
    if (fileInput.files.length > 0) {
        // Update UI Chart Image
        document.getElementById('preview-img-' + key).src = document.getElementById('modal-photo-preview').src;

        // Clone the file input and place it in the hidden container
        const clonedInput = fileInput.cloneNode(true);
        clonedInput.name = `officials[${key}][photo]`;
        clonedInput.id = `final-photo-${key}`;

        const container = document.getElementById(`file-input-container-${key}`);
        container.innerHTML = ''; // clear old
        container.appendChild(clonedInput);
    }

    // Close modal
    officialModal.hide();
}