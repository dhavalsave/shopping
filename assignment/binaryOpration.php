<?php
function stringFormation($string)
{
    $n = strlen($string);


    for ($i = 0; $i < $n; $i += 2) {


        if (($i + 1) < $n && $string[$i + 1] == 'A') {
            if ($string[$i + 2] == '0' || $string[$i] == '0')
                $string[$i + 2] = '0';
            else
                $string[$i + 2] = '1';
        }


        else if (($i + 1) < $n && $string[$i + 1] == 'B') {
            if ($string[$i + 2] == '1' || $string[$i] == '1')
                $string[$i + 2] = '1';
            else
                $string[$i + 2] = '0';
        }

        else {
            if (($i + 2) < $n && $string[$i + 2] == $string[$i])
                $string[$i + 2] = '0';
            else
                $string[$i + 2] = '1';
        }
    }
    return $string[$n - 1] - '0';
}


$string = "1C1B1B0A0";
echo stringFormation($string);
