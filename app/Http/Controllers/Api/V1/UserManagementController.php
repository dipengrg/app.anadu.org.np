<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CreateUserRequest;
use App\Http\Requests\Api\V1\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserManagementController extends Controller
{
    /**
     * LIST: Fetch all users with basic server-side pagination.
     */
    public function index(): JsonResponse
    {
        $users = User::latest()->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $users,
        ]);
    }

    /**
     * ADD: Provision a new user profile securely.
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        // Because 'role' and 'is_active' are protected, we use forceCreate
        $user = User::forceCreate($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'User profile created successfully.',
            'data' => $user,
        ], 201);
    }

    /**
     * SHOW: View details of a specific user.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }

    /**
     * UPDATE: Edit an existing user profile dynamically.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        // Bypassing mass-assignment constraints to safely apply role/status updates
        $user->forceFill($request->validated())->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User profile updated successfully.',
            'data' => $user,
        ]);
    }

    /**
     * DELETE: Permanently purge or drop a user profile.
     */
    public function destroy(User $user): JsonResponse
    {
        // Defensive check: Prevent the active Admin from accidentally deleting themselves
        if (auth()->id() === $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Action denied. You cannot delete your own active session.',
            ], 400);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User profile has been permanently removed.',
        ]);
    }
}
