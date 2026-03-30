import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {

    // ── ADD PANEL ────────────────────────────────────────────────
    window.openPanel = function () {
        document.getElementById('sidePanel').classList.add('open');
        document.getElementById('overlay').style.display = 'block';
    };

    window.closePanel = function () {
        document.getElementById('sidePanel').classList.remove('open');
        document.getElementById('overlay').style.display = 'none';
    };

    const openPanelBtn = document.getElementById('openPanel');
    if (openPanelBtn) {
        openPanelBtn.addEventListener('click', window.openPanel);
    }

    const dropZone    = document.getElementById('dropZone');
    const fileInput   = document.getElementById('file-input');
    const previewGrid = document.getElementById('previewGrid');
    const placeholder = document.getElementById('placeholder');

    if (dropZone) {
        setupImageUpload(dropZone, fileInput, previewGrid, placeholder);
    }

    // ── EDIT PANEL ───────────────────────────────────────────────
    const editDropZone    = document.getElementById('editDropZone');
    const editFileInput   = document.getElementById('edit-file-input');
    const editPreviewGrid = document.getElementById('editPreviewGrid');
    const editPlaceholder = document.getElementById('editPlaceholder');

    window.openEditPanel = function (shoe) {
        const panel   = document.getElementById('editSidePanel');
        const overlay = document.getElementById('editOverlay');
        const form    = document.getElementById('editShoeForm');

        if (!panel || !form) return;

        form.action = `/admin/shoes/${shoe.id}`;

        document.getElementById('edit_shoe_name').value = shoe.shoe_name ?? '';
        document.getElementById('edit_brand').value     = shoe.brand     ?? '';
        document.getElementById('edit_price').value     = shoe.price     ?? '';
        document.getElementById('edit_color').value     = Array.isArray(shoe.color)
            ? shoe.color.join(', ')
            : (shoe.color ?? '');
        document.getElementById('edit_category_id').value = shoe.category_id ?? '';
        document.getElementById('edit_gender').value    = shoe.gender    ?? '';

        // Rebuild image grid
        editPreviewGrid.innerHTML = '';
        const images = shoe.image_url ?? [];

        if (images.length > 0) {
            editPlaceholder.style.display = 'none';
            images.forEach(url => {
                const wrapper = createExistingImageWrapper(url, editPreviewGrid, editPlaceholder, editDropZone);
                editPreviewGrid.appendChild(wrapper);
            });
            appendAddMoreButton(editPreviewGrid);
        } else {
            editPlaceholder.style.display = 'flex';
        }

        panel.classList.add('open');
        overlay.style.display = 'block';
    };

    window.closeEditPanel = function () {
        document.getElementById('editSidePanel').classList.remove('open');
        document.getElementById('editOverlay').style.display = 'none';
    };

    if (editDropZone) {
        setupImageUpload(editDropZone, editFileInput, editPreviewGrid, editPlaceholder);
    }

    // ── SHARED HELPERS ───────────────────────────────────────────

    /**
     * Wire up click-to-browse + drag-and-drop on a drop zone.
     *
     * KEY FIX: Uses a DataTransfer object as a "file store" so the real
     * File objects are kept in sync with the visual preview grid.
     * On form submit, fileStore.files is assigned to the input so Laravel
     * receives the files via $request->hasFile('images').
     */
    function setupImageUpload(zone, input, grid, placeholder) {
        if (!zone || !input) return;

        const fileStore = new DataTransfer();

        // Assign real files to the input right before form submission
        const form = zone.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                input.files = fileStore.files;
            });
        }

        zone.addEventListener('click', () => input.click());
        input.addEventListener('click', e => e.stopPropagation());
        input.addEventListener('change', e => {
            handleFiles(Array.from(e.target.files), grid, placeholder, zone, fileStore);
            e.target.value = '';
        });

        zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-active'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('drag-active'));
        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('drag-active');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            handleFiles(files, grid, placeholder, zone, fileStore);
        });
    }

    /**
     * Read new local files and append preview wrappers.
     * Also adds each File to fileStore so it survives until submit.
     */
    function handleFiles(files, grid, placeholder, zone, fileStore) {
        if (files.length === 0) return;

        placeholder.style.display = 'none';
        removeAddMoreButton(grid);

        files.forEach(file => {
            fileStore.items.add(file);

            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = createNewImageWrapper(e.target.result, file, grid, placeholder, zone, fileStore);
                grid.appendChild(wrapper);
                appendAddMoreButton(grid);
            };
            reader.readAsDataURL(file);
        });
    }

    /**
     * Wrapper for a NEW (locally-selected) image.
     * Removing it also removes the File from fileStore.
     */
    function createNewImageWrapper(src, file, grid, placeholder, zone, fileStore) {
        const wrapper = document.createElement('div');
        wrapper.className = 'preview-item-wrapper';

        const img = document.createElement('img');
        img.src       = src;
        img.className = 'image-preview-item';
        wrapper.appendChild(img);

        const removeBtn = buildRemoveButton(() => {
            const remaining = Array.from(fileStore.files).filter(f => f !== file);
            while (fileStore.items.length) fileStore.items.remove(0);
            remaining.forEach(f => fileStore.items.add(f));

            wrapper.remove();
            maybeShowPlaceholder(grid, placeholder, zone);
        });
        wrapper.appendChild(removeBtn);

        return wrapper;
    }

    /**
     * Wrapper for an EXISTING (server-side) image.
     * Removing it switches the hidden input name to 'delete_images[]'
     * so the controller knows to remove it from Cloudinary.
     */
    function createExistingImageWrapper(url, grid, placeholder, zone) {
        const wrapper = document.createElement('div');
        wrapper.className = 'preview-item-wrapper';

        const img = document.createElement('img');
        img.src       = url;
        img.className = 'image-preview-item';
        wrapper.appendChild(img);

        const hidden = document.createElement('input');
        hidden.type  = 'hidden';
        hidden.name  = 'existing_images[]';
        hidden.value = url;
        wrapper.appendChild(hidden);

        const removeBtn = buildRemoveButton(() => {
            hidden.name            = 'delete_images[]';
            wrapper.style.opacity  = '0.35';
            wrapper.style.outline  = '2px solid #ff4444';
            removeBtn.replaceWith(buildUndoButton(hidden, wrapper, removeBtn));
            maybeShowPlaceholder(grid, placeholder, zone);
        });
        wrapper.appendChild(removeBtn);

        return wrapper;
    }

    function buildRemoveButton(onClick) {
        const btn = document.createElement('button');
        btn.type        = 'button';
        btn.className   = 'remove-image-btn';
        btn.textContent = '✕';
        btn.title       = 'Remove image';
        btn.addEventListener('click', e => { e.stopPropagation(); onClick(); });
        return btn;
    }

    function buildUndoButton(hidden, wrapper, originalRemoveBtn) {
        const btn = document.createElement('button');
        btn.type        = 'button';
        btn.className   = 'remove-image-btn undo-image-btn';
        btn.textContent = '↩';
        btn.title       = 'Undo removal';
        btn.addEventListener('click', e => {
            e.stopPropagation();
            hidden.name           = 'existing_images[]';
            wrapper.style.opacity = '1';
            wrapper.style.outline = '';
            btn.replaceWith(originalRemoveBtn);
        });
        return btn;
    }

    function appendAddMoreButton(grid) {
        removeAddMoreButton(grid);
        const div = document.createElement('div');
        div.className   = 'add-more-overlay';
        div.textContent = '+ Add More';
        grid.appendChild(div);
    }

    function removeAddMoreButton(grid) {
        grid.querySelector('.add-more-overlay')?.remove();
    }

    function maybeShowPlaceholder(grid, placeholder, zone) {
        const remaining = grid.querySelectorAll('.preview-item-wrapper');
        const anyActive = Array.from(remaining).some(
            w => w.querySelector('input[name="existing_images[]"]') || !w.querySelector('input')
        );
        if (!anyActive) {
            removeAddMoreButton(grid);
            placeholder.style.display = 'flex';
            zone.classList.remove('has-image');
        }
    }
});
