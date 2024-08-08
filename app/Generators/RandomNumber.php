<?php

namespace App\Generators;

class RandomNumber
{
    function HouseholdNumber()
    {
        $firstPart = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $secondPart = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $thirdPart = str_pad(rand(0, 99), 2, '0', STR_PAD_LEFT);
        return "HN-{$firstPart}-{$secondPart}-{$thirdPart}";
    }
}
