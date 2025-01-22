<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalReservations = Reservation::count();
        $reservationsToday = Reservation::whereDate('schedule_date', now()->toDateString())->where('status', 'accepted')->count();
        $totalPatientsUser = User::whereHas('role', function ($query) {
            $query->where('name', 'patient');
        })->count();

        // Monthly reservations: Map data for chart
        $monthlyReservations = Reservation::where('status', 'completed')
            ->selectRaw('MONTH(schedule_date) as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month') // Ensure months are ordered from January to December
            ->get()
            ->pluck('count', 'month')
            ->toArray();
        // If a month has no reservations, set it to 0
        for ($i = 1; $i <= 12; $i++) {
            if (!array_key_exists($i, $monthlyReservations)) {
                $monthlyReservations[$i] = 0;
            }
        }

        // Pass data to the view
        if (in_array($user->role->name, ['admin', 'doctor'])) {
            return view(
                'admin.pages.dashboard',
                compact(
                    'totalReservations',
                    'reservationsToday',
                    'totalPatientsUser',
                    'monthlyReservations', // Pass monthly reservation data
                ),
            );
        }

        return view('pages.index');
    }
}
