<?php

    include "function.php";

    verifyUserConnection();

    $policy = getPolicy();

    verifyModify();
    verifyDelete();
    verifyReset();
    verifySave();
    verifyRestore();
    
    $rules = getRulesByChain();
?>