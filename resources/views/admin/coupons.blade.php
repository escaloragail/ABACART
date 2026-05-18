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
<script>
    $(function(){
        $('.delete').on('click', function(e){
            e.preventDefault();
            var form = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to delete this coupon?",
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
