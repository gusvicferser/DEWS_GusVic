<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EventApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        foreach($events as $key => $event) {
            if($key === 'event_img') {
                $events->$key = asset($event);
            }
        }
        return response()->json($events, 200);
    }

    /**
     * Store a newly created resource in storage.
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

        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->event_img = asset($event->event_img);
        return response()->json($event, 200);
    }

    /**
     * Update the specified resource in storage.
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
