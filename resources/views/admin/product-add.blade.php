@extends('layouts.admin')
@section('content')
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
            
            <div class="wg-box">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="form-new-product form-style-1" action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="product_name" tabindex="0" value="{{ old('product_name') }}" aria-required="true" required="">
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="product_slug" tabindex="0" value="{{ old('product_slug') }}" aria-required="true" required="">
                    </fieldset>

                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="Category_ID" required>
                                <option value="">Choose category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->Category_ID }}" {{ old('Category_ID') == $category->Category_ID ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>


                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="short_description" placeholder="Short description" tabindex="0" aria-required="true" required="">{{ old('short_description') }}</textarea>
                    </fieldset>

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="product_description" placeholder="Description" tabindex="0" aria-required="true" required="">{{ old('product_description') }}</textarea>
                    </fieldset>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Regular price" name="regular_price" tabindex="0" value="{{ old('regular_price') }}" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price</div>
                            <input class="mb-10" type="text" placeholder="Sale price" name="sale_price" tabindex="0" value="{{ old('sale_price') }}">
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="SKU" name="SKU" tabindex="0" value="{{ old('SKU') }}" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Quantity" name="quantity" tabindex="0" value="{{ old('quantity') }}" aria-required="true" required="">
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock Status <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="stock_status" required>
                                    <option value="instock" {{ old('stock_status') == 'instock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="outofstock" {{ old('stock_status') == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="featured" required>
                                    <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">On Sale <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="is_on_sale" required>
                                    <option value="0" {{ old('is_on_sale') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('is_on_sale') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <fieldset class="image">
                        <div class="body-title mb-10">Main Image <span class="tf-color-1">*</span></div>
                        <input type="file" name="main_product_image" required accept="image/*">
                    </fieldset>

                    <fieldset class="image">
                        <div class="body-title mb-10">Gallery Images</div>
                        <input type="file" name="sub_product_images[]" multiple accept="image/*">
                    </fieldset>

                    <div class="bot">
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
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
