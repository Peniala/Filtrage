<?php

    include "function.php";

    verifyUserConnection();

    $policy = verifyPolicy();

    $pInput = $policy[0];
    $pForward = $policy[1];
    $pOutput = $policy[2];

?>