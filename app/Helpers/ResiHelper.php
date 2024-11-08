<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ResiHelper
{
    /**
     * Generate a unique resi number for a package.
     *
     * @return string
     */
    public static function generateResiNumber()
    {
        // Prefix for the resi number
        $prefix = 'PKG';
        $uniquePart = strtoupper(Str::random(6));  // Generate a random 6-character alphanumeric string
        return $prefix . date('YmdHis') . $uniquePart;
    }
}
