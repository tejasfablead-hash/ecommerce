@extends('Admin.Pages.index')
@section('container')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Order</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Order</li>
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
                          <a href="{{ route('DashboardPage') }}" class="btn btn-primary ">
                                <i class="feather-arrow-left me-2"></i>
                                <span>Back</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ page-header ] end -->

            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="leadList">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>OrderId</th>
                                                <th>Product Name</th>
                                                <th>Payment Method</th>
                                                <th>Payment Status</th>
                                                <th>Order Status</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order as $item)
                                                <tr class="single-item text-capitalize">

                                                    <td>{{ $item->getcustomer->name }}</td>
                                                    <td>{{ $item->order_number }}</td>

                                                    <td>
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($item->orderitem as $orderItem)
                                                                <li class="d-flex align-items-center gap-1">
                                                                    <span class="fw-medium">
                                                                        {{ Str::limit($orderItem->product->name, 10) }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>

                                                    <td>{{ $item->payment_method }}</td>
                                                    <td>{{ $item->payment_status }}</td>
                                                    <td>{{ $item->order_status }}</td>
                                                    <td>{{ $item->grand_total }}</td>
                                                    <td>
                                                        <div class="hstack gap-2">
                                                            <a href="{{ route('OrderDetailViewPage', $item->id) }}"
                                                                class="avatar-text avatar-md">
                                                                <i class="feather feather-eye"></i>
                                                            </a>
                                                            <a href="javascript:void(0)"
                                                                class="btn-del avatar-text avatar-md"
                                                                data-id="{{ $item->id }}">
                                                                <i class="feather feather-trash-2"></i>
                                                            </a>
                                                        </div>
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
            <!-- [ Main Content ] end -->
        </div>
        <!-- [ Footer ] start -->
        @include('Admin.Pages.footer')
        <!-- [ Footer ] end -->
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/select2-active.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/leads-init.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // $('#leadList').on('click', '.btn-del', function(e) {
            //     e.preventDefault();

            //     let id = $(this).data('id');
            //     let row = $(this).closest('tr');
            //     let url = '/product-delete/' + id;
            //     Swal.fire({
            //         title: 'Are you sure?',
            //         text: "Once deleted, you will not be able to recover this record!",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonText: 'Yes, delete it!',
            //         cancelButtonText: 'No, cancel!'
            //     }).then((result) => {
            //         console.log('result', result);
            //         if (result.value == true) {
            //             $.ajax({
            //                 url: url,
            //                 type: 'DELETE',
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 success: function(response) {
            //                     row.remove();
            //                     Swal.fire('Deleted!', response.message, 'success');
            //                 },
            //                 error: function(err) {
            //                     Swal.fire('Error!', 'Something went wrong.', 'error');
            //                     console.log(err);
            //                 }
            //             });
            //         } else if (result.dismiss === Swal.DismissReason.cancel) {
            //             Swal.fire('Cancelled', 'Your record is safe :)', 'info');
            //         }
            //     });

            // });

        });
    </script>
@endsection
