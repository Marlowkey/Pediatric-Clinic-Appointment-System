<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after:arrival_date',
            'rooms' => 'required|integer|min:1',
            'guests' => 'required',
            'email' => 'required|email',
            'message' => 'nullable|string|max:500',
        ]);

        // Save reservation logic here...

        return redirect()->back()->with('success', 'Reservation made successfully!');
    }
}
