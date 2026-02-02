<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
  public function index()
{
    $events = Event::all();
    $calendarEvents = $events->map(fn($e) => [
        'id' => $e->id,
        'title' => $e->title,
        'start' => $e->event_date,
        'description' => $e->description
    ])->toArray();

    return view('Admin.Event.index', compact('events', 'calendarEvents'));
}

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ], 422);
        }
        $event =  Event::create([
            'title' => $request->title,
            'event_date' => $request->event_date,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Event added successfully!',
            'event' => $event
        ]);
    }
    public function fetchEvents()
    {
        $events = Event::all()->map(fn($e) => [
            'id' => $e->id,
            'title' => $e->title,
            'start' => $e->event_date,
            'description' => $e->description,
        ]);

        return response()->json($events);
    }
}
