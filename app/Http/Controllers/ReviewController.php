<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function getPage(Request $request)
    {
        return view('pages.addReview');
    }
}
