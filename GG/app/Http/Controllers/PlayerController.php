<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Player;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::all();
        return view('players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $player = Player::All();
        return view('players.add', compact('player'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $player = new Player();
        $player->name = $request->get('name');
        $player->slug = Str::slug($player->name);
        $player->age = $request->get('age');
        $player->position = $request->get('position');
        $player->twitter = $request->get('twitter');
        $player->instagram = $request->get('instagram');
        $player->twitch = $request->get('twitch');
        $player->position = $request->get('position');
        $player->avatar = $request->has('avatar') ? $request->get('avatar') : null;
        $player->visible = $request->has('visible') ? 1 : 0;

        $player->events()
        ->associate(Event::findOrFail($request->get('event')));

        $player->save();

        return view('players.show', compact('player'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        Player::findOrFail($player->id);
        if($player->visible == 0) {
            return redirect()->route('players.index');
        }
        return view('players.show', compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        $players = Player::All();
        return view('players.edit', compact('player', 'players'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Player $player)
    {
        $player->name = $request->get('name');
        $player->slug = Str::slug($player->name);
        $player->age = $request->get('age');
        $player->position = $request->get('position');
        $player->twitter = $request->get('twitter');
        $player->instagram = $request->get('instagram');
        $player->twitch = $request->get('twitch');
        $player->position = $request->get('position');
        $player->avatar = $request->has('avatar') ? $request->get('avatar') : null;
        $player->visible = $request->has('visible') ? 1 : 0;

        $player->events()
        ->associate(Event::findOrFail($request->get('event')));

        $player->save();

        return view('players.edit', compact('player'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        Player::findOrFail($player->id)->delete();
        return redirect()->route('players.index');
    }
}
