<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    function getPage(Request $request){
        return view('pages.notifications');
    }
}
