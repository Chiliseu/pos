<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('userManage', compact('users'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'UserRoleID' => 'required|integer',
            'Firstname' => 'required|string|max:50',
            'Lastname' => 'required|string|max:50',
            'MiddleInitial' => 'nullable|string|max:1',
            'Suffix' => 'nullable|string|max:50',
            'ContactNo' => 'nullable|string|max:15',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    public function show($id) {
        return User::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
            'UserRoleID' => 'sometimes|integer',
            'Firstname' => 'sometimes|string|max:50',
            'Lastname' => 'sometimes|string|max:50',
            'MiddleInitial' => 'nullable|string|max:1',
            'Suffix' => 'nullable|string|max:50',
            'ContactNo' => 'nullable|string|max:15',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json($user);
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
