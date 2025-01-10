@extends('layouts.admin')
@section('title', 'Completed Appointments')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-alerts />
        <x-heading>
            Completed Appointments
        </x-heading>

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
                                <th class="text-truncate">Reservation Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reservations as $index => $reservation)
                                <tr class="appointment-row"
                                    data-schedule-date="{{ \Carbon\Carbon::parse($reservation->schedule_date)->format('Y-m-d') }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-4">
                                                <img src="{{ asset('assets/img/avatars/' . (($index % 7) + 1) . '.png') }}" alt="Avatar" class="rounded-circle" />

                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-truncate">{{ $reservation->patient_name }}</h6>
                                                <small class="text-truncate">{{ $reservation->guardian_name }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $reservation->phone_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($reservation->schedule_date)->format('F d, Y') }}</td>
                                    <td class="text-truncate">
                                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('h:i A') }}
                                        -
                                        {{ \Carbon\Carbon::parse($reservation->end_time)->format('h:i A') }}
                                    </td>
                                    <td>{{ $reservation->message ?? 'No message' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No completed appointments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div id="noDataMessage" class="text-center mt-4" style="display: none;">
                        <p>No data available for the selected date.</p>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reservations->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
