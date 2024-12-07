<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'picture' => File::image()->max(1024)
        ]);

        // Store the image
        if ($request->file('picture')) {
            $path = $request->file('picture')->store('uploads', 'public');

            // Return the image URL
            return response()->json([
                'message' => 'Image uploaded successfully!',
                'path' => $path,
            ], 200);
        }

        return response()->json([
            'message' => 'Failed to upload image.',
        ], 400);
    }
}
