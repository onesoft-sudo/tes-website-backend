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
        return $user;
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
}
