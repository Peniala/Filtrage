<?php

    include "function.php";

    $policy = getPolicy();
    $rules = getRulesByChain();

    if($_GET["action"] == "del" && empty($_GET["choice"])){
        $mess = "Delete this rules : "."<br>".$rules[$_GET['chain']][$_GET['rule']]['acces']." ".$rules[$_GET['chain']][$_GET['rule']]['prot']." ".$rules[$_GET['chain']][$_GET['rule']]['opt']." ".$rules[$_GET['chain']][$_GET['rule']]['src']." ".$rules[$_GET['chain']][$_GET['rule']]['dest']." ".$rules[$_GET['chain']][$_GET['rule']]['oth'];
        $_SESSION['chain'] = $_GET['chain'];
        $_SESSION['index'] = $_GET['rule'];

        setAlert("status.php?action=del&","show",$mess);
    }
    else if($_GET["action"] == "del" && !empty($_GET["choice"])){
        if($_GET["choice"] == "yes"){
            delRule($_SESSION['chain'],$_SESSION['index']);
            session_destroy();
        }
        else{
            setAlert("status.php?action=reset&","hide","");
        }
    }
    if($_GET["action"] == "reset" && empty($_GET["choice"])){
        setAlert("status.php?action=reset&","show","Reset all rules");
    }
    else if($_GET["action"] == "reset" && !empty($_GET["choice"])){
        if($_GET["choice"] == "yes"){
            resetRules($rules);
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
        setAlert("status.php?action=save&","hide","");
    
    }
    if($_GET["action"] == "restore" && empty($_GET["choice"])){
        setAlert("status.php?action=restore&","show","Restore last rules saved");
    }
    else if($_GET["action"] == "restore" && !empty($_GET["choice"])){
        if($_GET["choice"] == "yes"){
            restore();
        }
        setAlert("status.php?action=restore&","hide","");
    }
    $rules = getRulesByChain();
?>