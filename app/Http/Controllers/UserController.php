<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [
                'users' => UserResource::collection($users)
            ],
            'message' => 'Users fetched successfully'
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [
                'user' => new UserResource($user)
            ],
            'message' => 'User fetched successfully'
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => $validator->errors(),
                'message' => 'Validation failed'
            ], 400);
        }
        $user = User::create($request->all());
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [
                'user' => new UserResource($user)
            ],
            'message' => 'User created successfully'
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => $validator->errors(),
                'message' => 'Validation failed'
            ], 400);
        }
        $user->name = $request->name;
        $user->save();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [
                'user' => new UserResource($user)
            ],
            'message' => 'User updated successfully'
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [],
            'message' => 'User deleted successfully'
        ]);
    }

    public function assignPermission(Request $request, Role $role)
    {
        if(!$request->user()->is_super_admin) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => [],
                'message' => 'You are not authorized to perform this action'
            ], 400);
        }
        $role->permissions()->sync($request->permissions);
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [],
            'message' => 'Permissions assigned successfully'
        ]);
    }

    public function assignRole(Request $request, User $user)
    {
        if(!$request->user()->is_super_admin) {
            return response()->json([
                'success' => false,
                'code' => 400,
                'data' => [],
                'message' => 'You are not authorized to perform this action'
            ], 400);
        }
        $user->role_id = $request->role_id;
        $user->save();
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => [],
            'message' => 'Role assigned successfully'
        ]);
    }
}
