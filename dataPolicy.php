<?php
error_reporting(-1);
ini_set("display_errors",1);

$file = fopen("policy.txt","r");

if(!$file){
    echo "Echec d'ouverture";
}

while($line = fgets($file)){
    echo "OK ".$line;
}

fclose($file);

if(!empty($_GET["pInput"])){
    $pInput = $_GET["pInput"];
}
else{
    $pInput = "accept";
}
if(!empty($_GET["pForward"])){
    $pForward = $_GET["pForward"];
}
else{
    $pForward = "accept";
}
if(!empty($_GET["pOutput"])){
    $pOutput = $_GET["pOutput"];
}
else{
    $pOutput = "accept";
}

function verifyChecked($input, $policy){
    if($policy == $input) echo "checked";
}

?>