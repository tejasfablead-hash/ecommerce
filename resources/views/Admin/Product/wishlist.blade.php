@extends('Admin.Pages.index')
@section('container')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Wishlist</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Wishlist</li>
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
                                                <th>Product Name</th>
                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($wishlist as $item)
                                               
                                                <tr class="single-item text-capitalize">
                            
                                                    <td>{{ $item->customer->name }}</td>
                                                    <td>{{ $item->product->name }}</td>
                                                 
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
    </main>@endsection
@push('scripts')
    <script src="{{ asset('ajax.js') }}"></script>
<script>
    $(document).ready(function () {
        if ($.fn.DataTable) {
            $('#leadList').DataTable({
                pageLength: 10,
                order: [[0, 'desc']]
            });
        } else {
            console.error('DataTable not loaded');
        }
    });
</script>
    <script>
        // $(document).ready(function() {

        //     $('#leadList').on('click', '.btn-del', function(e) {
        //         e.preventDefault();

        //         let id = $(this).data('id');
        //         let row = $(this).closest('tr');
        //         let url = '/product-delete/' + id;
        //         Swal.fire({
        //             title: 'Are you sure?',
        //             text: "Once deleted, you will not be able to recover this record!",
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonText: 'Yes, delete it!',
        //             cancelButtonText: 'No, cancel!'
        //         }).then((result) => {
        //             console.log('result', result);
        //             if (result.value == true) {
        //                 $.ajax({
        //                     url: url,
        //                     type: 'DELETE',
        //                     headers: {
        //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                     },
        //                     success: function(response) {
        //                         row.remove();
        //                         Swal.fire('Deleted!', response.message, 'success');
        //                     },
        //                     error: function(err) {
        //                         Swal.fire('Error!', 'Something went wrong.', 'error');
        //                         console.log(err);
        //                     }
        //                 });
        //             } else if (result.dismiss === Swal.DismissReason.cancel) {
        //                 Swal.fire('Cancelled', 'Your record is safe :)', 'info');
        //             }
        //         });

        //     });

        // });
    </script>
@endpush