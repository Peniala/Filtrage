<?php

include "function.php";

error_reporting(-1);
ini_set("display_errors",1);


$policy = getPolicy();
$cmd = "sudo iptables -P ";
$modif = "";
$url = "policy.php?";

if(empty($_GET["choice"]) && (!empty($_GET["pInput"]) || !empty($_GET["pForward"]) || !empty($_GET["pOutput"]))){
    $i = 0;
    $change = 0;
    
    $pInput = $policy[0];
    $pForward = $policy[1];
    $pOutput = $policy[2];

    if(!empty($_GET["pInput"])){
        if($pInput != $_GET["pInput"]){
            $modif = "<div>Change INPUT policy ".$pInput." into ".$_GET["pInput"]."</div>";
            $change = 1;
        }
        $url = $url."pInput=".$_GET["pInput"];
        $i++;
    }
    if(!empty($_GET["pForward"])){
        if($pForward != $_GET["pForward"]){ 
            $modif = $modif."<div>Change FORWARD policy ".$pForward." into ".$_GET["pForward"]."</div>";
            $change = 1;
        }
        if($i == 0){ 
            $url = $url."pForward=".$_GET["pForward"]; 
            $i++;
        }
        else $url = $url."&pForward=".$_GET["pForward"];
    }
    if(!empty($_GET["pOutput"])){
        if($pOutput != $_GET["pOutput"]){ 
            $modif = $modif."<div>Change OUTPUT policy ".$pOutput." into ".$_GET["pOutput"]."</div>";
            $change = 1;
        }
        if($i == 0){ 
            $url = $url."pOutput=".$_GET["pOutput"]; 
            $i++;
        }
        else $url = $url."&pOutput=".$_GET["pOutput"];
    }
    $url = $url."&";
    if($change == 1) setAlert($url,"block",$modif);
}
else if(!empty($_GET["choice"]) && $_GET["choice"] == "yes"){
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
    setAlert($url,"hide","Yes");
}
else{
    $pInput = $policy[0];
    $pForward = $policy[1];
    $pOutput = $policy[2];
    setAlert($url,"hide","No");
}
?>