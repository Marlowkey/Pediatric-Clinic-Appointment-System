<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\AvailableTime;
use Illuminate\Support\Facades\Route;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search', '');

        // Check if the search term is empty
        if (empty($searchTerm)) {
            return redirect()->route('reservations.index');
        }


        // Fetch and format available times
        $availableTimes = AvailableTime::all()->map(function ($time) {
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');

            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time,
            ];
        });

        // Build the reservation query
        $query = Reservation::with('availableTime')->where(function ($query) use ($searchTerm) {
            $query->where('patient_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('guardian_name', 'like', '%' . $searchTerm . '%');
        });

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $reservations = $query->orderBy('schedule_date', 'asc')->paginate(20);

        // Determine the current route name
        $currentRouteName = Route::currentRouteName();

        // Map route names to views
        $views = [
            'reservations.index' => 'admin.pages.reservations.index',
            'reservations.pending' => 'admin.pages.reservations.pending',
            'reservations.completed' => 'admin.pages.reservations.completed',
        ];

        // Select the appropriate view based on the current route name
        $view = $views[$currentRouteName] ?? null;

        if (!$view) {
            abort(404, 'View not found for the current route');
        }

        return view($view, compact('reservations', 'availableTimes', 'searchTerm'));
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

