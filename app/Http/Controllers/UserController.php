<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',
            'user_type' => 'required|in:Admin,Restaurant,Student'
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->user_type = $request->user_type;
        $user->save();

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'sometimes|required|unique:users,username,' . $user->id,
            'password' => 'sometimes|required|min:8',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'user_type' => 'sometimes|required|in:Admin,Restaurant,Student'
        ]);

        if ($request->has('username')) {
            $user->username = $request->username;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('user_type')) {
            $user->user_type = $request->user_type;
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}

