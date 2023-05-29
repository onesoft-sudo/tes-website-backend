<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string',
            'username' => 'required|string|unique:users',
            'email' => 'string',
            'discord_id' => 'required|string|unique:users|regex:/^\d+$/',
            'password' => 'required|string|min:2'
        ]);

        return User::create($request->only(['name', 'username', 'password', 'email', 'discord_id']));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user->only(['name', 'email', 'username', 'created_at']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string',
            'username' => 'string|unique:users',
            'email' => 'string',
            'discord_id' => 'string|unique:users|regex:/^\d+$/',
            'password' => 'string|min:2'
        ]);

        if (count($request->toArray()) == 0) {
            return response(["message" => "Nothing updated"], 400);
        }

        $user->update($request->only(['name', 'username', 'password', 'email', 'discord_id']));

        return [
            "message" => "Account details were updated"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return ["status" => "Successfully deleted account"];
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'string|min:2|max:100',
            'email' => 'string|email',
            'password' => 'required|string|min:2'
        ]);

        if (!$validated["email"] && !$validated["username"]) {
            return response([
                "error" => "You must specify a username or email to log in"
            ], 400);
        }

        /** @var User|null $user */
        $user = User::where('email', $validated['email'])->orWhere('username', $validated['username'])->get();

        if (!$user) {
            return response([
                "error" => "Incorrect email or username provided"
            ], 401);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return response([
                "error" => "Incorrect password provided"
            ], 401);
        }

        return [
            "message" => "Login successful",
            "user" => $user->only(['name', 'username', 'created_at', 'updated_at', 'token'])
        ];
    }
}
