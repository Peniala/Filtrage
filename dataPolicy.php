<?php

include "function.php";

error_reporting(-1);
ini_set("display_errors",1);

$policy = getPolicy();
$cmd = "sudo iptables -P ";


if(!empty($_GET["pInput"])){
    $pInput = $_GET["pInput"];
    system($cmd."INPUT ".$pInput);
}
else{
    $pInput = $policy[0];
}
if(!empty($_GET["pForward"])){
    $pForward = $_GET["pForward"];
    system($cmd."FORWARD ".$pForward);
}
else{
    $pForward = $policy[1];
}
if(!empty($_GET["pOutput"])){
    $pOutput = $_GET["pOutput"];
    system($cmd."OUTPUT ".$pOutput);
}
else{
    $pOutput = $policy[2];
}

?>