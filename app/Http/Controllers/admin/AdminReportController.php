<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MessageController;
use App\Models\MessageThread;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function getPage(Request $request)
    {
        $report = Report::orderBy('is_closed')->latest()->paginate(20);

        return view('pages.admin.reports', ['reports' => $report]);
    }

    public function updateStatus(Request $request)
    {
        $report = Report::find($request->id);
        if ($report->is_closed) {
            return redirect()->back()->withErrors(['update-error' => 'Report is already closed']);
        }
        $report->is_closed = $request->report_status;
        $report->closed_by = $request->user()->id;
        $report->save();

        return redirect()->back()->with('success', 'Report status updated successfully');
    }

    public function delete(Request $request)
    {
        $report = Report::find($request->id);
        if ($report->delete()) {
            return redirect()->back()->with('success', 'Report deleted successfully');
        }

        return redirect()->back()->withErrors(['delete-error' => 'Report not deleted']);
    }

    public function showMessageThread(Request $request)
    {
        $messageThread = MessageThread::find($request->messageThread);
        $reporter = User::find($request->reporter);
        $messages = MessageController::getMessages($reporter, $messageThread, $messageThread->messages->count());

        return view('pages.admin.messageThread', ['reporter' => $reporter, 'messages' => $messages]);
    }
}
