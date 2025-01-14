<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\AvailableTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search', '');


        $availableTimes = AvailableTime::all()->map(function ($time) {
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');

            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time,
            ];
        });


        $query = Reservation::with('availableTime')
            ->where(function($query) use ($searchTerm) {
                $query->where('patient_name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('guardian_name', 'like', '%' . $searchTerm . '%');
            });


            if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }


        $reservations = $query->orderBy('schedule_date', 'asc')->paginate(20);
        $status = $request->input('status', '');
    if ($status == 'pending') {
        return view('admin.pages.reservations.pending', compact('reservations', 'availableTimes', 'searchTerm'));
    } elseif ($status == 'completed') {
        return view('admin.pages.reservations.completed', compact('reservations', 'availableTimes', 'searchTerm'));
    }

    return view('admin.pages.reservations.index', compact('reservations', 'availableTimes', 'searchTerm'));
    }

    public function index(Request $request)
    {
        return $this->search($request);
    }

    public function pendingAppointments(Request $request)
    {
        $request->merge(['status' => 'pending']);
        return $this->search($request);
    }

    public function completedAppointments(Request $request)
    {
        $request->merge(['status' => 'completed']);
        return $this->search($request);
    }
}
