<?php

// function addRules(){
// 	$cmd = "sudo iptables ";
// 	if($chain == "input"){
// 		$cmd = $cmd."-A INPUT ";
// 	}
// 	elseif($chain == "forward"){
// 		$cmd = $cmd."-A FORWARD ";
// 	}
// 	else{
// 		$cmd = $cmd."-A OUTPUT ";
// 	}
// 	if($acces == "accept"){
// 		$cmd = $cmd."-j ACCEPT ";
// 	}
// 	else{
// 		$cmd = $cmd."-j DROP ";
// 	}
// 	if($protocol != ""){
// 		$cmd = $cmd."-p ".$protocol;
// 		if($protocol != "icmp" && $prot != ""){

// 		}
// 	}
// 	system($cmd);
// }
// function delRule($rules,$chain,$index){
// 	$s = getListProtocol();
// 	$cmd = "sudo iptables -D ".$chain;
// 	$mcmd = "";

// 	if($rules[$chain][$index]['prot'] != "all"){
// 		$cmd = $cmd." -p ".$rules[$chain][$index]['prot'];
// 	}
// 	if($rules[$chain][$index]['src'] != "anywhere"){
// 		$cmd = $cmd." -s ".$rules[$chain][$index]['src'];
// 	}
// 	if($rules[$chain][$index]['dest'] != "anywhere"){
// 		$cmd = $cmd." -d ".$rules[$chain][$index]['dest'];
// 	}
// 	if($rules[$chain][$index]['oth'] != ""){
// 		if(strpos($rules[$chain][$index]['oth'],"MAC")){
// 			sscanf($rules[$chain][$index]['oth'],"%*[^MAC]MAC%[^ ] ",$mac);
// 			$mcmd = "-m mac --mac-source ".$mac;
// 		}
// 		if(strpos($rules[$chain][$index]['oth'],"multiport")){
// 			sscanf($rules[$chain][$index]['oth'],"%*[^multiport dports ]multiport dports %s ",$services);
// 			$list = str_split($services,",");

// 			for($i=0; $i < count($service); $i++){
// 				$prt = $s[$rules[$chain][$index]['prot']][$service];
// 			}
// 		}
// 		else if(strpos($rules[$chain][$index]['oth'],"dport")){

// 		}
// 	}
// }
function split($str,$f){
	$array = [""];
	$i = 0;
	for($j=0; $j < strlen($str); $j++){
		if($str[$j] != $f){
			$array[$i] .= $str[$j];
		}
		else{
			$i++;
			$array[$i] = "";
		}
	}
	return $array;
}
function resetRules(){
	system("sudo iptables -F");
}
function getListProtocol(){
    $list = [[]];
	$service = "";
	$port = 0;

	$file = popen("cat /etc/services","r");
	
	if(!$file){
		echo 'Erreur ouverture';
	}

	while(!feof($file)){
		$line = fgets($file);
		if(strpos($line,"/tcp")){
			sscanf($line,"%[^\t]\t%d/tcp",$service,$port);
			$list['tcp'][$service] = $port;
		}
		else if(strpos($line,"/udp")){
			sscanf($line,"%[^\t]\t%d/udp",$service,$port);
			$list['udp'][$service] = $port;
		}
		else if(strpos($line,"/ddp")){
			sscanf($line,"%[^\t]\t%d/ddp",$service,$port);
			$list['ddp'][$service] = $port;
		}
	}

	fclose($file);
    return $list;
}
function getRulesByChain(){
	$line = getRules();
	foreach($line as $index => $tab){
		$k = 0;
		foreach($tab as $value){
			if($value == "\t") continue;
			sscanf($value,"%s %s %s %s %s %[^\n]",$rules[$index][$k]['acces'],$rules[$index][$k]['prot'],$rules[$index][$k]['opt'],$rules[$index][$k]['src'],$rules[$index][$k]['dest'],$rules[$index][$k]['oth']);
			$k++;
		}
	}
	return $rules;
}
function getRules(){
    $file = popen("sudo iptables -L","r");
	
	if(!$file){
		echo 'Erreur ouverture';
	}
	$i = 1;
	$index = "";

	while(!feof($file)){
		$line = fgets($file);
		if(strpos($line,"INPUT")){
			$index = "input";
		}
		else if(strpos($line,"FORWARD")){
			$index = "forward";
		}
		else if(strpos($line,"OUTPUT")){
			$index = "output";
		}
		$rules[$index][] = $line;
	}
    fclose($file);

    return $rules;
}
function setAlert($link,$hide,$modif){
    echo "
    <div class=\"alert $hide\">
        <div>Are you sure to :
            <div>$modif</div>
            <div class = \"choice\">
                <a href=\"".$link."choice=yes\"><button type=\"submit\">Yes</button></a>
                <a href=\"".$link."choice=no\"><button type=\"submit\">No</button></a>
            </div>
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