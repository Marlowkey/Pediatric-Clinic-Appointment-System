@extends('layouts.admin')
@section('title', 'Pending')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-align-top">
                        <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active bg-success text-white" href="#">
                                    <i class="ri-group-line me-1_5"></i> Pending Appointments
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-truncate">Patient Name</th>
                                <th class="text-truncate">Phone Number</th>
                                <th class="text-truncate">Schedule Date</th>
                                <th class="text-truncate">Time Slot</th>
                                <th class="text-truncate">Status</th>
                                <th class="text-truncate">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $index => $reservation)
                                <tr>
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
                                        {{ \Carbon\Carbon::parse($reservation->schedule_date)->format('F d, Y') }}</td>
                                    <td class="text-truncate">{{ $reservation->availableTime->time_slot }}</td>
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
                                                <form action="{{ route('reservations.updateSchedule', $reservation->id) }}"
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

                                                        <!-- Available Time Slot -->
                                                        <div class="col mb-2">
                                                            <div class="form-floating form-floating-outline">
                                                                <select name="available_time_id" class="form-control"
                                                                    required>
                                                                    <option value="">Select Available Time</option>
                                                                    @foreach ($availableTimes as $time)
                                                                        <option value="{{ $time->id }}">
                                                                            {{ $time->time_slot }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label for="available_time_id">Available Time</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Reschedule</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
