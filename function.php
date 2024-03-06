<?php

// function getRules(){
//     $list = 
// }
function setAlert($modif,$link,$hide){
    echo "
    <div class=\"alert $hide\">Are you sure to : $modif <br>
        <div class = \"choice\">
            <a href=\"".$link."choice=yes\"><button type=\"submit\">Yes : ".$link."choice=yes</button></a>
            <a href=\"".$link."choice=no\"><button type=\"submit\">No : ".$link."choice=no</button></a>
        </div>
    </div>";
}

function verifyChecked($input, $policy){
    if($policy == $input) echo "checked";
}

function getPolicy(){
    $policy = [];
    $i = 0;
    
    $file = popen("sudo iptables -L|grep policy","r");
    
    if(!$file){
        echo "Echec d'ouverture";
    }
    
    while(!feof($file)){
        $line = fgets($file);
        if($i == 0) sscanf($line,"Chain INPUT (policy %[^)])",$policy[]);
        else if($i == 1) sscanf($line,"Chain FORWARD (policy %[^)])",$policy[]);
        else sscanf($line,"Chain OUTPUT (policy %[^)])",$policy[]);
        $i++;
    }
    
    fclose($file);
    return $policy;    
}

?>