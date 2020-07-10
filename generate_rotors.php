<?php

define('ALPHABET','abcdefghijklmnopqrstuvwxyz');

$arr = str_split(ALPHABET);

shuffle($arr); 

// $arr = shuffle([1,2,3,4]);
$r1 = $arr;
$r2 = $arr;
$r3 = $arr;
shuffle($r1);
shuffle($r2);
shuffle($r3);
$rotors = compact('r1','r2','r3');
$filename = __DIR__.'/rotors.enigma';
$file = fopen($filename,'wb');
fwrite($file,serialize($rotors));
fclose($file);