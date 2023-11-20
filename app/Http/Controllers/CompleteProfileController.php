<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompleteProfileController extends Controller
{
    public function getPage(Request $request)
    {
        return view('pages.completeProfile', ['imagePath' => $request->user()->profile_image_path ?? '/defaultProfileImage.png']);
    }

    public function postProfile(Request $request)
    {
        $validated = $request->validate([
            'bio' => 'nullable|string|max:10000',
            'profileImage' => 'nullable|image|max:5000',
        ]);

        $user = $request->user();

        if ($request->filled('bio') && $validated['bio']) {
            $user->update(['bio' => $validated['bio']]);
        }
        if ($request->hasFile('profileImage')) {
            if (isset($request->user()->profile_image_path)) {
                Storage::disk('public')->delete($request->user()->profile_image_path);
            }
            $filename = $user->id.'-'.$request->file('profileImage')->getClientOriginalName();
            $path = $request->file('profileImage')->storeAs('avatars', $filename, 'public');
            $user->update(['profile_image_path' => $path]);
        }

        return redirect('/');
    }
}
