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
<style>
    /* Custom SweetAlert Black & White Aesthetic */
    .swal-modal {
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 20px;
    }
    .swal-title {
        font-family: 'Inter', sans-serif;
        color: #111;
        font-weight: 800;
        font-size: 20px;
        margin-bottom: 10px;
    }
    .swal-text {
        font-family: 'Inter', sans-serif;
        color: #64748b;
        text-align: center;
        font-size: 14px;
    }
    .swal-button {
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        padding: 12px 30px;
        font-size: 11px;
        transition: all 0.2s ease;
    }
    .swal-button--cancel {
        background-color: #fff !important;
        color: #111 !important;
        border: 1px solid #111 !important;
        box-shadow: none !important;
    }
    .swal-button--cancel:hover {
        background-color: #f1f5f9 !important;
    }
    .swal-button--confirm {
        background-color: #111 !important;
        color: #fff !important;
        border: 1px solid #111 !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;
    }
    .swal-button--confirm:hover {
        background-color: #2d3748 !important;
    }
    .swal-icon {
        display: none !important;
    }
</style>
<script>
    $(function(){
        $('.delete').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Deactivate Product?",
                text: "The product will be hidden from the store but not deleted.",
                buttons: {
                    cancel: {
                        text: "No, Keep It",
                        value: null,
                        visible: true,
                        className: "swal-button--cancel",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, Deactivate",
                        value: true,
                        visible: true,
                        className: "swal-button--confirm",
                        closeModal: true
                    }
                }
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
                buttons: {
                    cancel: {
                        text: "No, Cancel",
                        value: null,
                        visible: true,
                        className: "swal-button--cancel",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, Reactivate",
                        value: true,
                        visible: true,
                        className: "swal-button--confirm",
                        closeModal: true
                    }
                }
            }).then(function (result) {
                if (result) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush