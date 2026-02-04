@extends('Admin.Pages.index')
@section('container')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Feedback</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Feedback</li>
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
                                                <th>Order Id</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Rating</th>
                                                <th>Message</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($feedback as $item)
                                                <tr class="single-item ">
                                                    <td class="text-capitalize">{{ $item->getorder->order_number }}</td>

                                                    <td class="text-capitalize">{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td class="text-capitalize">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $item->subject)
                                                                <span style="color:#0c0c0b;font-size:18px;">★</span>
                                                            @else
                                                                <span style="color:#ddd;font-size:18px;">★</span>
                                                            @endif
                                                        @endfor
                                                    </td>
                                                    <td class="text-capitalize">{{ $item->message }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{-- <div class="mt-3 d-flex justify-content-end">
                                    {{ $feedback->withQueryString()->links('pagination::bootstrap-5') }}
                                </div> --}}
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
@endpush
