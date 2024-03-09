<?php

    include "function.php";

    $policy = getPolicy();
    $rules = getRulesByChain();

    if($_GET["action"] == "reset" && empty($_GET["choice"])){
        setAlert("status.php?action=reset&","show","Reset all rules");
    }
    else if($_GET["action"] == "reset" && !empty($_GET["choice"])){
        if($_GET["choice"] == "yes"){
            resetRules();
        }
        else{
            setAlert("status.php?action=reset&","hide","");
        }
    }
    if($_GET["action"] == "save" && empty($_GET["choice"])){
        setAlert("status.php?action=save&","show","Save rules");
    }
    else if($_GET["action"] == "save" && !empty($_GET["choice"])){
        if($_GET["choice"] == "yes"){
            save();
        }
        else{
            setAlert("status.php?action=save&","hide","");
        }
    }if($_GET["action"] == "restore" && empty($_GET["choice"])){
        setAlert("status.php?action=restore&","show","Restore last rules saved");
    }
    else if($_GET["action"] == "restore" && !empty($_GET["choice"])){
        if($_GET["choice"] == "yes"){
            restore();
        }
        else{
            setAlert("status.php?action=restore&","hide","");
        }
    }
    if($_GET["action"] == "del" && empty($_GET["choice"])){
        $mess = "Delete this rules : "."<br>".$rules[$_GET['chain']].[$_GET['rule']-1].['acces']." ".[$_GET['rule']-1].['prot']." ".[$_GET['rule']-1].['opt']." ".[$_GET['rule']-1].['src']." ".[$_GET['rule']-1].['dest']." ".[$_GET['rule']-1].['oth'];
        setAlert("status.php?action=del&","show",$mess);
    }
    else if($_GET["action"] == "del" && !empty($_GET["choice"])){
        if($_GET["choice"] == "yes"){
            delRule($_GET['chain'],$_GET['rule']);
        }
        else{
            setAlert("status.php?action=reset&","hide","");
        }
    }
?>