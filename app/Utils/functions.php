<?php

namespace App\Helpers;


function stringFloatToCents($value)
{
    return str_replace(['.', ','], '', $value);
}

function showCentsValue($value)
{
    return number_format($value / 100, 2, ',');
}
