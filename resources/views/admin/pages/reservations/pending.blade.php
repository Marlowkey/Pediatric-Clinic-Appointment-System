@extends('layouts.admin')
@section('title', 'Pending')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-alerts />

        <x-heading-w-button href="" icon="ri-add-line me-1_5" headingText="Pending Appointments" data-bs-toggle="modal"
            data-bs-target="#newScheduleModal">
            New Patient
        </x-heading-w-button>

        <!-- Modal for New Schedule (Booking a New Reservation) -->
        <div class="modal fade" id="newScheduleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">New Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="newScheduleForm" action="{{ route('reservations.store') }}" method="POST">
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
                                        <input type="text" class="form-control phone-number" placeholder="Phone Number"
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
        <div class="d-flex justify-content-between mb-4 align-items-center">
            <!-- Search Component -->
            <x-search-form id="appointmentSearch" placeholder="Search Appointments" />

            <!-- Date Filter -->
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
                                <th class="text-truncate">Status</th>
                                <th class="text-truncate">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $index => $reservation)
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

                                    <td class="text-truncate">
                                        @if ($reservation->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($reservation->status == 'accepted')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif ($reservation->status == 'rejected')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <form action="{{ route('reservations.updateStatus', $reservation->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                            </form>

                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#rescheduleModal{{ $reservation->id }}">
                                                Reschedule
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Reschedule Modal -->
                                <div class="modal fade" id="rescheduleModal{{ $reservation->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel1">Reschedule Appointment for
                                                    {{ $reservation->patient_name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('reservations.updateSchedule', $reservation->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div class="row">
                                                        <div class="col mb-6 mt-2">
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Patient Name"
                                                                    value="{{ $reservation->patient_name }}" disabled />
                                                                <label>Patient Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row g-4">
                                                        <div class="col mb-2">
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Guardian Name"
                                                                    value="{{ $reservation->guardian_name }}" disabled />
                                                                <label>Guardian Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col mb-2">
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="text" class="form-control"
                                                                    placeholder="Phone Number"
                                                                    value="{{ $reservation->phone_number }}" disabled />
                                                                <label>Phone Number</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row g-4">
                                                        <div class="col mb-2">
                                                            <div class="form-floating form-floating-outline">
                                                                <input type="date" id="newDate" name="schedule_date"
                                                                    class="form-control" required />
                                                                <label for="newDate">New Schedule Date</label>
                                                            </div>
                                                        </div>
                                                        <div class="col mb-2">
                                                            <div class="form-floating form-floating-outline">
                                                                <select name="available_time_id" id="available_time_id"
                                                                    class="form-control" required>
                                                                    <option value="" disabled selected>Select
                                                                        Available Time</option>
                                                                    @foreach ($availableTimes as $time)
                                                                        <option value="{{ $time['id'] }}">
                                                                            {{ $time['time_slot'] }}</option>
                                                                    @endforeach

                                                                </select>
                                                                <label for="available_time_id">Available Time</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Reschedule</button>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const rows = document.querySelectorAll('#appointmentsTable .appointment-row');
            // Store the original data rows
            let originalRows = Array.from(rows).map(row => ({
                element: row,
                text: Array.from(row.getElementsByTagName('td')).map(cell => cell.textContent
                    .toLowerCase()).join(' '),
                date: row.getAttribute('data-schedule-date'),
            }));

            const tableBody = document.querySelector('#appointmentsTable tbody');
            const rowsPerPage = 15; // Number of rows per page
            let currentPage = 1;
            function renderPage(rowsToRender) {
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


            function paginate(rows) {
                const totalPages = Math.ceil(rows.length / rowsPerPage);
                const start = (currentPage - 1) * rowsPerPage;
                const end = currentPage * rowsPerPage;
                const paginatedRows = rows.slice(start, end);

                renderPage(paginatedRows);
                updatePaginationLinks(totalPages);
            }
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

            function filterRows() {
                const searchInput = document.getElementById('appointmentSearch').value.toLowerCase();
                const filterDate = document.getElementById('filterDate').value;
                const filteredRows = originalRows.filter(row => {
                    const matchesSearch = row.text.includes(searchInput);
                    const matchesDate = !filterDate || row.date === filterDate;
                    return matchesSearch && matchesDate;
                });
                currentPage = 1;
                paginate(filteredRows);
            }

            document.getElementById('appointmentSearch').addEventListener('input', filterRows);

            document.getElementById('filterDate').addEventListener('change', filterRows);

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

            paginate(originalRows);

            const phoneInput = document.querySelector('.phone-number');

            phoneInput.addEventListener('input', (e) => {
                let value = phoneInput.value;

                if (!value.startsWith('+63')) {
                    phoneInput.value = '+63' + value.replace(/^(\+63|\+)?/, '');
                }
            });

            const form = document.getElementById('newScheduleForm');
            form.addEventListener('submit', () => {
                const value = phoneInput.value;
                if (!value.startsWith('+63')) {
                    phoneInput.value = '+63' + value.replace(/^(\+63|\+)?/, '');
                }
            });
        });
    </script>

@endsection
