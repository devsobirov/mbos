<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        //dd(auth()->user());
        return view('auth.profile');
    }

    public function update(Request $request)
    {
        if ($request->password) {
            auth()->user()->update(['password' => Hash::make($request->password)]);
        }

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'telegram_chat_id' => $request->telegram_chat_id
        ]);

        return redirect()->back()->with('success', 'Profile updated.');
    }
}
