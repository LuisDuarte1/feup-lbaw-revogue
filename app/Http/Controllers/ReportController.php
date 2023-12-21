<?php

namespace App\Http\Controllers;

use App\Models\MessageThread;
use App\Models\Product;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportProductAPI(Request $request)
    {
        $productId = $request->route('id');
        $product = Product::where('id', $productId)->get()->first();
        if ($product === null) {
            return response()->json(['error' => 'Product does not exist'], 404);
        }
        $request->validate([
            'reason' => 'required|max:500',
        ]);
        $reporter = $request->user();
        $reported = $product->soldBy;

        $report = Report::where('reporter', $reporter->id)->where('reported', $reported->id)->where('product', $product->id)->get()->first();
        if ($report !== null) {
            return response()->json(['error' => 'You have already reported this product'], 400);
        }

        $report = Report::create([
            'type' => 'product',
            'is_closed' => false,
            'message_thread' => null,
            'reason' => $request->reason,
            'reported' => $reported->id,
            'reporter' => $reporter->id,
            'product' => $product->id,
            'closed_by' => null,
        ]);

        return response()->json([]);
    }

    public function reportUserAPI(Request $request)
    {

        $request->validate([
            'reason' => 'required|max:500',
        ]);

        $reported = User::where('id', $request->route('id'))->get()->first();
        if ($reported === null) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $reporter = $request->user();

        $report = Report::where('reporter', $reporter->id)->where('reported', $reported->id)->get()->first();
        if ($report !== null && $report->type === 'user') {
            return response()->json(['error' => 'You have already reported this user'], 400);
        }

        $report = Report::create([
            'type' => 'user',
            'is_closed' => false,
            'message_thread' => null,
            'reason' => $request->reason,
            'reported' => $reported->id,
            'reporter' => $reporter->id,
            'product' => null,
            'closed_by' => null,
        ]);

        return response()->json([]);

    }

    public function reportMessageThreadAPI(Request $request)
    {
        $request->validate([
            'reason' => 'required|max:500',
        ]);

        $messageThread = MessageThread::find($request->route('id'));
        if ($messageThread === null) {
            return response()->json(['error' => 'Message thread not found'], 404);
        }

        $report = Report::where('message_thread', $messageThread->id)->get()->first();
        if ($report !== null) {
            return response()->json(['error' => 'You have already reported this message thread'], 400);
        }
        if ($messageThread->user_1 !== $request->user()->id) {
            return response()->json(['error' => 'You cannot report this message thread'], 400);
        }

        $report = Report::create([
            'type' => 'message_thread',
            'is_closed' => false,
            'message_thread' => $messageThread->id,
            'reason' => $request->reason,
            'reported' => $messageThread->user_2,
            'reporter' => $request->user()->id,
            'product' => $messageThread->product,
            'closed_by' => null,
        ]);

        return response()->json([]);

    }
}
