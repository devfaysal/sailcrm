<?php

use App\Http\Controllers\Api\ImageUploadController;
use App\Http\Controllers\Api\LeadController;
use App\Models\Crop;
use App\Models\Problem;
use App\Models\Product;
use App\Models\User;
use Devfaysal\BangladeshGeocode\Models\Union;
use Devfaysal\BangladeshGeocode\Models\Upazila;
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

Route::get('/user/data', function (Request $request) {
    $user = User::where('id', $request->user()->id)
        ->with('territory')
        ->first();
    $upazilaIds = $user->territory?->areas;
    $upazilas = Upazila::whereIn('id', $upazilaIds)->select('id', 'bn_name')->with('unions')->get();
    $products = Product::select('id', 'name')->get();
    $problems = Problem::select('id', 'name')->get();
    $crops = Crop::select('id', 'name')->get();
    $user->products = $products;
    $user->problems = $problems;
    $user->crops = $crops;
    $user->upazilas = $upazilas;
    return response()->json($user);
})->middleware('auth:sanctum');

Route::get('/leads', function (Request $request) {
    $user = $request->user()->territory->leads;
    return response()->json($user);
})->middleware('auth:sanctum');

Route::post('/leads/create', [LeadController::class, 'store'])->middleware('auth:sanctum');

Route::post('/upload-image', [ImageUploadController::class, 'store'])->middleware('auth:sanctum');


