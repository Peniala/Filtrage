<?php

    include "function.php";

    verifyUserConnection();

    $protls = getListProtocol();

    verifyAdd();

    if(isset($_GET["action"]) && $_GET["action"] == "mod"){
        $title = "Modify";
    }
    else{
        $title = "Add";
    }
    
?>