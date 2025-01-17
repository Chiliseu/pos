<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('userManage', compact('users'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'UserRoleID' => 'required|integer',
            'Firstname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'Lastname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'MiddleInitial' => 'nullable|string|max:1|regex:/^[A-Za-z\s]+$/',
            'Suffix' => 'nullable|string|max:50',
            'ContactNo' => 'nullable|string|max:15|regex:/^[0-9]+$/|max:15',
        ]);

        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    public function show($id) {
        return User::findOrFail($id);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'UserRoleID' => 'required|integer',
            'Firstname' => 'required|string|max:255',
            'Lastname' => 'required|string|max:255',
            'MiddleInitial' => 'nullable|string|max:1',
            'Suffix' => 'nullable|string|max:255',
            'ContactNo' => 'nullable|string|max:255',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }

    public function destroyMultiple(Request $request)
    {
        $userIds = $request->input('user_ids');
        User::whereIn('id', $userIds)->delete();

        return response()->json(['success' => true, 'ids' => $userIds]);
    }
}
