<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        return UserRole::all();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'RoleName' => 'required|in:Staff,Admin',
        ]);

        $userRole = UserRole::create($validatedData);

        return response()->json($userRole, 201);
    }

    public function show($id)
    {
        return UserRole::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $userRole = UserRole::findOrFail($id);

        $validatedData = $request->validate([
            'RoleName' => 'required|in:Staff,Admin',
        ]);

        $userRole->update($validatedData);

        return response()->json($userRole);
    }

    public function destroy($id)
    {
        $userRole = UserRole::findOrFail($id);
        $userRole->delete();

        return response()->json(['message' => 'UserRole deleted'], 204);
    }
}
