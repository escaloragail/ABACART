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
                <div class="flex items-center justify-between gap10 flex-wrap mb-3">
                    <div class="modern-filter-tabs">
                        <a href="{{ route('admin.products', ['show' => 'active']) }}"
                           class="modern-tab {{ ($show ?? 'active') == 'active' ? 'active' : '' }}">
                            Active <span class="count-badge">{{ $activeCount }}</span>
                        </a>
                        <a href="{{ route('admin.products', ['show' => 'inactive']) }}"
                           class="modern-tab {{ ($show ?? '') == 'inactive' ? 'active' : '' }}">
                            Inactive <span class="count-badge">{{ $inactiveCount }}</span>
                        </a>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}">
                        <i class="icon-plus"></i>Add new
                    </a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive modern-table-wrap">
                        @if (Session::has('success'))
                            <p class="alert alert-success">{{ Session::get('success') }}</p>
                        @endif
                        <table class="table modern-table">
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td class="td-id">#{{ $product->Product_ID }}</td>
                                    <td>
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $product->main_product_image }}" alt="" class="image">
                                        </div>
                                    </td>
                                    <td><strong>{{ $product->product_name }}</strong></td>
                                    <td class="td-price">₱{{ $product->regular_price }}</td>
                                    <td>{{ $product->category->category_name ?? 'Unknown' }}</td>
                                    <td>
                                        @if($product->featured == 1)
                                            <span class="modern-badge bg-warning-soft">Yes</span>
                                        @else
                                            <span class="modern-badge bg-secondary-soft">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->quantity > 0)
                                            <span class="modern-badge bg-success-soft">In Stock</span>
                                        @else
                                            <span class="modern-badge bg-danger-soft">Out of Stock</span>
                                        @endif
                                    </td>
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
                                        @if($product->is_active)
                                            <span class="modern-badge bg-success-soft">Active</span>
                                        @else
                                            <span class="modern-badge bg-danger-soft">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.product.edit', ['id' => $product->Product_ID]) }}" class="btn-action-pill">
                                                Edit
                                            </a>
                                            @if($product->is_active)
                                                <form action="{{ route('admin.product.delete', ['id' => $product->Product_ID]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn-action-pill btn-delete delete">
                                                        Deactivate
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.product.reactivate', ['id' => $product->Product_ID]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn-action-pill reactivate">
                                                        Reactivate
                                                    </button>
                                                </form>
                                            @endif
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
                title: "Deactivate Product?",
                text: "The product will be hidden from the store but not deleted.",
                type: "warning",
                buttons: ["No", "Yes, Deactivate"],
                confirmButtonColor: "#dc3545"
            }).then(function (result) {
                if (result) {
                    form.submit();
                }
            });
        });
        $('.reactivate').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Reactivate Product?",
                text: "The product will be visible in the store again.",
                type: "info",
                buttons: ["No", "Yes, Reactivate"],
            }).then(function (result) {
                if (result) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
