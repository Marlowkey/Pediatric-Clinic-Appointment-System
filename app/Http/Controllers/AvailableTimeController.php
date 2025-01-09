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

        return view('admin.pages.available-times.index', compact('availableTimes', 'unavailableTimes'));
    }

    public function edit($id)
    {
        $availableTime = AvailableTime::findOrFail($id);

        return view('available-times.edit', compact('availableTime'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $availableTime = AvailableTime::findOrFail($id);

        $startTime = Carbon::createFromFormat('H:i', $request->start_time)->format('H:i:s');
        $endTime = Carbon::createFromFormat('H:i', $request->end_time)->format('H:i:s');

        $availableTime->update([
            'start_time' => $startTime,
            'end_time' => $endTime,
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
