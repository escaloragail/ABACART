@extends('layouts.admin')
@section('content')
<style>
    /* ── Add Category Layout (Spacious) ── */
    .category-add-card {
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

    .form-grid-full {
        grid-column: 1 / -1;
    }

    /* ── Form Inputs ── */
    .form-floating {
        position: relative;
    }
    
    .form-control {
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

    .form-control:focus {
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
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
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
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
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
    
    .img-preview-container {
        margin-bottom: 15px;
    }
    .img-preview-container img {
        max-width: 150px;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* ── Save Button ── */
    .btn-save-category {
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

    .btn-save-category:hover {
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
            <h3>Add Category</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.categories') }}"><div class="text-tiny">Categories</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">New Category</div></li>
            </ul>
        </div>
        
        <div class="category-add-card">
            <div class="ac-section-title">Category Information</div>

            @if ($errors->any())
                <div class="alert alert-danger" style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:20px; font-size:12px;">
                    <ul class="mb-0" style="margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-grid">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="name" placeholder="Category name" value="{{ old('name') }}" required>
                        <label>Category Name *</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="text" class="form-control" name="slug" placeholder="Category Slug" value="{{ old('slug') }}" required>
                        <label>Category Slug *</label>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="file-input-wrapper form-grid-full">
                        <div class="img-preview-container" id="imgpreview" style="display:none">
                            <img src="" alt="Image Preview">
                        </div>
                        <span class="file-input-label">Category Image *</span>
                        <input type="file" id="myFile" name="image" accept="image/*">
                    </div>
                </div>

                <button class="btn-save-category" type="submit">Publish Category</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(function() {
    // Image preview
    $("#myFile").on("change", function(e) {
        const [file] = this.files;
        if (file) {
            $("#imgpreview img").attr('src', URL.createObjectURL(file));
            $("#imgpreview").show();
        }
    });

    // Slug generation
    $("input[name='name']").on("change", function() {
        $("input[name='slug']").val(StringToSlug($(this).val()));
    });

    function StringToSlug(Text) {
        return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
    }
});
</script>
@endpush