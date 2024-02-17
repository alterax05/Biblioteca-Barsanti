<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    public function getCover($ISBN)
    {
        $imagePath = 'images/covers/'. $ISBN.".jpg";

        // Check if image exists locally
        if (Storage::missing($imagePath)) {
            // Define the URL where the image should be downloaded from
            $imageUrl = "https://www.ibs.it/images/".$ISBN."_0_0_536_0_75.jpg";

            // Download the image
            $response = Http::get($imageUrl);

            // Check if the download was successful
            if ($response->successful()) {

                // Save the image locally
                Storage::put($imagePath, $response->body());

            } else {

                $imageUrl = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $ISBN;

                $detailsBasic = json_decode(file_get_contents($imageUrl), true);
                if (in_array("items", array_keys($detailsBasic))) {

                    $details = json_decode(file_get_contents($detailsBasic['items'][0]['selfLink']), true);

                    $imageUrl = $details['volumeInfo']['imageLinks']['thumbnail'];

                    // Download the image
                    $response = Http::get($imageUrl);

                    // Check if the download was successful
                    if ($response->successful()) {
                        // Save the image locally
                        Storage::put($imagePath, $response->body());

                    } else {
                        // Handle the error or return a default image
                        abort(404, 'Image not found.');
                    }
                }else{
                    // Handle the error or return a default image
                    abort(404, 'Image not found.');
                }
            }
        }

        // Return the image
        return response()->file(Storage::path($imagePath), ['Content-Type' => 'image/jpeg']);
    }
}
