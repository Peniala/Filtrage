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
            setAlert("status.php?action=reset&","hide","Reset all rules");
        }
    }

?>