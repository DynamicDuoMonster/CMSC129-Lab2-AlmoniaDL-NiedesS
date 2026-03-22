import './bootstrap';
function openPanel() {
    document.getElementById('sidePanel').classList.add('open');
    document.getElementById('overlay').style.display = 'block';
}

function closePanel() {
    document.getElementById('sidePanel').classList.remove('open');
    document.getElementById('overlay').style.display = 'none';
}

document.getElementById('openPanel').addEventListener('click', openPanel);

// Image upload
const dropZone    = document.getElementById('dropZone');
const fileInput   = document.getElementById('file-input');
const previewGrid = document.getElementById('previewGrid');
const placeholder = document.getElementById('placeholder');

dropZone.addEventListener('click', () => fileInput.click());
fileInput.addEventListener('click', (e) => e.stopPropagation());
fileInput.addEventListener('change', (e) => handleFiles(Array.from(e.target.files)));

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('drag-active');
});

dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-active'));

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('drag-active');
    const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
    handleFiles(files);
});

function handleFiles(files) {
    if (files.length === 0) return;
    placeholder.style.display = 'none';
    dropZone.classList.add('has-image');

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'preview-item-wrapper';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'image-preview-item';

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'remove-image-btn';
            removeBtn.textContent = '✕';
            removeBtn.addEventListener('click', (ev) => {
                ev.stopPropagation();
                wrapper.remove();
                if (previewGrid.children.length === 0) {
                    placeholder.style.display = 'flex';
                    dropZone.classList.remove('has-image');
                }
            });

            const addMore = document.querySelector('.add-more-overlay');
            if (addMore) addMore.remove();

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewGrid.appendChild(wrapper);

            const addMoreDiv = document.createElement('div');
            addMoreDiv.className = 'add-more-overlay';
            addMoreDiv.textContent = '+ Add More';
            previewGrid.appendChild(addMoreDiv);
        };
        reader.readAsDataURL(file);
    });
}
