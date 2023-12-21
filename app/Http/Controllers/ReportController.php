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
            return back()->withErrors(['create-error' => 'Product does not exist']);
        }
        $request->validate([
            'reason' => 'required|max:500',
        ]);
        $reporter = $request->user();
        $reported = $product->soldBy;

        $report = Report::where('reporter', $reporter->id)->where('reported', $reported->id)->where('product', $product->id)->get()->first();
        if ($report !== null) {
            return back()->withErrors(['create-error' => 'You have already reported this product']);
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

        return redirect('/products/'.$product->id)->with('success', 'Report sent successfully');
    }

    public function reportUserAPI(Request $request)
    {

        $request->validate([
            'reason' => 'required|max:500',
        ]);

        $reported = User::where('id', $request->route('id'))->get()->first();
        if ($reported === null) {
            return back()->withErrors(['create-error' => 'User not found']);
        }
        $reporter = $request->user();

        $report = Report::where('reporter', $reporter->id)->where('reported', $reported->id)->get()->first();
        if ($report !== null && $report->type === 'user') {
            return back()->withErrors(['create-error' => 'You have already reported this user']);
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

        return redirect('/profile/'.$reported->id)->with('success', 'User reported successfully');
    }

    public function reportMessageThreadAPI(Request $request)
    {
        $request->validate([
            'reason' => 'required|max:500',
        ]);

        $messageThread = MessageThread::find($request->route('id'));
        if ($messageThread === null) {
            return back()->withErrors(['create-error' => 'Message thread not found']);
        }

        $report = Report::where('message_thread', $messageThread->id)->get()->first();
        if ($report !== null) {
            return back()->withErrors(['create-error' => 'You have already reported this message thread']);
        }
        if ($messageThread->user_1 !== $request->user()->id) {
            return back()->withErrors(['create-error' => 'You cannot report this message thread']);
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

        return redirect('/messages?thread='.$messageThread->id)->with('success', 'Message thread reported successfully');
    }
}
