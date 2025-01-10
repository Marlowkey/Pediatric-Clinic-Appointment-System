@extends('layouts.admin')
@section('title', 'Availability')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <x-alerts />
        <div class="row">
            <div class="col-md-12">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-0" role="tablist">
                        <!-- Available Today Tab -->
                        <li class="nav-item">
                            <button class="nav-link active bg-success" id="available-today-tab" data-bs-toggle="tab"
                                data-bs-target="#available-today" type="button" role="tab"
                                aria-controls="available-today" aria-selected="true">
                                <i class="ri-group-line me-1_5"></i> Available Today
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link bg-success" id="unavailable-today-tab" data-bs-toggle="tab"
                                data-bs-target="#unavailable-today" type="button" role="tab"
                                aria-controls="unavailable-today" aria-selected="false">
                                <i class="ri-close-circle-line me-1_5"></i> Unavailable Today
                            </button>
                        </li>

                        <!-- Time Slot Tab -->
                        <li class="nav-item">
                            <button class="nav-link bg-success" id="time-slot-tab" data-bs-toggle="tab"
                                data-bs-target="#time-slot" type="button" role="tab" aria-controls="time-slot"
                                aria-selected="false">
                                <i class="ri-notification-4-line me-1_5"></i> Time Slot
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Available Today Tab Content -->
            <div class="tab-pane fade show active" id="available-today" role="tabpanel"
                aria-labelledby="available-today-tab">
                <div class="card">
                    <h5 class="card-header">Available Times Today</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($availableTimes as $time)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($time->start_time)->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($time->end_time)->format('h:i A') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-line"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    {{-- <a class="dropdown-item"
                                                        href="{{ route('available-times.edit', $time->id) }}">
                                                        <i class="ri-pencil-line me-1"></i> Edit
                                                    </a> --}}
                                                    <form
                                                        action="{{ route('available-times.make-unavailable', $time->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="date" name="date"
                                                            class="form-control mx-2 mb-2 w-auto"
                                                            value="{{ now()->toDateString() }}" required>
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="ri-close-circle-line me-1"></i> Make Unavailable
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No available times today</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Time Slot Tab Content -->
            <div class="tab-pane fade" id="time-slot" role="tabpanel" aria-labelledby="time-slot-tab">
                <div class="card">
                    <h5 class="card-header">Time Slot Management</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($timeSlots as $slot)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-line"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <!-- Edit Time Slot Button -->
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#editTimeSlotModal{{ $slot->id }}">
                                                        <i class="ri-pencil-line me-1"></i> Edit
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('available-times.delete', $slot->id) }}">
                                                        <i class="ri-delete-bin-6-line me-1"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Time Slot Modal -->
                                    <div class="modal fade" id="editTimeSlotModal{{ $slot->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Time Slot</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('available-times.update', $slot->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT') <!-- Method spoofing for PUT request -->

                                                        <div class="row">
                                                            <div class="col mb-2">
                                                                <div class="form-floating form-floating-outline">
                                                                    <input
                                                                        type="time"
                                                                        class="form-control"
                                                                        name="start_time"
                                                                        value="{{ $slot->start_time }}"
                                                                        required
                                                                    />
                                                                    <label>Start Time</label>
                                                                </div>
                                                            </div>
                                                            <div class="col mb-2">
                                                                <div class="form-floating form-floating-outline">
                                                                    <input
                                                                        type="time"
                                                                        class="form-control"
                                                                        name="end_time"
                                                                        value="{{ $slot->end_time }}"
                                                                        required
                                                                    />
                                                                    <label>End Time</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Update Time Slot</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No time slots available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- Unavailable Today Tab Content -->
            <div class="tab-pane fade" id="unavailable-today" role="tabpanel" aria-labelledby="unavailable-today-tab">
                <div class="card">
                    <h5 class="card-header">Unavailable Times Today</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($unavailableTimes as $time)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($time->start_time)->format('h:i A') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($time->end_time)->format('h:i A') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-line"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('available-times.make-available', $time->id) }}">
                                                        <i class="ri-check-line me-1"></i> Make Available
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">All times are available today</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection
