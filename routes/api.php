<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'phone_number' => 'required',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('phone_number', $request->phone_number)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'phone_number' => ['The provided credentials are incorrect.'],
        ]);
    }

    $user->tokens()->delete();

    $token = $user->createToken($request->device_name)->plainTextToken;
    
    return response()->json([
        'message' => 'Logged in successfully',
        'token' => $token
    ]);
});

Route::post('/sanctum/logout', function(Request $request){
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'logged out successfully']);
})->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    $user = User::where('id', $request->user()->id)
        ->with('territory')
        ->first();
    return response()->json($user);
})->middleware('auth:sanctum');
