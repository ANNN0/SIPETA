<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class CloudinaryHelper
{
    /**
     * Optimize Cloudinary URL by adding auto format, auto quality, and optional resizing.
     *
     * @param string $url Original Cloudinary URL
     * @param int|null $width Desired width
     * @param int|null $height Desired height
     * @param string $crop Crop mode (default: limit)
     * @return string Optimized URL
     */
    public static function optimize($url, $width = null, $height = null, $crop = 'limit')
    {
        if (!$url || !Str::startsWith($url, 'https://res.cloudinary.com')) {
            return $url;
        }

        // Avoid double transformation if already present
        if (Str::contains($url, 'f_auto') || Str::contains($url, 'q_auto')) {
            return $url;
        }

        $transformations = ['f_auto', 'q_auto'];

        if ($width) {
            $transformations[] = "w_$width";
        }

        if ($height) {
            $transformations[] = "h_$height";
        }

        if ($width || $height) {
            $transformations[] = "c_$crop";
        }

        $transString = implode(',', $transformations);

        return Str::replace('/upload/', "/upload/$transString/", $url);
    }
}
