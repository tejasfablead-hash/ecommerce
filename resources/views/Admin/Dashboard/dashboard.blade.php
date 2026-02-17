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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
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
                     <div class="card mt-4">
    <div class="card-header">
        <h5>Latest Orders</h5>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Customer</th>
                    <th>Order ID</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Order</th>
                    <th>Total</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($latestOrders as $order)
                {{-- @if ($order->order_status == "confirmed") --}}
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset('storage/user/'.($order->getcustomer->image ?? 'default.png')) }}"
                                 width="40" class="rounded-circle">

                            <span class="text-capitalize">
                                {{ $order->getcustomer->name ?? 'Guest' }}
                            </span>
                        </div>
                    </td>

                    <td>{{ Str::limit($order->order_number, 10) }}</td>

                    <td>{{ ucfirst($order->payment_method) }}</td>

                    <td>{{ $order->created_at->format('d M Y') }}</td>

                    <td>
                        @if($order->payment_status=='paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif($order->payment_status=='pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-danger">Cancelled</span>
                        @endif
                    </td>

                    <td>
                        <span class="badge bg-primary">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>

                    <td>₹{{ number_format($order->grand_total,2) }}</td>

                    <td class="text-end">
                        <a href="{{ route('OrderDetailViewPage',$order->id) }}">
                            <i class="feather-eye"></i>
                        </a>
                    </td>

                </tr>
                {{-- @endif --}}
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No orders found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-3">

            <div class="text-muted">
                Showing
                {{ $latestOrders->firstItem() ?? 0 }}
                to
                {{ $latestOrders->lastItem() ?? 0 }}
                of
                {{ $latestOrders->total() }} entries
            </div>

            <div>
                {{ $latestOrders->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('ajax.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    {{-- <script>
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('#leadList').DataTable({
                    pageLength: 10,
                    order: [
                        [0, 'desc']
                    ]
                });
            } else {
                console.error('DataTable not loaded');
            }
        });
    </script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    height: 350,
                    type: 'bar', // only bar chart now
                    toolbar: {
                        show: false
                    }
                },

                series: [{
                    name: 'Orders',
                    data: @json($monthlyOrders->values())
                }],

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
                    title: {
                        text: 'Orders'
                    },
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

                legend: {
                    show: false
                }
            };

            new ApexCharts(document.querySelector("#payment-records-chart"), options).render();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var revenueOptions = {
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: {
                        show: false
                    }
                },

                series: [{
                    name: 'Revenue',
                    data: @json($monthlyRevenue->values())
                }],

                xaxis: {
                    categories: @json($monthlyRevenue->keys())
                },

                stroke: {
                    curve: 'smooth',
                    width: 3
                },

                markers: {
                    size: 4
                },

                yaxis: {
                    title: {
                        text: 'Revenue (₹)'
                    }
                },

                colors: ['#28a745'],

                tooltip: {
                    y: {
                        formatter: function(val) {
                            return '₹' + val.toFixed(2);
                        }
                    }
                }
            };

            new ApexCharts(
                document.querySelector("#total-sales-color-graph"),
                revenueOptions
            ).render();

        });
    </script>
@endpush
