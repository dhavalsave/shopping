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

/////////////////////////////////////////////////////////////////////////////////
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

//$arr1 = array( 1,2,3,4,5 );
//$arr2 = array(2,3,1,0,5 );
//$count1 = count($arr1);
//$count2 = count($arr2);
//search_missing($arr1, $arr2, $count1, $count2);
///////////////////////////////////////////////////////////////////////////////
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

//$n = 5;
//piramid($n);

/////palindrom string
///
//////////////////////////////////////////////////////////////////////////////////////
function palindrome($stringtring){
    if (strrev($stringtring) == $stringtring){
        return 1;
    }
    else{
        return 0;
    }
}
//
//$stringtring = "rotator";
//echo palindrome($stringtring);

////////////////////////////////////////////////////////////////////////////////////////////////


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

//
//$string = "1C1B1B0A0";
//echo stringFormation($string);

//$fp1 = fopen("t1.txt", 'a+');
//$file2 = file_get_contents("t2.txt");
//fwrite($fp1, $file2);

/////////////////////////////////////////////////////////////




$string="1A2B3C4D5EE5D4C3B2A1";
$str_len=strlen($string);
$str1=substr($string,0,$str_len/2);
$str2=strrev($str1);
$str_len=strlen($str1);
function printSpace($n)
{
    $s="";
    while ($n>0)
    {
        $s=$s." ";
        $n--;
    }
    return$s;
}
$space="";
$print="";
for($j=$str_len,$i=0;$j>0,$i<$str_len;$j-=2,$i+=2)
{
    $print=substr($str1,0,$j);
    $print=$print.printSpace($str_len-$j);
    $print=$print.printSpace($str_len-$i);
    $print=$print.substr($str2,$i,$str_len);
    echo $print;
    echo("\n");

//    echo substr($str1,0,$j);
//        echo(printSpace($str_len-$j));
//        echo(printSpace($str_len-$i));
//    echo substr($str2,$i,$str_len);
//    echo("\n");

}


