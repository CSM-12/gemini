<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GeminiAPI\Laravel\Facades\Gemini;

class DemoController extends Controller
{
    // Start a new chat session

    // Covert Gemini Mark Down to HTML
    public function convertMarkdownToHtml($text)
    {
        $html = preg_replace('/\*\*(.*?)\*\*/', '$1', $text);
        $html = str_replace('*', ', ', $html);
        return $html;
    }

    // Gemini Response
    public function showtext(Request $request)
    {

        // $chat = Gemini::startChat();

        $response = Gemini::generateTextUsingImage(
            'image/jpeg',
            base64_encode(file_get_contents($request->image)),
            'Explain this image for blind persone',
        );;
        // $response = $this->convertMarkdownToHtml($response);

        return $this->convertMarkdownToHtml($response);
        // PHP: A server-side scripting language used to create dynamic web applications.
        // Easy to learn, widely used, and open-source.
    }
}
