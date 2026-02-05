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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
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

            <div class="main-content">
            <div class="row mb-3">
    <div class="col-md-3">
        <select class="form-select" id="statusFilter">
            <option value="">-- All Orders --</option>
            <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ ($status ?? '') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="shipped" {{ ($status ?? '') == 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="delivered" {{ ($status ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="cancelled" {{ ($status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
</div></div>

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
                                                <th>TransactionId</th>
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
                                                    <td>{{ Str::limit($item->order_number, 10) }}</td>
                                                    <td>{{ Str::limit($item->transactionId, 10) }}</td>
                                                    <td>
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($item->orderitem as $orderItem)
                                                                <li class="d-flex align-items-center gap-1">
                                                                    <span class="fw-medium">
                                                                        {{ Str::limit($orderItem->product->name, 7) }}
                                                                    </span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>

                                                    <td>{{ $item->payment_method }}</td>
                                                    <td>{{ $item->payment_status }}</td>
                                                    <td>
                                                        <select class="form-select form-select-sm order-status"
                                                            data-id="{{ $item->id }}"
                                                            data-current="{{ $item->order_status }}">

                                                            <option value="pending"
                                                                {{ $item->order_status == 'pending' ? 'selected' : '' }}>
                                                                Pending
                                                            </option>
                                                            <option value="confirmed"
                                                                {{ $item->order_status == 'confirmed' ? 'selected' : '' }}>
                                                                Confirmed
                                                            </option>
                                                            <option value="shipped"
                                                                {{ $item->order_status == 'shipped' ? 'selected' : '' }}>
                                                                Shipped
                                                            </option>
                                                            <option value="delivered"
                                                                {{ $item->order_status == 'delivered' ? 'selected' : '' }}>
                                                                Delivered
                                                            </option>
                                                            <option value="cancelled"
                                                                {{ $item->order_status == 'cancelled' ? 'selected' : '' }}>
                                                                Cancelled
                                                            </option>
                                                        </select>
                                                    </td>

                                                    <td>{{ $item->grand_total }}</td>
                                                    <td>
                                                        <div class="hstack gap-2">
                                                            <a href="{{ route('OrderDetailViewPage', $item->id) }}"
                                                                class="avatar-text avatar-md">
                                                                <i class="feather feather-eye"></i>
                                                            </a>
                                                            {{-- <a href="javascript:void(0)"
                                                                class="btn-del avatar-text avatar-md"
                                                                data-id="{{ $item->id }}">
                                                                <i class="feather feather-trash-2"></i>
                                                            </a> --}}
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
@endsection
@push('scripts')
    <script src="{{ asset('ajax.js') }}"></script>

    <script>
    $('#statusFilter').on('change', function () {
        let status = $(this).val();
        let url = "{{ route('OrderViewPage') }}";

        if (status !== '') {
            url += '?status=' + status;
        }

        window.location.href = url;
    });
</script>

    <script>
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
    </script>
    <script>
        $(document).ready(function() {

        
            $(document).on('change', '.order-status', function(e) {
                e.preventDefault();

                let orderId = $(this).data('id');
                let status = $(this).val();
                var formData = new FormData();
                formData.append('order_id', orderId);
                formData.append('order_status', status);

                let url = "{{ route('OrderUpdateOrderPage') }}";
                reusableAjaxCall(url, 'POST', formData, function(response) {
                    if (response.status === true) {
                        Swal.fire('Updated!', response.message, 'success');
                    }
                }, function(xhr) {
                    let response = xhr.responseJSON;
                    if (response && response.message) {
                        Swal.fire('Failed!', response.message, 'error');
                    }
                });

            });


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
@endpush
