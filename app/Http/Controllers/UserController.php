<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('admin.users.index', compact('users'));
    }

    public function save(Request $request, ?User $user)
    {
        $data = $request->validate([
            'email' => 'string|unique:users,email,'.$user->id,
            'name' => 'required',
            'telegram_chat_id' => 'nullable',
            'role' => 'nullable|numeric'
        ]);

        if (!$user->id || $request->password) {
            $request->validate([
                'password' => 'required|confirmed|string|min:6',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->fill($data);
        $user->save();

        return redirect()->back()->with('success', 'muvaffaqiyatli saqlandi');
    }
}
