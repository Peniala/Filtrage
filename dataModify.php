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

    if($rules[$_GET["chain"]][$nbrule]['prot'] == "tcp"){
        $protocol = "tcp";
    }
    else if($rules[$_GET["chain"]][$nbrule]['prot'] == "udp"){
        $protocol = "udp";
    }
    else if($rules[$_GET["chain"]][$nbrule]['prot'] == "ddp"){
        $protocol = "ddp";
    }
    else if($rules[$_GET["chain"]][$nbrule]['prot'] == "icmp"){
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

    if(strpos($rules[$_GET["chain"]][$nbrule]['oth'],"MAC") && (strpos($rules[$_GET["chain"]][$nbrule]['oth'],"sports") || strpos($rules[$_GET["chain"]][$nbrule]['oth'],"spt")) && $scr == ""){
        $smac = "checked";
    }
    else{
        $smac = "";
    }

    if(strpos($rules[$_GET["chain"]][$nbrule]['oth'],"MAC") && (strpos($rules[$_GET["chain"]][$nbrule]['oth'],"dports") || strpos($rules[$_GET["chain"]][$nbrule]['oth'],"dpt")) && $dest == ""){
        $dmac = "checked";
    }
    else{
        $dmac = "";
    }
?>