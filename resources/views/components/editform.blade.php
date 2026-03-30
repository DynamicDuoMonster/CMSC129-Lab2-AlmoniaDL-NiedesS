{{-- Modal Overlay --}}
<div class="modal-overlay" id="editOverlay" style="display:none;" onclick="closeEditPanel()"></div>

{{-- Edit Modal --}}
<div class="edit-modal" id="editSidePanel">
    <div class="modal-header">
        <h3>Edit Shoe</h3>
        <button class="close-btn" onclick="closeEditPanel()">✕</button>
    </div>

    <form class="admin-form" id="editShoeForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="preview-zone" id="editDropZone">
            <div class="preview-placeholder" id="editPlaceholder" style="display: none;">
                <span>Drop Images Here or Click to Upload</span>
                <p>(New images will be added to the gallery)</p>
            </div>

            {{-- Existing Images Grid --}}
            <div class="preview-grid" id="editPreviewGrid">
                {{-- Populated by JavaScript when the edit button is clicked --}}
            </div>

            <input type="file" id="edit-file-input" name="images[]" accept="image/*" multiple style="display:none;" />
        </div>

        <div class="modal-fields">
            <input type="text" name="shoe_name" id="edit_shoe_name" placeholder="Shoe Name" required />
            <input type="text" name="brand" id="edit_brand" placeholder="Brand (e.g. Nike)" required />

            <div class="field-row">
                <input type="number" name="price" id="edit_price" placeholder="Price" step="0.01" required />
                <input type="text" name="color" id="edit_color" placeholder="Colors (comma separated)" required />
            </div>

            <div class="select-row">
                <select name="category" id="edit_category">
                    <option value="">Category</option>
                    <option value="Sports">Sports</option>
                    <option value="Lifestyle">Lifestyle</option>
                    <option value="Running">Running</option>
                    <option value="Basketball">Basketball</option>
                </select>
                <select name="gender" id="edit_gender">
                    <option value="">Gender</option>
                    <option value="Mens">Mens</option>
                    <option value="Womens">Womens</option>
                    <option value="Kids">Kids</option>
                    <option value="Unisex">Unisex</option>
                </select>
            </div>
        </div>

        <button type="submit" class="upload-btn">Update Product</button>
    </form>
</div>
