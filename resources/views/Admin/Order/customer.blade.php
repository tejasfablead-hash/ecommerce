@extends('Admin.Pages.index')
@section('container')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Customer</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item">Customer</li>
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
                                                <th>Email</th>
                                                <th>Google_Id</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach ($user as $item)
                                                @if ($item->role === 'customer')
                                                    <tr class="single-item ">
                                                        <td class="text-capitalize  ">
                                                            <img src="{{ asset('storage/user/' . $item->image) }}"
                                                                alt="" class="img-fluid" height="25px" width="25px"/>

                                                            {{ $item->name }}
                                                        </td>
                                                        <td>{{ $item->email }}</td>
                                                        @if (empty($item->google_id))
                                                            <td class="text-capitalize"> - </td>
                                                        @else
                                                            <td class="text-capitalize">{{ $item->google_id }}</td>
                                                        @endif

                                                        <td>{{ $item->phone }}</td>
                                                        <td class="text-capitalize">{{ $item->address }}</td>
                                                      
                                                    </tr>
                                                    
                                                @endif
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
        // $(document).ready(function() {

        //     $('#leadList').on('click', '.btn-del', function(e) {
        //         e.preventDefault();

        //         let id = $(this).data('id');
        //         let row = $(this).closest('tr');
        //         let url = '/category-delete/' + id;

        //         Swal.fire({
        //             title: 'Are you sure?',
        //             text: "Once deleted, you will not be able to recover this record!",
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonText: 'Yes, delete it!',
        //             cancelButtonText: 'No, cancel!'
        //         }).then((result) => {
        //             console.log('result',result);
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
@endsection
