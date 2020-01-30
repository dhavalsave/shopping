<?php
function palindrome($stringtring){
    if (strrev($stringtring) == $stringtring){
        return 1;
    }
    else{
        return 0;
    }
}

$stringtring = "rotator";
echo palindrome($stringtring);