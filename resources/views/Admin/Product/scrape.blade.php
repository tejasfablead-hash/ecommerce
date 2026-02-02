@extends('Admin.Pages.index')
@section('container')
    <main class="nxl-container">
        <div class="nxl-content">
            <!-- [ page-header ] start -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Scrape & Add Product</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Product</li>
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
                            <a href="{{ route('ProductViewPage') }}" class="btn btn-primary ">
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
                <div class="card mt-3">
                    <div class="card-body">
                        <p>Click the button below to scrape products and add to database.</p>
                        <button id="scrapeBtn" class="btn btn-success">Scrape & Add Products</button>
                    </div>

                    <div id="result" style="margin-top:20px;"></div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#scrapeBtn').click(function() {
                $(this).prop('disabled', true).text('Scraping...');
                $.ajax({
                    url: "{{ route('ScrapeproductPage') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: res.message
                            });
                            let html = "<ul>";
                            res.products.forEach(function(p) {
                                html += `<li>${p.name} - ${p.price} - ${p.qty} - ${p.status}</li>`;
                            });
                            html += "</ul>";
                            $('#result').html(html);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: res.message
                            });
                        }
                        $('#scrapeBtn').prop('disabled', false).text('Scrape & Add Products');
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!'
                        });
                        $('#scrapeBtn').prop('disabled', false).text('Scrape & Add Products');
                    }
                });
            });
        });
    </script>
@endpush
