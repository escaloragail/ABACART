@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Products</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Products</div></li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <!-- Search form can go here -->
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}">
                        <i class="icon-plus"></i>Add new
                    </a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if (Session::has('success'))
                            <p class="alert alert-success">{{ Session::get('success') }}</p>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Category</th>
                                    <th>Featured</th>
                                    <th>Stock</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->Product_ID }}</td>
                                    <td>
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $product->main_product_image }}" alt="" class="image">
                                        </div>
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>${{ $product->regular_price }}</td>
                                    <td>{{ $product->category->category_name ?? 'Unknown' }}</td>
                                    <td>{{ $product->featured == 1 ? 'Yes' : 'No' }}</td>
                                    <td>{{ $product->stock_status }}</td>
                                    <td>
                                        <div class="qty-control d-flex align-items-center gap-2">
                                            <form action="{{ route('admin.product.quantity.update', ['id' => $product->Product_ID]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">-</button>
                                            </form>
                                            <span>{{ $product->quantity }}</span>
                                            <form action="{{ route('admin.product.quantity.update', ['id' => $product->Product_ID]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{ route('admin.product.edit', ['id' => $product->Product_ID]) }}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{ route('admin.product.delete', ['id' => $product->Product_ID]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(function(){
        $('.delete').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to delete this product?",
                type: "warning",
                buttons: ["No", "Yes"],
                confirmButtonColor: "#dc3545"
            }).then(function (result) {
                if (result) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
