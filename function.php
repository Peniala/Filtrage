<?php

function save(){
	system("sudo iptables-save > rules.txt");
}
function restore(){
	system("sudo iptables-restore < rules.txt");
}

function replace($chain,$target,$interf,$protocol,$src,$dest){
	$cmd = translateRulesToCmd($chain,$target,$interf,$protocol,$src,$dest);
	$newRules = "";
	$j = strlen($chain);
	for($i = strpos($cmd,$chain) + $j; $i < strlen($cmd); $i++){
		$newRules = $newRules.$cmd[$i];
	}
	$cmd = "sudo iptables -D ".$chain." ".$nbrule." ".$newRules;
}
// function modifyRules($modchain,$nrule,$chain,$target,$interf,$protocol,$src,$dest){
// 	$rules = getRulesByChain();
// 	foreach($rules as $index => $tab){
// 		if($index == 'input' || $index == 'output') $i = 6;
// 		else $i = 2;
// 		for(; $i < count($rules[$index]); $i++){
// 			if($index == $modchain && $i == $nrule){

// 			}
// 			else{
// 				translateRulesToCmd($rules[$index][$i],$index);
// 			}
// 		}
// 	}
// }
// function translateRulesToCmd($rule,$chain){
// 	$cmd = "sudo iptables";
// 	if($chain == 'input') $chain = "INPUT";
// 	else if($chain == 'forward') $chain = "FORWARD";
// 	else $chain = "OUTPUT";
// 	$cmd .= "-A ".$chain;
// 	$cmd .= " -j ".$rules['acces'];
// 	if($rules['prot'] != "all"){
// 		$cmd .= " -p ".$rules['prot'];
// 	}
// 	if($rules['src'] != "anywhere"){
// 		$cmd .= " -s ".$rules['src'];
// 	}
// 	if($rules['dest'] != "anywhere"){
// 		$cmd .= " -d ".$rules['dest'];
// 	}
// 	if($rules['oth'] != ""){

// 	}
// }
function translateRulesToCmd($chain,$target,$interf,$protocol,$src,$dest){
	$cmd = "sudo iptables ";
	$cmd = $cmd."-A ".$chain;
	$cmd = $cmd." -j ".$target;
	$cmd1 = "";

	if($interf != "none"){
		if($chain == "INPUT"){
			$cmd = $cmd." -i ".$interf;
		}
		if($chain == "OUTPUT"){
			$cmd = $cmd." -o ".$interf;
		}
	}
	if($protocol[0] != "none"){
		$cmd = $cmd." -p ".$protocol[0];
		if($protocol[1] != "none"){
			if(strpos($protocol[1],",")){
				$cmd1 = $cmd." -m multiport --dport ".$protocol[1];
				$cmd = $cmd." -m multiport --sport ".$protocol[1];
			}
			else if($protocol[1] != ""){
				$cmd1 = $cmd." --dport ".$protocol[1];
				$cmd = $cmd." --sport ".$protocol[1];
			}
		}
	}
	if($src[0] == "on"){
		if(!empty($src[2])){
			if($src[1] == "on"){
				$cmd = $cmd." -m mac --mac-source ".$src[2];
				if($protocol[1] != "none"){
					$cmd1 = $cmd1." -m mac --mac-source ".$src[2];
				}
			}
			else{
				$cmd = $cmd." -s ".$src[2];
				if($protocol[1] != "none"){
					$cmd1 = $cmd1." -s ".$src[2];
				}
			}
		}
	}
	if($dest[0] == "on"){
		if($dest[1] == "on"){
			$cmd = $cmd." -m mac --mac-source ".$dest[2];
			if($protocol[1] != "none"){
				$cmd1 = $cmd1." -m mac --mac-source ".$dest[2];
			}
		}
		else{
			$cmd = $cmd." -s ".$dest[2];
			if($protocol[1] != "none"){
				$cmd1 = $cmd1." -s ".$dest[2];
			}
		}
	}
	if($protocol[1] != "none"){
		if($chain == "INPUT"){
			return $cmd." ; ".$cmd1;
		}
		else{
			return $cmd1." ; ".$cmd;
		}
	}
	else{
		system($cmd);
		return $cmd;
	}
}
function addRules($chain,$target,$interf,$protocol,$src,$dest){
	$cmd = translateRulesToCmd($chain,$target,$interf,$protocol,$src,$dest);
	sydtem($cmd);
}
function getInterface(){
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
	return $interf;
}
function delRule($chain,$index){
	$numbline = $index - 1;

	if($chain == "input") $chain = "INPUT";
	if($chain == "forward") $chain = "FORWARD";
	if($chain == "output") $chain = "OUTPUT";

	$cmd = "sudo iptables -D ".$chain." ".$numbline;
	system($cmd);
}
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
function resetRules($rules){
	foreach($rules as $index => $tab){
		if($index == 'input'){
			for($i=6; $i < count($tab)- 4; $i++){
				system("sudo iptables -D INPUT 5");
			}
		}
		if($index == 'output'){
			for($i=6; $i < count($tab)- 4; $i++){
				system("sudo iptables -D OUTPUT 5");
			}
		}
		if($index == 'forward'){
			for($i=2; $i < count($tab); $i++){
				system("sudo iptables -D FORWARD 1");
			}
		}
	}
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