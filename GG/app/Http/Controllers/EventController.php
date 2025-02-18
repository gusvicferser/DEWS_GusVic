<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::All();
        return view('events.add', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $event = new Event();
        $event->name = $request->get('name');
        $event->slug = Str::slug($event->name);
        $event->description = $request->get('description');
        $event->location = $request->get('location');
        $event->date = $request->get('date');
        $event->time = $request->get('time');
        $event->type = $request->get('type');
        $event->tags = $request->get('tags');
        $event->visible = $request->has('visible') ? 1 : 0;

        $event->events()
        ->associate(Player::findOrFail($request->get('event')));

        $event->save();

        return view('events.show', compact('event'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        Event::findOrFail($event->id);
        if($event->visible == 0) {
            return redirect()->route('events.index');
        }
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $events = Event::All();
        return view('events.edit', compact('event', 'events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event->name = $request->get('name');
        $event->slug = Str::slug($event->name);
        $event->description = $request->get('description');
        $event->location = $request->get('location');
        $event->date = $request->get('date');
        $event->time = $request->get('time');
        $event->type = $request->get('type');
        $event->tags = $request->get('tags');
        $event->visible = $request->has('visible') ? 1 : 0;

        $event->events()
        ->associate(Player::findOrFail($request->get('event')));

        $event->save();

        return view('events.show', compact('event'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        Event::findOrFail($event->id)->delete();
        return redirect()->route('events.index');
    }
}
