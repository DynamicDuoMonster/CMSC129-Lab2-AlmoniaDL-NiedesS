{{-- Overlay --}}
<div class="panel-overlay" id="overlay" style="display:none;" onclick="closePanel()"></div>

{{-- Side Panel --}}
<div class="side-panel" id="sidePanel">
    <div class="panel-header">
        <h3>Add New Shoe</h3>
        <button class="close-btn" onclick="closePanel()">✕</button>
    </div>

    <form class="admin-form" method="POST" action="{{ route('admin.shoes.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="preview-zone" id="dropZone">
            <div class="preview-placeholder" id="placeholder">
                <span>Drop Images Here or Click to Upload</span>
                <p>(You can select multiple files)</p>
            </div>
            <div class="preview-grid" id="previewGrid"></div>
            <input type="file" id="file-input" name="images[]" accept="image/*" multiple style="display:none;" />
        </div>

        <input type="text" name="shoe_name" placeholder="Shoe Name" value="{{ old('shoe_name') }}" required />
        <input type="text" name="brand" placeholder="Brand (e.g. Nike)" value="{{ old('brand') }}" required />
        <input type="number" name="price" placeholder="Price" value="{{ old('price') }}" step="0.01" required />
        <input type="text" name="color" placeholder="Colors (comma separated)" value="{{ old('color') }}" required />

        <div class="select-row">
            <select name="category_id" required>
                <option value="">Select Category</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            
            <select name="gender">
                <option value="">Gender</option>
                <option value="Mens">Mens</option>
                <option value="Womens">Womens</option>
                <option value="Kids">Kids</option>
            </select>
        </div>

        <button type="submit" class="upload-btn">Add Product</button>
    </form>
</div>
