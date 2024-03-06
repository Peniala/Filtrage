<?php

include "function.php";

error_reporting(-1);
ini_set("display_errors",1);


$policy = getPolicy();
$cmd = "sudo iptables -P ";
$url = "policy.php?";

if(!empty($_GET["pInput"])){
    $pInput = $_GET["pInput"];
}
else{
    $pInput = $policy[0];
}
if(!empty($_GET["pForward"])){
    $pForward = $_GET["pForward"];
}
else{
    $pForward = $policy[1];
}
if(!empty($_GET["pOutput"])){
    $pOutput = $_GET["pOutput"];
}
else{
    $pOutput = $policy[2];
}

if(empty($_GET["choice"]) && (!empty($_GET["pInput"]) || !empty($_GET["pForward"]) || !empty($_GET["pOutput"]))){
    $i = 0;
    if(!empty($_GET["pInput"])){
        $pInput = $_GET["pInput"];
        $url = $url."pInput=".$pInput;
        $i++;
    }
    else{
        $pOutput = $policy[0];
    }
    if(!empty($_GET["pForward"])){
        $pForward = $_GET["pForward"];
        if($i == 0){ 
            $url = $url."pForward=".$pForward; 
            $i++;
        }
        else $url = $url."&pForward=".$pForward;
    }
    else{
        $pOutput = $policy[1];
    }
    if(!empty($_GET["pOutput"])){
        $pForward = $_GET["pOutput"];
        if($i == 0){ 
            $url = $url."pOutput=".$pOutput; 
            $i++;
        }
        else $url = $url."&pOutput=".$pOutput;
    }
    else{
        $pOutput = $policy[2];
    }
    $url = $url."&";
    setAlert("Yes",$url,"block");
}
else if(!empty($_GET["choice"]) && $_GET["choice"] == "yes"){
    if(!empty($_GET["pInput"])){
        system($cmd."INPUT ".$pInput);
    }
    if(!empty($_GET["pForward"])){
        system($cmd."FORWARD ".$pForward);
    }
    if(!empty($_GET["pOutput"])){
        system($cmd."OUTPUT ".$pOutput);
    }
    setAlert("Yes",$url,"hide");
}
else{
    setAlert("No",$url,"hide");
}
?>