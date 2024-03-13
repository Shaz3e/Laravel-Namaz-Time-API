<?php

function str_slug($string)
{
    // Replace spaces and special characters with hyphens
    $string = preg_replace('/[^\w\d-]+/', '-', $string);

    // Remove consecutive hyphens
    $string = preg_replace('/-+/', '-', $string);

    // Trim hyphens from the beginning and end of the string
    $string = trim($string, '-');

    return $string;
}
