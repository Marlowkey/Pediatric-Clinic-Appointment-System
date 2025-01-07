@extends('layouts.admin')

@section('title', 'Appointment Calendar')
@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="bg-light rounded p-4">
        <div class="container">
            <div class="row">
                <!-- Calendar Section -->
                <div class="col-8">
                    <h2>Appointment Calendar</h2>
                    <div id="calendar">
                        {{-- This is where FullCalendar or another calendar widget will be rendered --}}
                    </div>
                </div>
        
                <!-- Patient Booking Section -->
                <div class="col-4">
                    <h4>Patient Booking Information</h4>
                    <div id="patient-booking">
                        {{-- Placeholder for patient booking details --}}
                        <ul>
                            <li>Patient Name: John Doe</li>
                            <li>Appointment Time: 10:00 AM</li>
                            <li>Service: General Consultation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
