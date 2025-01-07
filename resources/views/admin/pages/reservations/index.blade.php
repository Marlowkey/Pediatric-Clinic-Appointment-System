@extends('layouts.admin')
@section('title', 'Appointments')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
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
                                    <i class="ri-group-line me-1_5"></i> Appointments
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
                                <th class="text-truncate">Reservation Message</th> <!-- New column for message -->
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
                                    <td class="text-truncate">{{ $reservation->message ?? 'No message' }}</td> <!-- Display reservation message -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
