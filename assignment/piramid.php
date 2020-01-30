<?php
function piramid($n)
{
    $stringpaces = 2 * $n - 2;


    for ($i = 0; $i < $n; $i++) {

        for ($j = 0; $j < $stringpaces; $j++)
            echo " ";

        $stringpaces = $stringpaces - 1;

        for ($j = 0; $j <= $i; $j++) {

            // printing stars
            echo "* ";
        }

        echo "\n";
    }
}

$n = 5;
piramid($n);