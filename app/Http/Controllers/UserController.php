<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

public function getUserProfile(Request $request)
{
    // Get the user ID from the query parameter
    $userId = $request->query('id');

    // Find the user by the provided ID
    $user = User::find($userId);

    // Check if the user exists
    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }
    
    // Return the user's profile data
    return response()->json($user);
}

}