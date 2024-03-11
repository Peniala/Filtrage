<?php

    include "function.php";

    verifyUserConnection();

    $policy = getPolicy();

    verifyDelete();
    verifyReset();
    verifySave();
    verifyRestore();
    
    $rules = getRulesByChain();
?>