@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('admin.products') }}"><div class="text-tiny">Products</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Edit product</div></li>
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
                <form class="form-new-product form-style-1" action="{{ route('admin.product.update', ['id' => $product->Product_ID]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="product_name" tabindex="0" value="{{ $product->product_name }}" aria-required="true" required="">
                    </fieldset>
                    
                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="product_slug" tabindex="0" value="{{ $product->product_slug }}" aria-required="true" required="">
                    </fieldset>

                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select class="" name="Category_ID" required>
                                <option value="">Choose category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->Category_ID }}" {{ $product->Category_ID == $category->Category_ID ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>


                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="short_description" placeholder="Short description" tabindex="0" aria-required="true" required="">{{ $product->short_description }}</textarea>
                    </fieldset>

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="product_description" placeholder="Description" tabindex="0" aria-required="true" required="">{{ $product->product_description }}</textarea>
                    </fieldset>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Regular price" name="regular_price" tabindex="0" value="{{ $product->regular_price }}" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price</div>
                            <input class="mb-10" type="text" placeholder="Sale price" name="sale_price" tabindex="0" value="{{ $product->sale_price }}">
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="SKU" name="SKU" tabindex="0" value="{{ $product->SKU }}" aria-required="true" required="">
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Quantity" name="quantity" tabindex="0" value="{{ $product->quantity }}" aria-required="true" required="">
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock Status <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="stock_status" required>
                                    <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="outofstock" {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="featured" required>
                                    <option value="0" {{ $product->featured == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $product->featured == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">On Sale <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="is_on_sale" required>
                                    <option value="0" {{ $product->is_on_sale == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $product->is_on_sale == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <fieldset class="image">
                        <div class="body-title mb-10">Main Image (Leave empty to keep current)</div>
                        <input type="file" name="main_product_image" accept="image/*">
                        @if($product->main_product_image)
                            <div class="mt-10">
                                <img src="{{ asset('uploads/products/thumbnails/' . $product->main_product_image) }}" alt="Current Image" width="100">
                            </div>
                        @endif
                    </fieldset>

                    <fieldset class="image">
                        <div class="body-title mb-10">Gallery Images (Leave empty to keep current)</div>
                        <input type="file" name="sub_product_images[]" multiple accept="image/*">
                        @if($product->sub_product_images)
                            <div class="mt-10 d-flex gap-2 flex-wrap">
                                @foreach(explode(',', $product->sub_product_images) as $image)
                                    <img src="{{ asset('uploads/products/thumbnails/' . $image) }}" alt="Gallery Image" width="100">
                                @endforeach
                            </div>
                        @endif
                    </fieldset>

                    <div class="bot">
                        <button class="tf-button w208" type="submit">Update</button>
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
