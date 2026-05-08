function openLightbox(imageSource) {
    // 1. Grab the empty image tag inside the modal
    const lightboxImage = document.getElementById('lightboxMainImage');

    // 2. Change its source to the image that was clicked
    lightboxImage.src = imageSource;

    // 3. Trigger the Bootstrap modal to show up
    const lightboxModal = new bootstrap.Modal(document.getElementById('imageLightbox'));
    lightboxModal.show();
}