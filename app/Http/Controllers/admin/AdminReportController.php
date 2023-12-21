<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function getPage(Request $request)
    {
        $report = Report::paginate(20);

        return view('pages.admin.reports', ['reports' => $report]);
    }
}
