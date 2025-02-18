<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Player;
use Illuminate\Http\Request;

class EventApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json($events, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $event = new Event();
        $event->name = $request->get('name');
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

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json($event, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $event->name = $request->get('name');
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

        return response()->json($event, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json($event, 204);
    }
}
