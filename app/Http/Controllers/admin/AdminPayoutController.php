<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\User;

class AdminPayoutController extends Controller
{
    public function getPage(Request $request)
    {
        $payout = Payout::paginate(20);
        return view(' pages.admin.payouts', ['payouts' => $payout]);
    }
}
