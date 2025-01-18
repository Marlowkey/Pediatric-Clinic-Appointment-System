@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

<div class="col-lg-12">
    <div class="h-100">
        <div class="px-4 py-4">
            <div class="d-flex align-items-center justify-content-between">
                <x-heading>
                    Overview
                </x-heading>
            </div>
        </div>
        <div class="card-body pt-lg-10 px-4 py-6">
            <div class="row g-6 justify-content-center">
                <!-- Total Reservations -->
                <div class="col-md-3 col-6 d-flex justify-content-center">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="avatar-initial bg-primary rounded shadow-xs">
                                <i class="ri-user-line ri-24px"></i> <!-- Accounts icon -->
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0">Total Reservations</p>
                            <h5 class="mb-0">{{ number_format($totalReservations) }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Reservations Today -->
                <div class="col-md-3 col-6 d-flex justify-content-center">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="avatar-initial bg-success rounded shadow-xs">
                                <i class="ri-calendar-line ri-24px"></i> <!-- Appointments icon -->
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0">Reservations Today</p>
                            <h5 class="mb-0">{{ number_format($reservationsToday) }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Total Patients -->
                <div class="col-md-3 col-6 d-flex justify-content-center">
                    <div class="d-flex align-items-center">
                        <div class="avatar">
                            <div class="avatar-initial bg-warning rounded shadow-xs">
                                <i class="ri-user-heart-line ri-24px"></i> <!-- Patients icon -->
                            </div>
                        </div>
                        <div class="ms-3">
                            <p class="mb-0">Accounts</p>
                            <h5 class="mb-0">{{ number_format($totalPatientsUser) }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Monthly Reservations Chart -->
                <div class="col-md-12 ">
                    <div class="card w-full max-w-4xl">
                        <div class="card-header">
                            <h5 class="card-title">Appointments Overview</h5>
                        </div>
                        <div class="card-body px-4 py-4">
                            <canvas id="reservationsChart"></canvas> <!-- The chart will be rendered here -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
    <script>
        var monthlyReservations = {!! json_encode($monthlyReservations) !!}; // Pass the data to JS

        var ctx = document.getElementById('reservationsChart').getContext('2d');
        var reservationsChart = new Chart(ctx, {
            type: 'bar', // Line chart type
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ], // X-axis labels for months
                datasets: [{
                    label: 'Monthly Appointments',
                    data: Object.values(
                        monthlyReservations), // Data for the chart (reservation counts per month)
                        borderColor: 'rgba(0, 128, 0, 1)', // Dark green line color
                        backgroundColor: 'rgba(0, 128, 0, 0.2)', // Line fill color
                    borderWidth: 2,
                    tension: 0.4 // Smooth curve
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true // Ensure the y-axis starts from 0
                    }
                }
            }
        });
    </script>
@endsection
