<?php

function check_anagram($stringtr1,$stringtr2)
{
    if (strlen($stringtr1) != strlen($stringtr2)) {
       return false;
    }

    $stringtr1Array = str_split($stringtr1);
    $stringtr2Array = str_split($stringtr2);
    sort($stringtr1Array);
    sort($stringtr2Array);
    if($stringtr1Array === $stringtr2Array)
        return 1;
    else
        return 0;
}
////////////////////////////////////////////////////////
function check_special_anagram($stringtr1, $stringtr2)
{
    if (count_chars($stringtr1, 1) == count_chars($stringtr1, 1)) {
        return 1;
    } else {
        return 0;
    }
}
//echo check_special_anagram('abcd', 'dcba');
//
//echo check_anagram("abcd","dcba");



