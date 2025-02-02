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
        return response()->json(User::all(), 200);
    }

    public function store(Request $request)
    {
        // Validation rules
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'UserRoleID' => 'required|exists:user_roles,UserRoleID',
            'Firstname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'Lastname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'MiddleInitial' => 'nullable|string|max:2|regex:/^[A-Za-z\s]+$/',
            'Suffix' => 'nullable|string|max:50',
            'ContactNo' => 'nullable|string|max:11|regex:/^[0-9]+$/|max:11',
        ], [
            'Firstname.regex' => 'First name should only contain letters and spaces.',
            'Lastname.regex' => 'Last name should only contain letters and spaces.',
            'MiddleInitial.regex' => 'Middle initial should only contain one or two letters.',
            'ContactNo.regex' => 'Contact number should only contain digits.',
        ]);

        // Concatenate Firstname and Lastname to create the name
        $validatedData['name'] = $validatedData['Firstname'] . ' ' . $validatedData['Lastname'];

        // Hashing the password before saving
        $validatedData['password'] = bcrypt($validatedData['password']);
        
        // Creating the user
        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, User $user)
    {
        // Validation rules for updating the user
        $data = $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'UserRoleID' => 'required|integer|exists:user_roles,UserRoleID',
            'Firstname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'Lastname' => 'required|string|max:50|regex:/^[A-Za-z\s]+$/',
            'MiddleInitial' => 'nullable|string|max:2|regex:/^[A-Za-z\s]+$/',
            'Suffix' => 'nullable|string|max:50',
            'ContactNo' => 'nullable|string|max:11|regex:/^[0-9]+$/|max:11',
        ], [
            'Firstname.regex' => 'First name should only contain letters and spaces.',
            'Lastname.regex' => 'Last name should only contain letters and spaces.',
            'MiddleInitial.regex' => 'Middle initial should only contain one or two letters.',
            'ContactNo.regex' => 'Contact number should only contain digits.',
        ]);

        // Concatenate Firstname and Lastname to create the name
        $data['name'] = $data['Firstname'] . ' ' . $data['Lastname'];

        // Hash password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        // Updating the user
        $user->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        // Find the user and delete it
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 204);
    }

    public function destroyMultiple(Request $request)
    {
        // Delete multiple users
        $userIds = $request->input('user_ids');
        User::whereIn('id', $userIds)->delete();

        return response()->json(['success' => true, 'ids' => $userIds]);
    }
}
