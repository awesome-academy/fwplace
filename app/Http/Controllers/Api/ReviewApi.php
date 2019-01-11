<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Review;
use App\Http\Policies\Review\ReviewPolicy;
use App\Http\Resources\ReviewResource;
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

        $id = $request->id;

        if ($id == null) {
            $this->authorize('create', Review::class);
            Review::create($request->only(
                'content',
                'report_id'
            ));
        } else {
            $review = Review::findOrFail($id);
            $this->authorize('update', $review);
            $review = $this->review->update($request->only(
                'content',
                'report_id'
            ), $id);
        }

        return response()->json([
            'message' => config('api.update'),
        ]);
    }

    public function destroy($id)
    {
        $review = $this->review->find($id);
        $this->authorize('delete', $review);
        $this->review->delete($id);

        return response()->json([
            'message' => config('api.deleted'),
        ]);
    }
}
