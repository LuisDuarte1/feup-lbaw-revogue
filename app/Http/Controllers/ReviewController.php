<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getPage(Request $request)
    {
        $orderId = $request->route('id');
        return view('pages.addReview', ['orderId' => $orderId]);
    }

    public function postPage(Request $request)
    {

        $orderId = $request->route('id');
        $order = Order::find($orderId);
        if ($order === null) {
            return back()->with('errors', 'Order not found');
        }
        
        if ($order->reviewedOrder !== null) {
            return back()->with('errors', 'Order already reviewed');
        }
        if ($order->status !== 'delivered') {
            return back()->with('errors', 'Order not delivered');
        }
        if ($order->user()->get()->first()->id !== $request->user()->id) {
            return back()->with('errors', 'Order not owned by user');
        }


        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'nullable|max:255',
            'imageToUpload' => 'nullable'
        ]);

        $review = $order->reviewedOrder()->create([
            'stars' => $validated['rating'],
            'description' => $validated['description'],
            'image_paths' => $validated['imageToUpload'],
            'reviewer' => $request->user()->id,
            'reviewed' => $order->products()->get()->first()->sold_by
        ]);


        return redirect('/')->with('success', 'Review added successfully');
    }
}
