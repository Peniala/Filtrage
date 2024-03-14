<?php

    include "function.php";

    verifyUserConnection();

    $nbports = 1;

    $rules = getRulesByChain();
    $nbrule = $_GET["rule"];


    if($_GET["chain"] == "input"){
        $chain = "INPUT";
    }
    else if($_GET["chain"] == "forward"){
        $chain = "FORWARD";
    }
    else{
        $chain = "OUTPUT";
    }

    $target = $rules[$_GET["chain"]][$nbrule]['acces'];

    if(strpos($rules[$_GET["chain"]][$nbrule]['prot'],"tcp")){
        $protocol = "tcp";
    }
    else if(strpos($rules[$_GET["chain"]][$nbrule]['prot'],"tcp")){
        $protocol = "udp";
    }
    else if(strpos($rules[$_GET["chain"]][$nbrule]['prot'],"tcp")){
        $protocol = "ddp";
    }
    else if(strpos($rules[$_GET["chain"]][$nbrule]['prot'],"tcp")){
        $protocol = "icmp";
    }
    else{
        $protocol = "";
    }

    if($rules[$_GET["chain"]][$nbrule]['src'] != "anywhere"){
        $src = $rules[$_GET["chain"]][$nbrule]['src'];
    }
    else{
        $src = "";
    }

    if($rules[$_GET["chain"]][$nbrule]['dest'] != "anywhere"){
        $dest = $rules[$_GET["chain"]][$nbrule]['dest'];
    }
    else{
        $dest = "";
    }

    if(strpos($rules[$_GET["chain"]][$nbrule]['oth'],"MAC") && $scr == ""){
        $smac = "selected";
    }
    else{
        $smac = "";
    }

    if(strpos($rules[$_GET["chain"]][$nbrule]['oth'],"MAC") && $dest == ""){
        $dmac = "selected";
    }
    else{
        $dmac = "";
    }
?>