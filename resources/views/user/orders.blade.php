@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__orders-list">
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    <ul class="nav nav-tabs mb-4" id="orderTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button">All Orders</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="ordered-tab" data-bs-toggle="tab" data-bs-target="#ordered" type="button">Ordered</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="delivered-tab" data-bs-toggle="tab" data-bs-target="#delivered" type="button">Delivered</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="canceled-tab" data-bs-toggle="tab" data-bs-target="#canceled" type="button">Canceled</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="orderTabsContent">
                        <!-- All Orders -->
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            @include('user.partials.order-table', ['orders_list' => $orders])
                            <div class="mt-4">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                        <!-- Ordered -->
                        <div class="tab-pane fade" id="ordered" role="tabpanel">
                            @include('user.partials.order-table', ['orders_list' => $ordered_orders])
                        </div>

                        <!-- Delivered -->
                        <div class="tab-pane fade" id="delivered" role="tabpanel">
                            @include('user.partials.order-table', ['orders_list' => $delivered_orders])
                        </div>

                        <!-- Canceled -->
                        <div class="tab-pane fade" id="canceled" role="tabpanel">
                            @include('user.partials.order-table', ['orders_list' => $canceled_orders])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
