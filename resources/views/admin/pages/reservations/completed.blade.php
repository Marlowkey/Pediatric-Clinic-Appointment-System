@extends('layouts.admin')
@section('title', 'Completed Appointments')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-alerts />
        <x-heading>
            Completed Appointments
        </x-heading>

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
                                                <img src="{{ asset('assets/img/avatars/' . (($index % 7) + 1) . '.png') }}"
                                                    alt="Avatar" class="rounded-circle" />
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
const rowsPerPage = 15;  // Number of rows per page
let currentPage = 1;  // Initial page
let originalRows = []; // Store all rows
let filteredRows = []; // Store filtered rows

document.getElementById('filterDate').addEventListener('change', function () {
    const filterDate = this.value;
    filterRows(filterDate);
});

document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('#appointmentsTable .appointment-row');
    originalRows = Array.from(rows).map(row => ({
        element: row,
        text: Array.from(row.getElementsByTagName('td')).map(cell => cell.textContent
            .toLowerCase()).join(' '),
        date: row.getAttribute('data-schedule-date'),
    }));

    // Initially, no filter is applied, so use originalRows
    filteredRows = [...originalRows];

    // Filter rows and initialize pagination
    paginateAndFilterRows();

    // Search input event listener
    document.getElementById('appointmentSearch').addEventListener('input', function () {
        filterRows(document.getElementById('filterDate').value);
    });

    // Pagination click event listener
    document.getElementById('paginationLinks').addEventListener('click', function (e) {
        if (e.target && e.target.tagName === 'A') {
            const clickedPage = e.target.closest('.page-item').dataset.page;
            if (clickedPage) {
                currentPage = parseInt(clickedPage);
            }
            if (e.target.closest('#prevPage') && currentPage > 1) {
                currentPage--;
            }
            if (e.target.closest('#nextPage') && currentPage < Math.ceil(filteredRows.length / rowsPerPage)) {
                currentPage++;
            }
            paginateAndFilterRows();
        }
    });
});

// Filter rows based on search and date filter
function filterRows(filterDate) {
    const searchInput = document.getElementById('appointmentSearch').value.toLowerCase();
    filteredRows = originalRows.filter(row => {
        const matchesSearch = row.text.includes(searchInput);
        const matchesDate = !filterDate || row.date === filterDate;
        return matchesSearch && matchesDate;
    });
    currentPage = 1; // Reset to page 1 when filtering
    paginateAndFilterRows(); // Re-paginate after filtering
}

// Paginate and filter rows
function paginateAndFilterRows() {
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    const start = (currentPage - 1) * rowsPerPage;
    const end = currentPage * rowsPerPage;
    const rowsToRender = filteredRows.slice(start, end);

    renderPage(rowsToRender); // Render the rows for the current page
    updatePaginationLinks(totalPages); // Update pagination links
}

// Render page rows and handle "No Data" message and pagination visibility
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
    }
}

// Update pagination links
function updatePaginationLinks(totalPages) {
    const paginationLinks = document.getElementById('paginationLinks');
    paginationLinks.innerHTML = ''; // Clear existing links

    const prevPageClass = currentPage === 1 ? 'disabled' : '';
    const nextPageClass = currentPage === totalPages ? 'disabled' : '';

    // Add Previous and Next buttons
    paginationLinks.innerHTML += `
        <li class="page-item ${prevPageClass}" id="prevPage">
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

    // Add Next button
    paginationLinks.innerHTML += `
        <li class="page-item ${nextPageClass}" id="nextPage">
            <a class="page-link" href="javascript:void(0)" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    `;
}

</script>
@endsection
