<?php

namespace App\Http\Controllers;

use App\Models\AvailableTime;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('availableTime')->paginate(10);
        return view('admin.pages.reservations.index', compact('reservations'));
    }

    public function pendingAppointments()
    {
        $reservations = Reservation::with('availableTime')->paginate(10);
        $availableTimes = AvailableTime::all();
        return view('admin.pages.reservations.pending', compact('reservations', 'availableTimes'));
    }

    public function bookReservations()
    {
        $availableTimes = AvailableTime::all();
        return view('pages.booking', compact('availableTimes'));
    }

    // Store a new reservation
    public function store(Request $request)
    {
        $request->validate([
            'schedule_date' => 'required|date|after_or_equal:today',
            'available_time_id' => 'required|exists:available_times,id',
            'patient_name' => 'required|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^09[0-9]{9}$/',
            'message' => 'nullable|string',
        ]);

        $exists = Reservation::where('schedule_date', $request->schedule_date)
            ->where('available_time_id', $request->available_time_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['available_time_id' => 'This time slot is already booked.']);
        }

        Reservation::create([
            'schedule_date' => $request->schedule_date,
            'available_time_id' => $request->available_time_id,
            'patient_name' => $request->patient_name,
            'guardian_name' => $request->guardian_name,
            'phone_number' => $request->phone_number,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Reservation created successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Reservation status updated successfully.');
    }

    // Update an existing reservation (for rescheduling)
    public function updateSchedule(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'schedule_date' => 'required|date|after_or_equal:today',
            'available_time_id' => 'required|exists:available_times,id',
        ]);

        $exists = Reservation::where('schedule_date', $request->schedule_date)
            ->where('available_time_id', $request->available_time_id)
            ->where('id', '!=', $reservation->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['available_time_id' => 'This time slot is already booked.']);
        }

        $reservation->update([
            'schedule_date' => $request->schedule_date,
            'available_time_id' => $request->available_time_id,
        ]);

        return redirect()->back()->with('success', 'Reservation updated successfully.');
    }
}
