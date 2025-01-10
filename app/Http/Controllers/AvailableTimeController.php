<?php

namespace App\Http\Controllers;

use App\Models\AvailableTime;
use App\Models\UnavailableTimeSlot;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AvailableTimeController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $availableTimes = AvailableTime::whereDoesntHave('unavailableTimeSlots', function ($query) use ($today) {
            $query->where('date', $today);
        })->get();

        $unavailableTimes = AvailableTime::whereHas('unavailableTimeSlots', function ($query) use ($today) {
            $query->where('date', $today);
        })->get();

        $timeSlots = AvailableTime::all();

        return view('admin.pages.available-times.index', compact('availableTimes', 'unavailableTimes', 'timeSlots'));
    }

    public function edit($id)
    {
        $availableTime = AvailableTime::findOrFail($id);

        return view('available-times.edit', compact('availableTime'));
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'start_time' => substr($request->start_time, 0, 5), // Extract "H:i"
            'end_time' => substr($request->end_time, 0, 5),    // Extract "H:i"
        ]);


        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $availableTime = AvailableTime::findOrFail($id);

        $availableTime->update([
            'start_time' => $request->start_time . ':00', // Add seconds to match database format
            'end_time' => $request->end_time . ':00',
        ]);

        return redirect()->route('available-times.index')->with('success', 'Available time updated successfully.');
    }



    public function destroy($id)
    {
        $availableTime = AvailableTime::findOrFail($id);
        $availableTime->delete();

        return redirect()->route('available-times.index')->with('success', 'Available time deleted successfully.');
    }

    public function makeUnavailable(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $availableTime = AvailableTime::findOrFail($id);

        $exists = UnavailableTimeSlot::where('date', $request->date)
            ->where('available_time_id', $availableTime->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This time slot is already unavailable for the selected date.');
        }

        UnavailableTimeSlot::create([
            'date' => $request->date,
            'available_time_id' => $availableTime->id,
        ]);

        return redirect()->route('available-times.index')->with('success', 'Time slot marked as unavailable.');
    }

    public function makeAvailable($id)
    {
        $unavailableTimeSlot = UnavailableTimeSlot::findOrFail($id);

        $unavailableTimeSlot->delete();

        return redirect()->route('available-times.index')->with('success', 'Time slot marked as available again.');
    }
}
