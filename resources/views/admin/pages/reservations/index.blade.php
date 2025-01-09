@extends('layouts.admin')
@section('title', 'Appointments')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-alerts />
        <x-heading href="" icon="ri-add-line me-1_5" headingText="Appointments" data-bs-toggle="modal"
            data-bs-target="#newScheduleModal">
            New Patient
        </x-heading>
        <!-- Modal for New Schedule (Booking a New Reservation) -->
        <div class="modal fade" id="newScheduleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">New Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col mb-6 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" placeholder="Patient Name"
                                            name="patient_name" required />
                                        <label>Patient Name</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" placeholder="Guardian Name"
                                            name="guardian_name" required />
                                        <label>Guardian Name</label>
                                    </div>
                                </div>
                                <div class="col mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" placeholder="Phone Number"
                                            name="phone_number" required />
                                        <label>Phone Number</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" name="schedule_date" class="form-control" required />
                                        <label for="schedule_date">Schedule Date</label>
                                    </div>
                                </div>

                                <div class="col mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <select name="available_time_id" class="form-control" required>
                                            <option value="">Select Available Time</option>
                                            @foreach ($availableTimes as $time)
                                                <option value="{{ $time['id'] }}">{{ $time['time_slot'] }}</option>
                                            @endforeach

                                        </select>
                                        <label for="available_time_id">Available Time</label>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Book Reservation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Filter Form -->
        <div class="d-flex justify-content-end mb-4">
            <div>
                <label for="filterDate" class="form-label">Filter by Date:</label>
                <input type="date" id="filterDate" class="form-control" />
            </div>
        </div>

        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm" id="appointmentsTable">
                        <thead>
                            <tr>
                                <th class="text-truncate">Patient Name</th>
                                <th class="text-truncate">Phone Number</th>
                                <th class="text-truncate">Schedule Date</th>
                                <th class="text-truncate">Time Slot</th>
                                <th class="text-truncate">Reservation Message</th> <!-- New column for message -->
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservations as $index => $reservation)
                                <tr class="appointment-row"
                                    data-schedule-date="{{ \Carbon\Carbon::parse($reservation->schedule_date)->format('Y-m-d') }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="../assets/img/avatars/{{ ($index % 7) + 1 }}.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">{{ $reservation->patient_name }}</h6>
                                                <small class="text-truncate">{{ $reservation->guardian_name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-truncate">{{ $reservation->phone_number }}</td>
                                    <td class="text-truncate">
                                        {{ \Carbon\Carbon::parse($reservation->schedule_date)->format('F d, Y') }}
                                    </td>
                                    <td class="text-truncate">
                                        {{ \Carbon\Carbon::parse($reservation->availableTime->start_time)->format('h:i A') }} -
                                        {{ \Carbon\Carbon::parse($reservation->availableTime->end_time)->format('h:i A') }}
                                    </td>
                                    <td class="text-truncate">{{ $reservation->message ?? 'No message' }}</td>
                                    <!-- Display reservation message -->
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center mb-8 mt-8">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- No Data message -->
                    <div id="noDataMessage" class="text-center mt-8" style="display: none;">
                        <p>No data available for the selected date.</p>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reservations->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.getElementById('filterDate').addEventListener('change', function() {
                var filterDate = this.value;
                var rows = document.querySelectorAll('#appointmentsTable .appointment-row');
                var noDataMessage = document.getElementById('noDataMessage');
                var visibleRows = 0;

                rows.forEach(function(row) {
                    var rowDate = row.getAttribute('data-schedule-date');

                    if (!filterDate || rowDate === filterDate) {
                        row.style.display = '';
                        visibleRows++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (visibleRows === 0) {
                    noDataMessage.style.display = 'block';
                } else {
                    noDataMessage.style.display = 'none';
                }
            });
        </script>
    @endsection
@endsection
