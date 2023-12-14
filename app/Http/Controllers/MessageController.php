<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getPage(Request $request){
        return view('pages.messages');
    }
}
