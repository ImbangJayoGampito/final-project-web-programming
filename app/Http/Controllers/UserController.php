<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    // Show the user's profile
    public function show(string $id)
    {
        if (!Auth::user()) {
            return redirect()->route('login')->with('error', 'You must be logged in to view a profile!');
        }
        $user = User::find($id);
        if (!$user) {
            return view('users.profile')->with('error', 'User not found.');
        }
        return view('users.profile', compact('user'));
    }

    // Show the form to edit the user's profile
    public function edit(string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
        }
        if ((int)$user->id !== (int)$id) {
            return redirect()->route('home')->with('error', "The user ID of " . $id . " does not match the authenticated user's ID that is " . $user->id . ".");
        }
        return view('users.edit', ['user' => $user]);
    }






    // Update the user's profile
    public function update(UserEditRequest $request)
    {
        $user = Auth::user();
        $update_status = "You have changed your: ";
        $check_status = $update_status;
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your profile.');
        }

        $validated = $request->validated();
        if ($user->email !== $validated['email']) {
            $update_status .= "email, ";
            $user->email = $validated['email'];
        }
        if ($user->name !== $validated['name']) {
            $update_status .= "name, ";
            $user->name = $validated['name'];
        }

        if (!empty($validated['new_password'])) {
            // No idea how ths work.
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            if (Hash::check($validated['new_password'], $user->password)) {
                return redirect()->back()->withErrors(['new_password' => 'New password cannot be the same as the current password.']);
            }
            $user->password = Hash::make($validated['new_password']);
            $update_status .= "password, ";
        }

        /** @var \App\Models\User $user */
        $user->save();
        if ($update_status === $check_status) {
            return redirect()->route('home')->with('info', 'No changes were made to your profile.');
        }
        return redirect()->route('home')->with('success', $update_status);
    }

    // Delete the user's account
    public function destroy()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to delete your profile.');
        }
        Auth::logout();
        dd(get_class($user));
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}
