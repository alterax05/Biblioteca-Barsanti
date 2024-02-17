<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Exception;

class ImageController extends Controller
{

    protected $providers = [
        'ibs',
        'google',
        'abebooks'
    ];

    protected function getCoverLinkGoogle($ISBN) : string
    {
        $imageUrl = "https://www.googleapis.com/books/v1/volumes?q=isbn:" . $ISBN;

        $detailsBasic = json_decode(file_get_contents($imageUrl), true);
        if (in_array("items", array_keys($detailsBasic))) {

            $details = json_decode(file_get_contents($detailsBasic['items'][0]['selfLink']), true);

            $imageUrl = $details['volumeInfo']['imageLinks']['thumbnail'] ?? "";
            return $imageUrl;
        }
    }

    protected function getCoverLinkIBS($ISBN) : string
    {
        return "https://www.ibs.it/images/".$ISBN."_0_0_536_0_75.jpg";
    }

    protected function getCoverLinkAbeBooks($ISBN) : string
    {
        return "https://pictures.abebooks.com/isbn/".$ISBN."-us.jpg";
    }

    protected function getImageUrl($provider, $ISBN) : string
    {
        switch ($provider) {
            case 'google':
                return $this->getCoverLinkGoogle($ISBN);
            case 'ibs':
                return $this->getCoverLinkIBS($ISBN);
            case 'abebooks':
                return $this->getCoverLinkAbeBooks($ISBN);
            default:
                return "";
        }
    }

    public function getCover($ISBN)
    {
        $imagePath = 'images/covers/'. $ISBN.".jpg";

        $found = false;
        // Check if image exists locally
        if (Storage::missing($imagePath)){
            foreach ($this->providers as $provider) {
                $imageUrl = $this->getImageUrl($provider, $ISBN);
                if ($imageUrl) {
                    $response = Http::get($imageUrl);
                    if ($response->successful() && $response->body() != Storage::get('images/covers/defaultCopertinaIBS.jpg')) {
                        Storage::put($imagePath, $response->body());
                        $found = true;
                        break;
                    }
                }
            }
            if(!$found){
                $imagePath = 'images/covers/notcover.jpg';
            }
        }

        $type = Storage::mimeType($imagePath);
        // Return the image
        return response()->file(Storage::path($imagePath), ['Content-Type' => $type]);
    }
}