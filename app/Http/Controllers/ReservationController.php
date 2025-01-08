<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\AvailableTime;

class ReservationController extends Controller
{
    public function index()
    {
        // Fetch all available times and format them with start and end times (12-hour format with AM/PM)
        $availableTimes = AvailableTime::all()->map(function ($time) {
            // Parse the start_time and end_time as Carbon instances
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');

            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time, // 12-hour format with AM/PM
            ];
        });

        // Fetch reservations with the related available times
        $reservations = Reservation::with('availableTime')
            ->where('status', 'accepted')
            ->latest()
            ->paginate(10);

        // Pass formatted available times and reservations to the view
        return view('admin.pages.reservations.index', compact('reservations', 'availableTimes'));
    }

    public function pendingAppointments()
    {
        // Fetch all available times and format them with start and end times (12-hour format with AM/PM)
        $availableTimes = AvailableTime::all()->map(function ($time) {
            // Parse the start_time and end_time as Carbon instances
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');

            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time, // 12-hour format with AM/PM
            ];
        });

        // Fetch all reservations with related available times
        $reservations = Reservation::with('availableTime')
            ->latest()
            ->paginate(10);

        // Return the view with available times and reservations
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
            return redirect()
                ->back()
                ->withErrors(['available_time_id' => 'This time slot is already booked.']);
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
            return redirect()
                ->back()
                ->withErrors(['available_time_id' => 'This time slot is already booked.']);
        }

        $reservation->update([
            'schedule_date' => $request->schedule_date,
            'available_time_id' => $request->available_time_id,
        ]);

        return redirect()->back()->with('success', 'Reservation updated successfully.');
    }
}
