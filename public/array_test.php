<?php

$a = [1,2,3];
$b = [1,2,4,5,2,3];

if (count($a) < count($b)){
    for ($i = 0; $i < count($b); $i++){
        if ($i > count($a)-1){
            array_push($a, "NULL");
        }
    }
}

var_dump($a);