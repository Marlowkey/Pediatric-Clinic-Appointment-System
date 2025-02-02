@extends('layouts.admin')
@section('title', 'Appointments')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-alerts />
        <x-heading>
            Appointments
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

                            <!-- Message Field -->
                            <div class="row mt-3 mb-2">
                                <div class="col">
                                    <div class="form-floating form-floating-outline">
                                        <textarea class="form-control" name="message" placeholder="Message (Optional)" rows="3"></textarea>
                                        <label>Message (Optional)</label>
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
        <div class="d-flex justify-content-between align-items-center">
            <!-- Search Form -->
            <x-search-form id="appointmentSearch" placeholder="Search Appointments" />
            <!-- Date Filter -->
            <div class="mb-6">
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
                                <th class="text-truncate"></th>
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
                                        {{ \Carbon\Carbon::parse($reservation->start_time)->format('h:i A') }}
                                        -
                                        {{ \Carbon\Carbon::parse($reservation->end_time)->format('h:i A') }}
                                    </td>
                                    <td class="text-truncate">{{ $reservation->message ?? 'No message' }}</td>
                                    <td>
                                        <!-- Complete Appointment Button -->
                                        @if ($reservation->status !== 'completed')
                                            <form action="{{ route('reservations.updateStatus', $reservation->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Complete
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge bg-success">Completed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center mb-8 mt-8">No data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- No Data message -->
                    <div id="noDataMessage" class="text-center mt-8" style="display: none;">
                        <p>No data available for the selected date.</p>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination" id="paginationLinks">
                                <li class="page-item" id="prevPage">
                                    <a class="page-link" href="javascript:void(0)">Previous</a>
                                </li>
                                <!-- Page numbers will be dynamically added here -->
                                <li class="page-item" id="nextPage">
                                    <a class="page-link" href="javascript:void(0)">Next</a>
                                </li>
                            </ul>
                        </nav>
                        {{-- {{ $reservations->links('pagination::bootstrap-5') }} --}}
                    </div>
                </div>
            </div>
        </div>


    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const rows = document.querySelectorAll('#appointmentsTable .appointment-row');
                const rowsPerPage = 15; // Adjust this value as needed
                let currentPage = 1;
                let originalRows = Array.from(rows).map(row => ({
                    element: row,
                    text: Array.from(row.getElementsByTagName('td')).map(cell => cell.textContent
                        .toLowerCase()).join(' '),
                    date: row.getAttribute('data-schedule-date'),
                }));

                // Function to render rows for the current page
                function renderPage(rowsToRender) {
                    const tableBody = document.querySelector('#appointmentsTable tbody');
                    tableBody.innerHTML = ''; // Clear current rows
                    rowsToRender.forEach(row => tableBody.appendChild(row.element));

                    const noDataMessage = document.getElementById('noDataMessage');
                    const paginationLinks = document.getElementById('paginationLinks');

                    if (rowsToRender.length === 0) {
                        noDataMessage.style.display = 'block'; // Show No Data message
                        paginationLinks.classList.add('invisible'); // Hide pagination with 'invisible' class
                    } else {
                        noDataMessage.style.display = 'none'; // Hide No Data message
                        paginationLinks.classList.remove('invisible'); // Show pagination by removing 'invisible' class
                        updatePaginationLinks(Math.ceil(rowsToRender.length / rowsPerPage)); // Update pagination links
                    }
                }

                // Function to paginate the rows
                function paginate(rows) {
                    const totalPages = Math.ceil(rows.length / rowsPerPage);
                    const start = (currentPage - 1) * rowsPerPage;
                    const end = currentPage * rowsPerPage;
                    const paginatedRows = rows.slice(start, end);

                    renderPage(paginatedRows);
                    updatePaginationLinks(totalPages);
                }

                // Function to update pagination links
                function updatePaginationLinks(totalPages) {
                    const paginationLinks = document.getElementById('paginationLinks');

                    paginationLinks.innerHTML = '';

                    paginationLinks.innerHTML = `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}" id="prevPage">
            <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `;

                    // Add page numbers
                    for (let i = 1; i <= totalPages; i++) {
                        paginationLinks.innerHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}" data-page="${i}">
                <a class="page-link" href="javascript:void(0)">${i}</a>
            </li>
        `;
                    }

                    paginationLinks.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}" id="nextPage">
            <a class="page-link" href="javascript:void(0)" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;
                }

                // Event listener for pagination link clicks
                document.getElementById('paginationLinks').addEventListener('click', function(e) {
                    if (e.target && e.target.tagName === 'A') {
                        const clickedPage = e.target.closest('.page-item').dataset.page;
                        if (clickedPage) {
                            currentPage = parseInt(clickedPage);
                        }

                        if (e.target.closest('#prevPage') && currentPage > 1) {
                            currentPage--;
                        }
                        if (e.target.closest('#nextPage') && currentPage < Math.ceil(originalRows.length /
                                rowsPerPage)) {
                            currentPage++;
                        }

                        paginate(originalRows);
                    }
                });

                // Function to filter the table based on search input
                function filterTable() {
                    const searchInput = document.getElementById('appointmentSearch').value.toLowerCase();
                    const filterDate = document.getElementById('filterDate').value;
                    let filteredRows = originalRows.filter(row => row.text.includes(searchInput));

                    if (filterDate) {
                        filteredRows = filteredRows.filter(row => row.date === filterDate);
                    }

                    currentPage = 1; // Reset to the first page when filtering
                    paginate(filteredRows);
                }

                // Event listener for search input
                document.getElementById('appointmentSearch').addEventListener('input', filterTable);

                // Event listener for filter date change
                document.getElementById('filterDate').addEventListener('change', filterTable);

                // Initial pagination setup
                paginate(originalRows);
            });
        </script>
    @endsection
@endsection
