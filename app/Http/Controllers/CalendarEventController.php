<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarEvent;

class CalendarEventController extends Controller
{
    public function index()
    {
        $events = CalendarEvent::orderBy('start_date', 'desc')->get();
        return view('admin.calendar.index', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'category' => 'required|in:holiday,event,cuti_bersama',
            'is_day_off' => 'boolean'
        ]);

        CalendarEvent::create($request->all());

        return redirect()->back()->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function update(Request $request, CalendarEvent $calendar)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'category' => 'required|in:holiday,event,cuti_bersama',
            'is_day_off' => 'boolean'
        ]);

        $calendar->update($request->all());

        return redirect()->back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(CalendarEvent $calendar)
    {
        $calendar->delete();
        return redirect()->back()->with('delete', 'Agenda berhasil dihapus.');
    }
}
