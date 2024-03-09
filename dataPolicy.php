<?php

include "function.php";

error_reporting(-1);
ini_set("display_errors",1);


$policy = getPolicy();
$cmd = "sudo iptables -P ";
$modif = "";
$url = "policy.php?";

$pInput = $policy[0];
$pForward = $policy[1];
$pOutput = $policy[2];

if(!isset($_GET["choice"]) && (isset($_GET["pInput"]) || isset($_GET["pForward"]) || isset($_GET["pOutput"]))){
    $i = 0;
    $change = 0;

    if(isset($_GET["pInput"])){
        if($pInput != $_GET["pInput"]){
            $modif = "<div>Change INPUT policy ".$pInput." into ".$_GET["pInput"]."</div>";
            $change = 1;
        }
        $url = $url."pInput=".$_GET["pInput"];
        $i++;
    }
    if(isset($_GET["pForward"])){
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
    if(isset($_GET["pOutput"])){
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
else if(isset($_GET["choice"]) && $_GET["choice"] == "yes"){
    if(isset($_GET["pInput"])){
        $pInput = $_GET["pInput"];
        system($cmd."INPUT ".$pInput);
    }
    if(isset($_GET["pForward"])){
        $pForward = $_GET["pForward"];
        system($cmd."FORWARD ".$pForward);
    }
    if(isset($_GET["pOutput"])){
        $pOutput = $_GET["pOutput"];
        system($cmd."OUTPUT ".$pOutput);
    }
    setAlert($url,"hide","Yes");
}
else{
    setAlert($url,"hide","No");
}
?>