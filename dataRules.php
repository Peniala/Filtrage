<?php

include "function.php";

if(!empty($_GET["nbport"])) $nbport = $_GET["nbport"];
else $nbport = 1;

$protls = getListProtocol();

?>