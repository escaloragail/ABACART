@extends('layouts.admin')
@section('content')

<div class="main-content-inner">

                            <div class="main-content-wrap">
                                <div class="tf-section-2 mb-30">
                                    <div class="flex gap20 flex-wrap-mobile">
                                        <div class="w-half">

                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-shopping-bag"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Total Orders</div>
                                                            <h4>{{ $total_orders }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-dollar-sign"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Total Amount</div>
                                                            <h4>{{ $total_amount }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-shopping-bag"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Pending Orders</div>
                                                            <h4>{{ $pending_count }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-dollar-sign"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Pending Orders Amount</div>
                                                            <h4>{{ $pending_amount }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="w-half">

                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-shopping-bag"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Delivered Orders</div>
                                                            <h4>{{ $delivered_count }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-dollar-sign"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Delivered Orders Amount</div>
                                                            <h4>{{ $delivered_amount }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default mb-20">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-shopping-bag"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Canceled Orders</div>
                                                            <h4>{{ $canceled_count }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="wg-chart-default">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap14">
                                                        <div class="image ic-bg">
                                                            <i class="icon-dollar-sign"></i>
                                                        </div>
                                                        <div>
                                                            <div class="body-text mb-2">Canceled Orders Amount</div>
                                                            <h4>{{ $canceled_amount }}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="wg-box">
                                        <div class="flex items-center justify-between">
                                            <h5>Earnings revenue</h5>
                                        </div>
                                        <div class="flex flex-wrap gap40 mt-3 pt-3">
                                            <div>
                                                <div class="mb-2">
                                                    <div class="block-legend">
                                                        <div class="dot t1"></div>
                                                        <div class="text-tiny">Total Revenue This Year</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap10">
                                                    <h4>${{ number_format(array_sum($monthlyTotals), 2) }}</h4>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="mb-2">
                                                    <div class="block-legend">
                                                        <div class="dot t2"></div>
                                                        <div class="text-tiny">Delivered This Year</div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap10">
                                                    <h4>${{ number_format(array_sum($monthlyDelivered), 2) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="line-chart-8"></div>
                                    </div>

                                </div>
                                <div class="tf-section mb-30">

                                    <div class="wg-box">
                                        <div class="flex items-center justify-between">
                                            <h5>Recent orders</h5>
                                            <div class="dropdown default">
                                                <a class="btn btn-secondary dropdown-toggle" href="#">
                                                    <span class="view-all">View all</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="wg-table table-all-user">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 80px">OrderNo</th>
                                                            <th>Name</th>
                                                            <th class="text-center">Phone</th>
                                                            <th class="text-center">Subtotal</th>
                                                            <th class="text-center">Tax</th>
                                                            <th class="text-center">Total</th>

                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Order Date</th>
                                                            <th class="text-center">Total Items</th>
                                                            <th class="text-center">Delivered On</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($recent_orders as $order)
                                                        <tr>
                                                            <td class="text-center">{{ $order->Order_ID }}</td>
                                                            <td class="text-center">{{ $order->user->name ?? 'Guest' }}</td>
                                                            <td class="text-center">{{ $order->address->phone ?? 'N/A' }}</td>
                                                            <td class="text-center">${{ $order->subtotal }}</td>
                                                            <td class="text-center">${{ $order->tax }}</td>
                                                            <td class="text-center">${{ $order->total }}</td>

                                                            <td class="text-center">{{ $order->order_status }}</td>
                                                            <td class="text-center">{{ $order->created_at }}</td>
                                                            <td class="text-center">{{ $order->orderItems->count() }}</td>
                                                            <td></td>
                                                            <td class="text-center">
                                                                <a href="{{ route('admin.order.details', ['order_id' => $order->Order_ID]) }}">
                                                                    <div class="list-icon-function view-icon">
                                                                        <div class="item eye">
                                                                            <i class="icon-eye"></i>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

@endsection

@push('scripts')
<script>
    (function ($) {
        var tfLineChart = (function () {
            var chartBar = function () {
                var options = {
                    series: [{
                        name: 'Total',
                        data: {!! json_encode($monthlyTotals) !!}
                    }, {
                        name: 'Pending',
                        data: {!! json_encode($monthlyPending) !!}
                    }, {
                        name: 'Delivered',
                        data: {!! json_encode($monthlyDelivered) !!}
                    }, {
                        name: 'Canceled',
                        data: {!! json_encode($monthlyCanceled) !!}
                    }],
                    chart: {
                        type: 'bar',
                        height: 325,
                        toolbar: { show: false },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '10px',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: { enabled: false },
                    legend: { show: false },
                    colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                    stroke: { show: false },
                    xaxis: {
                        labels: {
                            style: { colors: '#212529' },
                        },
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    },
                    yaxis: { show: false },
                    fill: { opacity: 1 },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "$ " + val;
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#line-chart-8"), options);
                if ($("#line-chart-8").length > 0) {
                    chart.render();
                }
            };

            return {
                load: function () {
                    chartBar();
                }
            };
        })();

        $(window).on("load", function () {
            tfLineChart.load();
        });
    })(jQuery);
</script>
@endpush