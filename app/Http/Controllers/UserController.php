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

    public function indexJSON()
    {
        return response()->json( User::all(), 200);
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'UserRoleID' => 'required|exists:user_roles,UserRoleID',
            'Firstname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'Lastname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'MiddleInitial' => 'nullable|string|max:2|regex:/^[A-Za-z\s]+$/',
            'Suffix' => 'nullable|string|max:50',
            'ContactNo' => 'nullable|string|max:11|regex:/^[0-9]+$/|max:11',
        ], [
            'name.regex' => 'Name should be unique and only contain letters and spaces.',
            'Firstname.regex' => 'First name should only contain letters and spaces.',
            'Lastname.regex' => 'Last name should only contain letters and spaces.',
            'MiddleInitial.regex' => 'Middle initial should only contain one or two letters.',
            'ContactNo.regex' => 'Contact number should only contain digits.',
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
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'UserRoleID' => 'required|integer',
            'Firstname' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'Lastname' => 'required|string|max:255|regex:/^[A-Za-z\s]+$/',
            'MiddleInitial' => 'nullable|string|max:2|regex:/^[A-Za-z\s]+$/',
            'Suffix' => 'nullable|string|max:255',
            'ContactNo' => 'nullable|string|max:255|regex:/^[0-9]+$/|max:11',
        ], [
            'name.regex' => 'Name should be unique and only contain letters and spaces.',
            'Firstname.regex' => 'First name should only contain letters and spaces.',
            'Lastname.regex' => 'Last name should only contain letters and spaces.',
            'MiddleInitial.regex' => 'Middle initial should only contain one or two letters.',
            'ContactNo.regex' => 'Contact number should only contain digits.',
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

        return response()->json(['message' => 'User deleted successfully'], 204);
    }

    public function destroyMultiple(Request $request)
    {
        $userIds = $request->input('user_ids');
        User::whereIn('id', $userIds)->delete();

        return response()->json(['success' => true, 'ids' => $userIds]);
    }
}
