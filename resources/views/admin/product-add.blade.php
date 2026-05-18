@extends('layouts.admin')
@section('content')

<style>
    /* ── Add Product Layout (Spacious) ── */
    .product-add-card {
        background: #fff;
        border-radius: 16px;
        padding: 40px 50px;
        border: 1px solid #e2e8f0;
        margin-top: 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px 30px;
        margin-bottom: 30px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px 30px;
        margin-bottom: 30px;
    }

    .form-grid-full {
        grid-column: 1 / -1;
    }

    /* ── Form Inputs ── */
    .form-floating {
        position: relative;
    }
    
    .form-control, .form-select {
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 14px !important;
        color: #111 !important;
        background-color: #fff !important;
        transition: all 0.2s ease !important;
        height: 58px !important;
        padding: 1.6rem 1.2rem 0.6rem !important;
        width: 100%;
        display: block;
        box-shadow: none !important;
    }

    .form-select {
        padding-top: 1.4rem !important;
        padding-bottom: 0.4rem !important;
    }

    textarea.form-control {
        height: auto !important;
        min-height: 100px;
        padding-top: 1.6rem !important;
        resize: vertical;
    }

    .form-control:focus, .form-select:focus {
        border-color: #111 !important;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
        outline: none !important;
    }

    .form-floating > label {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        padding: 1.2rem 1.2rem;
        pointer-events: none;
        transform-origin: 0 0;
        font-family: 'Inter', sans-serif !important;
        font-size: 12px !important;
        color: #a0aec0 !important;
        transition: opacity .1s ease-in-out,transform .1s ease-in-out !important;
        text-transform: uppercase !important;
        font-weight: 700 !important;
        letter-spacing: 0.05em !important;
    }

    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label,
    .form-floating > .form-select ~ label {
        color: #111 !important;
        transform: scale(.85) translateY(-0.6rem) translateX(0.15rem);
    }

    /* ── File Inputs ── */
    .file-input-wrapper {
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        background: #f8fafc;
        transition: all 0.2s ease;
    }
    .file-input-wrapper:hover {
        border-color: #94a3b8;
        background: #f1f5f9;
    }
    .file-input-label {
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 10px;
        display: block;
    }
    .file-input-wrapper input[type="file"] {
        font-size: 12px;
        color: #475569;
        max-width: 100%;
    }

    /* ── Save Button ── */
    .btn-save-product {
        background: #111;
        color: #fff;
        border: none;
        padding: 16px 40px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-block;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        width: 100%;
        margin-top: 15px;
    }

    .btn-save-product:hover {
        background: #2d3748;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }
    
    .ac-section-title { 
        display: flex;
        align-items: center;
        gap: 12px; 
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.15em; 
        color: #111;
        text-transform: uppercase;
        margin-bottom: 30px;
    }
    .ac-section-title::before {
        content: "";
        width: 24px;
        height: 2px;
        background: #111;
        display: inline-block;
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.products') }}"><div class="text-tiny">Products</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add product</div></li>
            </ul>
        </div>
        
        <div class="product-add-card">
            <div class="ac-section-title">Product Details</div>

            @if ($errors->any())
                <div class="alert alert-danger" style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:20px; font-size:12px;">
                    <ul class="mb-0" style="margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-grid">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="product_name" placeholder="Product name" value="{{ old('product_name') }}" required>
                        <label>Product Name *</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" name="product_slug" placeholder="Slug" value="{{ old('product_slug') }}" required>
                        <label>Slug *</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-select" name="Category_ID" required>
                            <option value=""></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->Category_ID }}" {{ old('Category_ID') == $category->Category_ID ? 'selected' : '' }}>{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        <label>Category *</label>
                    </div>

                    <div class="form-floating">
                        <input type="text" class="form-control" name="SKU" placeholder="SKU" value="{{ old('SKU') }}" required>
                        <label>SKU *</label>
                    </div>

                    <div class="form-floating">
                        <input type="number" class="form-control" name="regular_price" placeholder="Regular Price" value="{{ old('regular_price') }}" required>
                        <label>Regular Price (₱) *</label>
                    </div>

                    <div class="form-floating">
                        <input type="number" class="form-control" name="sale_price" placeholder="Sale Price" value="{{ old('sale_price') }}">
                        <label>Sale Price (₱)</label>
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-floating">
                        <input type="number" class="form-control" name="quantity" placeholder="Quantity" value="{{ old('quantity') }}" required>
                        <label>Stock Quantity *</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-select" name="featured" required>
                            <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Yes</option>
                        </select>
                        <label>Featured *</label>
                    </div>

                    <div class="form-floating">
                        <select class="form-select" name="is_on_sale" required>
                            <option value="0" {{ old('is_on_sale') == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('is_on_sale') == '1' ? 'selected' : '' }}>Yes</option>
                        </select>
                        <label>On Sale *</label>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-floating form-grid-full">
                        <textarea class="form-control" name="short_description" placeholder="Short Description" required>{{ old('short_description') }}</textarea>
                        <label>Short Description *</label>
                    </div>

                    <div class="form-floating form-grid-full">
                        <textarea class="form-control" name="product_description" placeholder="Product Description" required style="min-height: 120px;">{{ old('product_description') }}</textarea>
                        <label>Full Description *</label>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="file-input-wrapper">
                        <span class="file-input-label">Main Product Image *</span>
                        <input type="file" name="main_product_image" required accept="image/*">
                    </div>
                    <div class="file-input-wrapper">
                        <span class="file-input-label">Gallery Images (Optional)</span>
                        <input type="file" name="sub_product_images[]" multiple accept="image/*">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-floating form-grid-full" style="display:none;">
                        <select class="form-select" name="is_active" required>
                            <option value="1" selected>Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <button class="btn-save-product" type="submit">Publish Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $("input[name='product_name']").keyup(function(){
        $("input[name='product_slug']").val($(this).val().toLowerCase().replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-'));
    });
</script>
@endpush
