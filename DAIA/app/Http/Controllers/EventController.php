<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the Event.
     */
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new Event.
     */
    public function create()
    {
        $events = Event::all();
        return view('events.create', compact('events'));
    }

    /**
     * Store a newly created Event in storage.
     */
    public function store(Request $request)
    {
        $event = new Event();
        $fileName = $request->get('event_img') . '.jpg';
        $event->event_name = $request->get('event_name');
        $event->slug = Str::slug($event->event_name);
        $event->event_desc = $request->get('event_desc');
        $request->file('event_img')->storeAs('events', $fileName);
        $event->event_img = 'storage/events/'. $fileName;
        $event->external_url = $request->get('external_url');
        $event->save();

        return view('events.show', compact('event'));
    }

    /**
     * Display the specified Event.
     */
    public function show(Event $event)
    {
        Event::findOrFail($event->id);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified Event.
     */
    public function edit(Event $event)
    {
        $events = Event::All();
        return view('events.edit', compact('event', 'events'));
    }

    /**
     * Update the specified Event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $fileName = $request->get('event_img') . '.jpg';
        $event->event_name = $request->get('event_name');
        $event->slug = Str::slug($event->event_name);
        $event->event_desc = $request->get('event_desc');
        $request->file('event_img')->storeAs('events', $fileName);
        $event->event_img = 'storage/events/'. $fileName;
        $event->external_url = $request->get('external_url');
        $event->save();

        return view('events.show', compact('$event'));
    }

    /**
     * Remove the specified Event from storage.
     */
    public function destroy(Event $event)
    {
        Event::findOrFail($event->id)->delete();
        return redirect()->route('events.index');
    }
}
