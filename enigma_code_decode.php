<?php

define('ALPHABET','abcdefghijklmnopqrstuvwxyz');
function reflector($char){
    return ALPHABET[-(strpos(ALPHABET,$char)+1)];
}
function rotate_rotors(){
    global $r1,$r2,$r3,$state;
    $r1 = substr($r1,1) . substr($r1,0,1);
    if (($state % 26) == 0){
        $r2 = substr($r2,1) . substr($r2,0,1);
    }
    if ($state % (26*26) == 0){
        $r3 = substr($r3,1) . substr($r3,0,1);
    }
}
function do_one_char($char){
    global $r1,$r2,$r3;
    $rotor_1_char = $r1[strpos(ALPHABET,$char)];
    $rotor_2_char = $r2[strpos(ALPHABET,$rotor_1_char)];
    $rotor_3_char = $r3[strpos(ALPHABET,$rotor_2_char)];
    $reflected = reflector($rotor_3_char);
    $rotor_3_char = ALPHABET[strpos($r3,$reflected)];
    $rotor_2_char = ALPHABET[strpos($r2,$rotor_3_char)];
    $rotor_1_char = ALPHABET[strpos($r1,$rotor_2_char)];
    return $rotor_1_char;
}

$filename = __DIR__.'/rotors.enigma';
$file = fopen($filename,'rb');
$rotors = unserialize(fread($file,filesize($filename)));
['r1'=>$r1,'r2'=>$r2,'r3'=>$r3] = $rotors;

$r1 = implode($r1);
$r2 = implode($r3);
$r3 = implode($r3);

array_shift($argv);
$plain = $argv[0];
$coded = '';
$state = 0;



$arr_plain = str_split($plain);
foreach ($arr_plain as $char){
    $state++;
    if ($char === ' '){
        $coded .= $char;
        continue;
    }
    $coded .= do_one_char($char);
    rotate_rotors();
}

echo $coded;