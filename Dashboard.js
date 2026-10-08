document.addEventListener('DOMContentLoaded', () => {
    const photo = document.getElementById('avatar');
    let previewUrl;
    photo?.addEventListener('change', () => {
        const status = document.getElementById('photo-selection');
        const file = photo.files[0];
        photo.setCustomValidity('');
        if (!file) { status.textContent = ''; return; }
        if (file.size > 1048576 || !['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            status.textContent = 'Choisissez une photo JPG, PNG ou WebP de moins de 1 Mo.';
            photo.setCustomValidity(status.textContent);
            photo.reportValidity();
            return;
        }
        if (previewUrl) URL.revokeObjectURL(previewUrl);
        previewUrl = URL.createObjectURL(file);
        const image = new Image();
        image.alt = 'Aperçu de votre nouvelle photo';
        image.src = previewUrl;
        document.querySelector('.profile-avatar').replaceChildren(image);
        status.textContent = 'Photo sélectionnée. Cliquez sur Enregistrer pour la sauvegarder.';
        const remove = document.querySelector('[name="remove_avatar"]');
        if (remove) remove.checked = false;
    });
});
