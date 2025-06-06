<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewApiController extends Controller
{
    /**
     * Display a listing of the Reviews.
     */
    public function index()
    {
        $reviews = Review::where('visibility', true)->get();
        return response()->json($reviews, 200);
    }

    /**
     * Store a newly created Review in storage.
     */
    public function store(Request $request)
    {
        $review = new Review();
        $review->msg_content = $request->get('msg_content');

        $review->reviews()->associate(User::findOrFail($request->get('user_id')));
        $review->reviews()->associate(Product::findOrFail($request->get('product_id')));

        $review->save();

        return response()->json($review, 201);
    }

    /**
     * Display the specified Review.
     */
    public function show(Review $review)
    {
        return response()->json(Review::findOrFail($review->id)->where('visibility', true)->get(), 200);
    }

    /**
     * Update the specified Review in storage.
     */
    public function update(Request $request, Review $review)
    {
        $review->msg_content = $request->get('msg_content');
        $review->reviews()->associate(User::findOrFail($request->get('review')));
        $review->reviews()->associate(Product::findOrFail($request->get('review')));

        $review->save();

        return response()->json($review, 201);
    }

    /**
     * Remove the specified Review from storage.
     */
    public function destroy(Review $review)
    {
        $review->visibility = false;
        $review->save();
        return response()->json(null, 204);
    }
}
