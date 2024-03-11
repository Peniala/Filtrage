<?php

    include "function.php";

    verifyUser();
    
    verifyPolicy();

    $policy = getPolicy();

    $pInput = $policy[0];
    $pForward = $policy[1];
    $pOutput = $policy[2];

?>