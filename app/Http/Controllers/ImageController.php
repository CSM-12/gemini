<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use GeminiAPI\Laravel\Facades\Gemini;

class ImageProcessingController extends Controller
{
    public function processImage(Request $request)
    {
        // Retrieve the base64-encoded image data from the request
        $imageData = $request->input('image');

        // Decode the base64 data
        $imageData = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $imageData);
        $imageData = base64_decode($imageData);

        // Save the decoded image data temporarily (optional)
        $tempImagePath = 'temp/captured_image_' . time() . '.jpg';
        Storage::disk('local')->put($tempImagePath, $imageData);

        // Use Gemini package to process the image
        try {
            $response = Gemini::generateTextUsingImage(
                'image/jpeg',                           // Image type
                base64_encode($imageData),              // Base64 encoded image data
                'Explain what is in the image'          // Prompt for Gemini
            );

            // Handle Gemini API response
            return response()->json(['result' => $response]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
