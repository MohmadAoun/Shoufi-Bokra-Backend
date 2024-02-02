<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organizer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\RegisterationRequest;
use App\Http\Requests\Auth\UpdateUserProfileRequest;
use App\Http\Requests\Auth\LoginRequest;

class PassportAuthController extends Controller
{
    public function register(RegisterationRequest $request)
    {
        $validatedData = $request->validated();

        $existingUser = User::where('phone_number', $validatedData['phone_number'])->first();
        $existingOrganizer = Organizer::where('phone_number', $validatedData['phone_number'])->first();

        if ($existingUser || $existingOrganizer) {
            return response()->json(['errors' => ['Phone number already exists']], 400);
        }

        if ($validatedData['role'] === 'User') {
            $user = User::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'phone_number' => $validatedData['phone_number'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
            ]);
        } elseif ($validatedData['role'] === 'Organizer') {
            $user = Organizer::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'display_name' => $validatedData['display_name'],
                'phone_number' => $validatedData['phone_number'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
            ]);
        } else {
            return response()->json(['error' => 'Invalid user type'], 400);
        }

        $token = $user->createToken('salt')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('phone_number', $validatedData['phone_number'])->first();

        if (!$user) {
            $user = Organizer::where('phone_number', $validatedData['phone_number'])->first();

            if (!$user) {
                return response()->json(['errors' => ['User not found']], 404);
            }
        }

        if (!Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['error' => ['Unauthorized']], 401);
        }

        $token = $user->createToken('salt')->accessToken;

        return response()->json(['token' => $token, 'user' => $user], 200);
    }


    public function update(UpdateUserProfileRequest $request)
    {
        $user = Auth::user();

        if ($request->filled('first_name')) {
            $user->first_name = $request->input('first_name');
        }

        if ($request->filled('last_name')) {
            $user->last_name = $request->input('last_name');
        }

        if ($request->filled('phone_number')) {
            $user->phone_number = $request->input('phone_number');
        }

        if ($request->has('profile_image')) {
            try {
                $image = $request->file('profile_image');

                $previousProfileImage = basename($user->profile_image);
                if ($previousProfileImage) {
                    $previousImagePath = "public/profile/{$user->id}/$previousProfileImage";
                    Storage::delete($previousImagePath);
                }
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs("public/profile/{$user->id}", $filename);
                $user->profile_image = Storage::url($imagePath);
            } catch (\Exception $e) {
                return response()->json(['error' => $e], 500);
            }
        }
        $user->save();

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user], 200);
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }
}
