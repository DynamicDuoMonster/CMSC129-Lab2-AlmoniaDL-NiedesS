import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    // --- ADD PANEL LOGIC ---
    const openPanelBtn = document.getElementById('openPanel');
    if (openPanelBtn) {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('file-input');
        const previewGrid = document.getElementById('previewGrid');
        const placeholder = document.getElementById('placeholder');

        window.openPanel = function () {
            document.getElementById('sidePanel').classList.add('open');
            document.getElementById('overlay').style.display = 'block';
        }

        window.closePanel = function () {
            document.getElementById('sidePanel').classList.remove('open');
            document.getElementById('overlay').style.display = 'none';
        }

        // NEW: Global functions for EDIT form
        window.openEditPanel = function (shoe) {
            const panel = document.getElementById('editSidePanel');
            const overlay = document.getElementById('editOverlay');
            const form = document.getElementById('editShoeForm');

            if (panel && form) {
                // Set dynamic form action for the Update route
                form.action = `/admin/shoes/${shoe.id}`;

                // Populate fields based on your Shoe model attributes
                document.getElementById('edit_shoe_name').value = shoe.shoe_name;
                document.getElementById('edit_brand').value = shoe.brand;
                document.getElementById('edit_price').value = shoe.price;

                // Convert the color array back to comma-separated string for the input
                document.getElementById('edit_color').value = Array.isArray(shoe.color) ? shoe.color.join(', ') : shoe.color;

                document.getElementById('edit_category').value = shoe.category || '';
                document.getElementById('edit_gender').value = shoe.gender || '';

                // Handle Image Preview Grid
                const grid = document.getElementById('editPreviewGrid');
                grid.innerHTML = '';
                if (shoe.image_url && shoe.image_url.length > 0) {
                    shoe.image_url.forEach(url => {
                        const img = document.createElement('img');
                        img.src = url;
                        img.className = 'image-preview-item'; // Using your existing class
                        grid.appendChild(img);
                    });
                }

                panel.classList.add('open');
                overlay.style.display = 'block';
            }
        }

        window.closeEditPanel = function () {
            document.getElementById('editSidePanel').classList.remove('open');
            document.getElementById('editOverlay').style.display = 'none';
        }

        setupImageUpload(editDropZone, editFileInput, editPreviewGrid, editPlaceholder);
    }

    // --- SHARED HELPER FUNCTIONS ---

    function setupImageUpload(zone, input, grid, placeholder) {
        if (!zone || !input) return;

        zone.addEventListener('click', () => input.click());
        input.addEventListener('click', (e) => e.stopPropagation());
        input.addEventListener('change', (e) => handleFiles(Array.from(e.target.files), grid, placeholder, zone));

        zone.addEventListener('dragover', (e) => { e.preventDefault(); zone.classList.add('drag-active'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('drag-active'));
        zone.addEventListener('drop', (e) => {
            e.preventDefault();
            zone.classList.remove('drag-active');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            handleFiles(files, grid, placeholder, zone);
        });
    }

    function handleFiles(files, grid, placeholder, zone) {
        if (files.length === 0) return;
        placeholder.style.display = 'none';
        zone.classList.add('has-image');

        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const wrapper = createPreviewWrapper(e.target.result, true, grid, placeholder, zone);

                // Manage the "+ Add More" overlay
                const existingAddMore = grid.querySelector('.add-more-overlay');
                if (existingAddMore) existingAddMore.remove();

                grid.appendChild(wrapper);

                const addMoreDiv = document.createElement('div');
                addMoreDiv.className = 'add-more-overlay';
                addMoreDiv.textContent = '+ Add More';
                grid.appendChild(addMoreDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    function createPreviewWrapper(src, isNew, grid, placeholder, zone) {
        const wrapper = document.createElement('div');
        wrapper.className = 'preview-item-wrapper';

        const img = document.createElement('img');
        img.src = src;
        img.className = 'image-preview-item';

        wrapper.appendChild(img);

        if (isNew) {
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-image-btn';
            removeBtn.textContent = '✕';
            removeBtn.addEventListener('click', (ev) => {
                ev.stopPropagation();
                wrapper.remove();
                if (grid.querySelectorAll('.preview-item-wrapper').length === 0) {
                    placeholder.style.display = 'flex';
                    zone.classList.remove('has-image');
                    const addMore = grid.querySelector('.add-more-overlay');
                    if (addMore) addMore.remove();
                }
            });
            wrapper.appendChild(removeBtn);
        }

        return wrapper;
    }
});