<?php

    include "function.php";

    verifyUserConnection();

    $protls = getListProtocol();

    verifyAdd();

    if(isset($_GET["action"]) && $_GET["action"] == "mod"){
        $tilte = "Modify";
    }
    else{
        $tilte = "Add";
    }
    
?>