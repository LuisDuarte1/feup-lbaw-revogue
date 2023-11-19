<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompleteProfileController extends Controller
{
    function getPage(Request $request){
        return view('pages.completeProfile', ['imagePath' => $request->user()->profile_image_path ?? '/defaultProfileImage.png']);
    }

    function postProfile(Request $request){
        
    }
}
