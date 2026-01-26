@extends('Admin.Pages.index')

@section('container')
<style>
    #payment-records-chart {
        min-height: 350px;
        width: 100%;
    }
</style>

<div class="nxl-container">
    <div class="nxl-content">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                </ul>
            </div>
            <div class="page-header-right ms-auto">
                <div class="page-header-right-items">
                    <div class="d-flex d-md-none">
                        <a href="javascript:void(0)" class="page-header-right-close-toggle">
                            <i class="feather-arrow-left me-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                        <!-- Optional header items -->
                    </div>
                </div>
            </div>
        </div>

        <!-- COUNT CARDS -->
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-3 col-md-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Categories</h6>
                                <h3>{{ $category }}</h3>
                            </div>
                            <i class="feather-grid fs-1 text-primary"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Products</h6>
                                <h3>{{ $product }}</h3>
                            </div>
                            <i class="feather-box fs-1 text-success"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Orders</h6>
                                <h3>{{ $order }}</h3>
                            </div>
                            <i class="feather-shopping-cart fs-1 text-warning"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <div>
                                <h6>Customers</h6>
                                <h3>{{ $user }}</h3>
                            </div>
                            <i class="feather-users fs-1 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CHARTS -->
        <div class="main-content">
            <div class="row">
                
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Total Revenue</h5>
                        </div>
                        <div class="card-body">
                            <h3 class="mb-3">₹{{ number_format($totalRevenue, 2) }}</h3>
                            <div id="total-sales-color-graph"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Monthly Orders</h5>
                        </div>
                        <div class="card-body">
                            <div id="payment-records-chart"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- LATEST ORDERS TABLE -->
        <div class="main-content">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Latest Orders</h5>
                        </div>

                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Payment</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Order Status</th>
                                        <th scope="col">Total</th>
                                        <th scope="col" class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($latestOrders as $order)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('storage/user/' . ($order->getcustomer->image ?? 'default.png')) }}"
                                                         alt="{{ $order->getcustomer->name ?? 'Guest' }}"
                                                         class="rounded-circle" width="40">
                                                    <div>
                                                        <div>{{ $order->getcustomer->name ?? 'Guest' }}</div>
                                                        <small class="text-muted">{{ $order->email }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ ucfirst($order->payment_method) }}
                                                </span>
                                            </td>

                                            <td>{{ $order->created_at->format('d M Y') }}</td>

                                            <td>
                                                @if ($order->payment_status == 'paid')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($order->payment_status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @endif
                                            </td>

                                            <td>
                                                <span class="badge bg-primary text-white">
                                                    {{ ucfirst($order->order_status) }}
                                                </span>
                                            </td>

                                            <td>₹{{ number_format($order->grand_total, 2) }}</td>

                                            <td class="text-end">
                                                <a href="{{ route('OrderDetailViewPage', $order->id) }}">
                                                    <i class="feather-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($latestOrders->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">No orders found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var options = {
        chart: {
            height: 350,
            type: 'bar', // only bar chart now
            toolbar: { show: false }
        },

        series: [
            {
                name: 'Orders',
                data: @json($monthlyOrders->values())
            }
        ],

        plotOptions: {
            bar: {
                columnWidth: '35%',
                borderRadius: 4
            }
        },

        xaxis: {
            categories: @json($monthlyOrders->keys())
        },

        yaxis: {
            title: { text: 'Orders' },
            min: 0
        },

        colors: ['#5A5AFB'],

        tooltip: {
            y: {
                formatter: function(val) {
                    return val;
                }
            }
        },

        legend: { show: false }
    };

    new ApexCharts(document.querySelector("#payment-records-chart"), options).render();
});
</script>




@endsection
