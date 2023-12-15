<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getPage(Request $request)
    {
        $orderId = $request->route('id');
        $order = Order::find($orderId);
        if ($request->user()->cannot('create', [Review::class, $order])) {
            return redirect(route('landing'))->with('error', 'You cannot review this order');
        }

        return view('pages.addReview', ['order' => $order]);
    }

    public function postPage(Request $request)
    {

        $orderId = $request->route('id');
        $order = Order::find($orderId);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|max:255',
            'imageToUpload' => 'nullable',
        ]);

        $image_paths = [];

        $images = $request->file('imageToUpload');

        if ($images != null) {
            if (! is_array($images)) {
                $images = [$images];
            }
            foreach ($images as $image) {
                $filename = '/storage/'.$image->storePublicly('review-images', ['disk' => 'public']);
                array_push($image_paths, $filename);
            }
        }

        $review = $order->reviewedOrder()->create([
            'stars' => $validated['rating'],
            'description' => $validated['description'],
            'image_paths' => $image_paths,
            'reviewer' => $request->user()->id,
            'reviewed' => $order->products()->get()->first()->sold_by,
        ]);

        //TODO: redirect to order page
        return redirect('/')->with('success', 'Review added successfully');
    }

    public function editReviewPage(Request $request)
    {
        $order_id = $request->route('id');
        $order = Order::find($order_id);
        $review = $order->reviewedOrder()->get()->first();
        $this->authorize('update', $review);

        return view('pages.editReview', ['order' => $order, 'review' => $review]);
    }

    public function editReview(Request $request)
    {
        $order_id = $request->route('id');
        $order = Order::find($order_id);
        $review = $order->reviewedOrder()->get()->first();
        $this->authorize('update', $review);

        if ($request->hasfile('imageToUpload')) {
            $existingImages = $review->image_paths;
            if (count($existingImages) > 0) {
                foreach ($existingImages as $existingImage) {
                    $filename = public_path($existingImage);
                    unlink($filename);
                }
            }
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|max:255',
            'imageToUpload' => 'nullable',
        ]);

        $review->stars = $validated['rating'];
        $review->description = $validated['description'];

        $image_paths = [];

        $images = $request->file('imageToUpload');

        if ($images != null) {
            if (! is_array($images)) {
                $images = [$images];
            }
            foreach ($images as $image) {
                $filename = '/storage/'.$image->storePublicly('review-images', ['disk' => 'public']);
                array_push($image_paths, $filename);
            }
        }

        $review->image_paths = $image_paths;

        $review->save();

        return redirect('/profile/me/history')->with('success', 'Review edited successfully');
    }

    public function deleteReview(Request $request)
    {
        $order_id = $request->route('id');
        $order = Order::find($order_id);
        $review = $order->reviewedOrder()->get()->first();
        $this->authorize('delete', $review);

        $review->delete();

        return redirect('/profile/me/history')->with('success', 'Review deleted successfully');
    }
}
