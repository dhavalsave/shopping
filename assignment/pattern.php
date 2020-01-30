<?php
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
    $print=$print.printSpace($i);
    $print=$print.printSpace($i);
    $print=$print.substr($str2,$i,$str_len);
    echo $print;
    echo("\n");



}
for($i=$str_len,$j=0;$i>0,$j<$str_len;$i-=2,$j+=2)
{
    $print=substr($str1,0,$j);
    $print=$print.printSpace($i);
    $print=$print.printSpace($i);
    $print=$print.substr($str2,$i,$str_len);
    echo $print;
    echo("\n");



}

