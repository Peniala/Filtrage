<?php

    include "function.php";

    verifyUser();
    
    $policy = getPolicy();

    verifyDelete();
    verifyReset();
    verifySave();
    verifyRestore();
    
    $rules = getRulesByChain();
?>