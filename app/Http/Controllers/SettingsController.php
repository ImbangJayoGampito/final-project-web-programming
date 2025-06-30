<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateSettingsRequest; // Assuming you have a request class for validation
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your settings.');
        }
        if ((int)$user->id !== (int)$id) {
            return redirect()->route('home')->with('error', "The user ID of " . $id . " does not match the authenticated user's ID that is " . $user->id . ".");
        }
        return view('settings.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingsRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to update your settings.');
        }

        $validated = $request->validated();
        /** @var \App\Models\User $user */
        $user->settings()->update($validated);

        return redirect()->route('settings.edit', ['setting' => $user->settings->id])
            ->with('success', 'Settings updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
