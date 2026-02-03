@extends('Admin.Pages.index')
@section('container')
    <main class="nxl-container">
        <div class="nxl-content">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Event</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item">Event</li>
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

            <div class="main-content">
                <div class="row">
                    <!-- Add Event Form -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <form id="eventForm">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <input type="text" name="title" class="form-control" placeholder="Event Title"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="date" name="event_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="description" class="form-control"
                                            placeholder="Description">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button type="submit" class="btn btn-success">Add Event</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        @include('Admin.Pages.footer')
    </main>
    <script src="{{ asset('ajax.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            console.log('FullCalendar type:', typeof FullCalendar);


            const calendar = new FullCalendar.Calendar(
                document.getElementById('calendar'), {
                    initialView: 'dayGridMonth',
                    events: @json($calendarEvents)
                }
            );

            calendar.render();

            $('#eventForm').on('submit', function(e) {
                e.preventDefault();
                let url = "{{ route('EventStorePage') }}";
                let formData = new FormData();
                reusableAjaxCall(url, 'POST', formData, function(response) {
                    if (response.status) {
                        calendar.addEvent({
                            title: response.event.title,
                            start: response.event.event_date,
                            description: response.event.description
                        });
                        $('#eventForm')[0].reset();
                        alert('Event Added');
                    }
                });
            });

        });
    </script>
@endsection
