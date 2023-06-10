<?php
/**
 * Created by NiNaCoder.
 * Date: 2023-02-20
 * Time: 21:20
 */

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class DownloadController
{
    public function downloadImage(Request $request, $imageUrl)
    {
        $imageUrl = base64_decode($imageUrl);
        if (ini_get('allow_url_fopen')) {
            $imageData = file_get_contents($imageUrl);
        } else {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $imageUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false
            ));
            $imageData = curl_exec($curl);
            curl_close($curl);
        }

        return response($imageData, 200)
            ->header('Content-Type', 'image/jpeg')
            ->header('Content-Disposition', 'attachment; filename="image.jpg"');
    }
}
