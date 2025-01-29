<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    public function uploadProfilePhoto(Request $request)
{
    // Validate the request to ensure the file is an image
    $validator = Validator::make($request->all(), [
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust file size as needed
    ]);

    // Return validation errors if validation fails
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Get the authenticated user
    $user = Auth::user();

    // Check if the user is authenticated
    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    // Handle the uploaded photo
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        // Store the photo in the public storage
        $path = $photo->storeAs('public/profile_photos', $user->id . '.' . $photo->getClientOriginalExtension());

        // Check if the user already has a profile in the user_profiles table
        $userProfile = UserProfile::updateOrCreate(
            ['user_id' => $user->id], // Check if the user already has a profile
            ['profile_photo_path' => $path] // Store the file path
        );

        return response()->json(['success' => 'Profile photo uploaded successfully', 'photo_path' => $path]);
    }

    return response()->json(['error' => 'No photo file uploaded'], 400);
}

}
