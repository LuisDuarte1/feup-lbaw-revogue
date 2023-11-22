<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = $request->status;
        $user->save();
        return redirect()->back();
    }
    public function getPage(Request $request)
    {
        $users = User::paginate(20);
        return view('pages.admin.users', ['users' => $users]);
    }
}
