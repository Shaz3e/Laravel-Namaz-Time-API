<?php


function PrayerDate($value)
{
    return date('Y-m-d', strtotime($value));
}

function PrayerTime($value)
{
    return date('h:m A', strtotime($value));
}
