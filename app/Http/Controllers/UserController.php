<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Display users in a table
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'device_id','profile_picture')->get();
        return view('userDetails', compact('users'));
    }

    // Clear device_id for a user
    public function clearDeviceId($id)
    {
        $user = User::findOrFail($id);
        $user->update(['device_id' => null]);

        return redirect()->back()->with('success', 'Device ID cleared successfully.');
    }

    public function uploadProfilePicture(Request $request, $id)
        {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            $user = User::findOrFail($id);
            
            if ($request->hasFile('profile_picture')) {
                // Delete old image if exists
                if ($user->profile_picture) {
                    Storage::delete('public/' . $user->profile_picture);
                }
                
                // Store new image
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $user->profile_picture = $path;
                $user->save();
            }
            
            return redirect()->back()->with('success', 'Profile picture updated successfully.');
        }
}