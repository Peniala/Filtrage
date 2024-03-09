<?php
    // $str = "ssh,telnet,pop3";
    // $service = split($str,',');
    // print_r($service);

    $file = popen("ifconfig","r");
    $interf = [];
    if(!$file){
        echo "Erreur de commande ifconfig";
    }
    while(!feof($file)){
        $line = fgets($file);
        $i = "";
        sscanf($line,"%[^: ]: %*[^\n]\n",$i);
        
        if($i != "" && $i != "\n"){
            $interf[] = $i;
        }
    }
    fclose($file);

?>