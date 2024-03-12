<?php

    include "function.php";

    verifyUserConnection();

    $policy = verifyPolicy($_GET["choice"],$_GET["pInput"],$_GET["pForward"],$_GET["pOutput"]);

    $pInput = $policy[0];
    $pForward = $policy[1];
    $pOutput = $policy[2];

?>