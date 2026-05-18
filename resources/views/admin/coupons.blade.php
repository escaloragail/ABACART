@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Coupons</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Coupons</div></li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <!-- Search form can go here -->
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.coupon.add') }}">
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
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Cart Value</th>
                                    <th>Expiry Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $coupon)
                                <tr>
                                    <td class="td-id">#{{ $coupon->Coupon_ID }}</td>
                                    <td><strong>{{ $coupon->code }}</strong></td>
                                    <td>
                                        @if($coupon->type == 'fixed')
                                            <span class="modern-badge bg-warning-soft">Fixed Amount</span>
                                        @else
                                            <span class="modern-badge bg-info-soft">Percentage</span>
                                        @endif
                                    </td>
                                    <td>{{ $coupon->type == 'fixed' ? '₱' : '' }}{{ $coupon->value }}{{ $coupon->type == 'percent' ? '%' : '' }}</td>
                                    <td>₱{{ $coupon->cart_value }}</td>
                                    <td>{{ \Carbon\Carbon::parse($coupon->expiry_date)->format('M d Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.coupon.edit', ['id' => $coupon->Coupon_ID]) }}" class="btn-action-pill">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.coupon.delete', ['id' => $coupon->Coupon_ID]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn-action-pill btn-delete delete">
                                                    Delete
                                                </button>
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
                    {{ $coupons->links('pagination::bootstrap-5') }}
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
                title: "Delete Coupon?",
                text: "Are you sure you want to delete this coupon?",
                buttons: {
                    cancel: {
                        text: "No, Keep It",
                        value: null,
                        visible: true,
                        className: "swal-button--cancel",
                        closeModal: true,
                    },
                    confirm: {
                        text: "Yes, Delete",
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
