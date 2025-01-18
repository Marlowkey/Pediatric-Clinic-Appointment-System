<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\AvailableTime;
use App\Services\SmsNotificationService;

class ReservationController extends Controller
{
    protected $smsService;

    public function __construct(SmsNotificationService $smsService)
    {
        $this->smsService = $smsService;
    }
    public function index()
    {
        $availableTimes = AvailableTime::all()->map(function ($time) {
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');

            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time,
            ];
        });

        $reservations = Reservation::with('availableTime')
            ->where('status', 'accepted')
            ->orderBy('schedule_date', 'asc') // Sort by schedule_date in ascending order
            ->get();

        return view('admin.pages.reservations.index', compact('reservations', 'availableTimes'));
    }

    public function pendingAppointments()
    {
        $availableTimes = AvailableTime::all()->map(function ($time) {
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');

            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time,
            ];
        });

        $reservations = Reservation::with('availableTime')
            ->orderBy('schedule_date', 'asc') // Sort by schedule_date in ascending order
            ->get();

        return view('admin.pages.reservations.pending', compact('reservations', 'availableTimes'));
    }

    public function completedAppointments()
    {
        $availableTimes = AvailableTime::all()->map(function ($time) {
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');

            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time,
            ];
        });

        $reservations = Reservation::with('availableTime')->where('status', 'completed')->orderBy('schedule_date', 'asc')->get();

        return view('admin.pages.reservations.completed', compact('reservations', 'availableTimes'));
    }

    public function bookReservations()
    {
        $availableTimes = AvailableTime::all()->map(function ($time) {
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');

            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time,
            ];
        });

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
            'phone_number' => 'required|regex:/^\+639[0-9]{9}$/', // Ensures phone number starts with +639 and is 12 digits long
            'message' => 'nullable|string',
        ]);

        // Check if the time slot is already booked
        $exists = Reservation::where('schedule_date', $request->schedule_date)
            ->where('available_time_id', $request->available_time_id)
            ->exists();

        if ($exists) {
            return redirect()
                ->back()
                ->withErrors(['available_time_id' => 'This time slot is already booked.']);
        }

        // Get the start and end time of the selected available time slot
        $availableTime = AvailableTime::findOrFail($request->available_time_id);

        // Create the reservation
        Reservation::create([
            'schedule_date' => $request->schedule_date,
            'available_time_id' => $availableTime->id,
            'start_time' => $availableTime->start_time,
            'end_time' => $availableTime->end_time,
            'patient_name' => $request->patient_name,
            'guardian_name' => $request->guardian_name,
            'phone_number' => $request->phone_number,
            'message' => $request->message,
        ]);

        // Customize the success message based on user role
        $successMessage = 'Reservation created successfully!';
        if (auth()->user()->role->name === 'patient') {
            $successMessage = 'Reservation created successfully! Please wait for confirmation of your appointment.';
        }

        return redirect()->back()->with('success', $successMessage);
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $status = $request->input('status');

        $reservation->update(['status' => $status]);

        if ($status === 'accepted') {
            $scheduleDate = Carbon::parse($reservation->schedule_date)->format('F j, Y');
            $startTime = Carbon::parse($reservation->start_time)->format('g:i A');
            $endTime = Carbon::parse($reservation->end_time)->format('g:i A');

            $message = "Hi {$reservation->guardian_name}, your reservation (ID: {$reservation->id}) has been accepted. " . "Scheduled for {$scheduleDate} at {$startTime} to {$endTime}.";

            try {
                $this->smsService->sendSms($reservation->phone_number, $message);
            } catch (\Exception $e) {
                Log::error("Failed to send SMS for reservation ID {$reservation->id}. Error: {$e->getMessage()}");
            }
        }

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

        $availableTime = AvailableTime::findOrFail($request->available_time_id);

        $reservation->update([
            'schedule_date' => $request->schedule_date,
            'available_time_id' => $availableTime->id,
            'start_time' => $availableTime->start_time,
            'end_time' => $availableTime->end_time,
            'status' => 'accepted',
        ]);

        $scheduleDate = Carbon::parse($reservation->schedule_date)->format('F j, Y');
        $startTime = Carbon::parse($reservation->start_time)->format('g:i A');
        $endTime = Carbon::parse($reservation->end_time)->format('g:i A');

        $message = "Hi {$reservation->guardian_name}, your reservation (ID: {$reservation->id}) has been rescheduled to {$scheduleDate} from {$startTime} to {$endTime}. Your reservation has been accepted.";

        try {
            $this->smsService->sendSms($reservation->phone_number, $message);
        } catch (\Exception $e) {
            Log::error("Failed to send SMS for reservation ID {$reservation->id}. Error: {$e->getMessage()}");
        }
        return redirect()->back()->with('success', 'Reservation updated successfully and status changed to accepted.');
    }
}
