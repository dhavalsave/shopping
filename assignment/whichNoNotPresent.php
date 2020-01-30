<?php
function search_missing( $arr1, $arr2, $count1, $count2)
{
    $j=0;
    for ( $i = 0; $i < $count1; $i++)
    {

        for ($j = 0; $j < $count2; $j++)
            if ($arr1[$i] == $arr2[$j])
                break;

        if ($j == $count2)
            echo $arr1[$i] , " ";
    }
}

$arr1 = array( 1,2,3,4,5 );
$arr2 = array(2,3,1,0,5 );
$count1 = count($arr1);
$count2 = count($arr2);
search_missing($arr1, $arr2, $count1, $count2);

