<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Models\Director;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $movies = Movie::where('visibility', 1)->paginate(6);
        return view('movies.index', compact('movies'));
    }

     /**
     * Display a movie by year. Not standard.
     */
    public function getMoviesByYear(string $year): View {

        $movies = Movie::where('year', $year)
            ->where('visibility', '=', 1)
            ->paginate(6);
        return view('movies.byyear', compact('movies', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $directors = Director::All();
        return view('movies.create', compact('directors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $movie = new Movie();
        $movie->title = $request->get('title');
        $movie->slug = Str::slug($movie->title);
        $movie->year = $request->get('year');
        $movie->plot = $request->get('plot');
        $movie->rating = $request->get('rating');
        $movie->visibility = $request->has('visibility') ? 1 : 0;
        $movie->director()
        ->associate(Director::findOrFail($request->get('director')));
        $movie->save();

        return view('movies.stored', compact('movie'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): Mixed
    {
        Movie::findOrFail($movie->id);
        if($movie->visibility == 0) {
            return redirect()->route('movies.index');
        }
        return view('movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        $directors = Director::All();
        return view('movies.edit', compact('movie', 'directors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $movie->title = $request->get('title');
        $movie->slug = Str::slug($movie->title);
        $movie->year = $request->get('year');
        $movie->plot = $request->get('plot');
        $movie->rating = $request->get('rating');
        $movie->visibility = $request->has('visibility') ? 1 : 0;
        $movie->director()
        ->associate(Director::findOrFail($request->get('director')));
        $movie->save();

        return view('movies.edited', compact('movie'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        Movie::findOrFail($movie->id)->delete();
        return redirect()->route('movies.index');
    }
}
