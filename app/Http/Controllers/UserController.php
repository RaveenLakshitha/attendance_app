<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Display users in a table
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'device_id')->get();
        return view('userDetails', compact('users'));
    }

    // Clear device_id for a user
    public function clearDeviceId($id)
    {
        $user = User::findOrFail($id);
        $user->update(['device_id' => null]);

        return redirect()->back()->with('success', 'Device ID cleared successfully.');
    }
}