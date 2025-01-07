<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin Dashboard
    public function dashboard()
    {
        return view('admin.pages.dashboard');
    }

    // Appointment Calendar
    public function appointmentCalendar()
    {
        return view('admin.pages.appointment_calendar');
    }

    // Pending Appointments
    public function pendingAppointments()
    {
        return view('admin.pages.pending_appointments');
    }

    // Walk-in Appointments
    public function walkInAppointments()
    {
        return view('admin.pages.walk_in_appointments');
    }

    // Account Management
    public function account()
    {
        return view('admin.pages.account');
    }
}
