<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\AvailableTime;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalReservations = Reservation::count();
        $reservationsToday = Reservation::whereDate('schedule_date', now()->toDateString())
            ->where('status', 'accepted')
            ->count();
        $totalPatientsUser = User::whereHas('role', function ($query) {
            $query->where('name', 'patient');
        })->count();

        $monthlyReservations = Reservation::where('status', 'completed')->selectRaw('MONTH(schedule_date) as month, count(*) as count')->groupBy('month')->orderBy('month')->get()->pluck('count', 'month')->toArray();

        for ($i = 1; $i <= 12; $i++) {
            if (!array_key_exists($i, $monthlyReservations)) {
                $monthlyReservations[$i] = 0;
            }
        }

        if (in_array($user->role->name, ['admin', 'doctor'])) {
            return view('admin.pages.dashboard', compact('totalReservations', 'reservationsToday', 'totalPatientsUser', 'monthlyReservations'));
        }

        return view('pages.index');
    }
    public function patientDashboard()
    {
        $user = Auth::user();

        if ($user->role->name !== 'patient') {
            return redirect()->route('home')->with('error', 'Access denied.');
        }

        $availableTimes = AvailableTime::all()->map(function ($time) {
            $start_time = Carbon::parse($time->start_time)->format('h:i A');
            $end_time = Carbon::parse($time->end_time)->format('h:i A');
            return [
                'id' => $time->id,
                'time_slot' => $start_time . ' - ' . $end_time,
            ];
        });

        $reservations = Reservation::where('user_id', $user->id)
                                    ->orderBy('schedule_date', 'desc')
                                    ->paginate(5);

        $upcomingReservations = Reservation::where('user_id', $user->id)
                                           ->where('status', 'accepted')
                                           ->get();

        $completedReservations = Reservation::where('user_id', $user->id)
                                            ->where('status', 'completed')
                                            ->get();


        $totalReservations = $reservations->count();
        $totalCompleted = $completedReservations->count();

        return view('pages.dashboard', [
            'upcomingReservations' => $upcomingReservations,
            'completedReservations' => $completedReservations,
            'totalReservations' => $totalReservations,
            'totalCompleted' => $totalCompleted,
            'availableTimes' => $availableTimes,
            'reservations' => $reservations,
        ]);
    }

}
