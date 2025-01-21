@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
    <section class="site-hero overlay" data-stellar-background-ratio="0.5"
        style="background-image: url({{ asset('user/images/bg.png') }});">
        <div class="container">
            <div class="row align-items-center site-hero-inner justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="mb-5 element-animate">
                        <h1>Your Appointments</h1>
                        <p>Online, Anytime, Anywhere.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="site-section bg-gray-100">

        <div class="container">
            <x-alerts />
            <h2 class="mb-5 fw-bolder text-start">Appointments</h2>

            <div class="row align-items-center">
                <div class="col-12">
                    <div class="card overflow-hidden">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-borderless">
                                <thead class="table-success">
                                    <tr>
                                        <th class="text-truncate">Patient Name</th>
                                        <th class="text-truncate">Phone Number</th>
                                        <th class="text-truncate">Schedule Date</th>
                                        <th class="text-truncate">Time Slot</th>
                                        <th class="text-truncate">Reservation Message</th>
                                        <th class="text-truncate">Status</th>
                                        <th class="text-truncate">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($reservations as $index => $reservation)
                                        <tr class="appointment-row"
                                            data-schedule-date="{{ \Carbon\Carbon::parse($reservation->schedule_date)->format('Y-m-d') }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <h6 class="mb-0 text-truncate">{{ $reservation->patient_name }}</h6>
                                                        <small
                                                            class="text-truncate">{{ $reservation->guardian_name }}</small>
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
                                                @elseif ($reservation->status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown"
                                                        @if ($reservation->status === 'confirmed') disabled @endif>
                                                        <i class="ri-more-2-line"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <!-- Edit Time Slot Button -->
                                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#rescheduleModal{{ $reservation->id }}">
                                                            <i class="ri-pencil-line me-1"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $reservation->id }}').submit();">
                                                            <i class="ri-delete-bin-6-line me-1"></i> Delete
                                                        </a>

                                                        <form id="delete-form-{{ $reservation->id }}"
                                                            action="{{ route('reservations.destroy', $reservation->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="rescheduleModal{{ $reservation->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Appointment for
                                                            {{ $reservation->patient_name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('reservations.update', $reservation->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PATCH')

                                                            <!-- Patient Name -->
                                                            <div class="row">
                                                                <div class="col mb-6 mt-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Patient Name" name="patient_name"
                                                                            value="{{ old('patient_name', $reservation->patient_name) }}"
                                                                            required />
                                                                        <label>Patient Name</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Guardian Name and Phone Number -->
                                                            <div class="row g-4">
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Guardian Name" name="guardian_name"
                                                                            value="{{ old('guardian_name', $reservation->guardian_name) }}"
                                                                            required />
                                                                        <label>Guardian Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Phone Number" name="phone_number"
                                                                            value="{{ old('phone_number', $reservation->phone_number) }}"
                                                                            required />
                                                                        <label>Phone Number</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Schedule Date and Time Slot -->
                                                            <div class="row g-4">
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <input type="date" id="newDate"
                                                                            name="schedule_date" class="form-control"
                                                                            value="{{ old('schedule_date', $reservation->schedule_date) }}"
                                                                            required />
                                                                        <label for="newDate">New Schedule Date</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-2">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <select name="available_time_id"
                                                                            id="available_time_id" class="form-control"
                                                                            required>
                                                                            <option value="" disabled>Select
                                                                                Available Time</option>
                                                                            @foreach ($availableTimes as $time)
                                                                                <option value="{{ $time['id'] }}"
                                                                                    {{ $reservation->available_time_id == $time['id'] ? 'selected' : '' }}>
                                                                                    {{ $time['time_slot'] }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <label for="available_time_id">Available
                                                                            Time</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3 mb-2">
                                                                <div class="col">
                                                                    <div class="form-floating form-floating-outline">
                                                                        <textarea class="form-control" name="message" placeholder="Message (Optional)" rows="3">{{ old('message', $reservation->message) }}</textarea>
                                                                        <label>Message (Optional)</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer mt-4">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit"
                                                                    class="btn btn-success btn-sm">Reschedule</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $reservations->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
