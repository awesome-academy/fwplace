<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Http\Policies\Review\ReviewPolicy;
use App\Repositories\Reviews\ReviewRepositoryInterface;

class ReviewApi extends Controller
{
    protected $review;

    public function __construct(ReviewRepositoryInterface $review)
    {
        $this->review = $review;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|string',
            'report_id' => 'required',
        ]);

        $this->review->create($request->all());

        return response()->json([
            'message' => config('api.create'),
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|string',
        ]);

        $data = $request->only('content', 'report_id');

        $data = array_merge($data, ['user_id' => Auth::user()->id]);

        if (!$request->has('id') || $request->id == null) {
            // $this->authorize('create', Review::class);
            Review::create($data);
        } else {
            $id = $request->id;
            $review = Review::findOrFail($id);
            // $this->authorize('update', $review);
            $review = $this->review->update($data, $id);
        }

        return response()->json([
            'message' => config('api.update'),
        ]);
    }

    public function destroy($id)
    {
        $review = $this->review->find($id);
        // $this->authorize('delete', $review);
        $this->review->delete($id);

        return response()->json([
            'message' => config('api.deleted'),
        ]);
    }
}
