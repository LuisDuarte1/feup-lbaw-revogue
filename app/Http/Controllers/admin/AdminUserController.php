<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function updateStatus(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        return redirect()->back();
    }

    public function getPage(Request $request)
    {
        $users = User::orderBy('id', 'asc')->paginate(20);

        return view('pages.admin.users', ['users' => $users]);
    }

    public function removeUser(Request $request)
    {

        $user = User::find($request->id);

        if ($user->delete()) {
            return back()->with('success', 'User deleted successfully');
        }

        return back()->with('error', 'User not deleted');
    }

    public function banUser(Request $request)
    {

        $user = User::find($request->id);
        if ($user->account_status !== 'banned') {
            $user->account_status = 'banned';
            $user->save();

            return back()->with('success', 'User banned successfully');
        } else {
            return back()->with('error', 'User already banned');
        }
    }

    public function unbanUser(Request $request)
    {
        $user = User::find($request->id);
        if ($user->account_status == 'banned') {
            $user->account_status = 'active';
            $user->save();

            return back()->with('success', 'User unbanned successfully');
        } else {
            return back()->with('error', 'User already unbanned');
        }
    }
}
