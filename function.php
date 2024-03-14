<?php
session_start();

////////////////////////////////////////////////////////////////// Fonction Log ////////////////////////////////////////////////////////////////////

function logout(){
	session_destroy();
	header("Location:login.php");
}

function verifyUserConnection(){
	if(isset($_GET['logout'])){
		logout();
	}
	if(isset($_POST['name']) && isset($_POST['passwd'])){
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['passwd'] = $_POST['passwd'];
	}
	if(isset($_SESSION['name']) && isset($_SESSION['passwd'])){
		if($_SESSION['name'] != "mit" || $_SESSION['passwd'] != "123456"){
			session_destroy();
			header("Location:login.php");
		}
	}
	else{
		header("Location:login.php");
	}
}

///////////////////////////////////////////////////////////////////// Fonction dans Status ///////////////////////////////////////////////////////////

//// Fonction de verification requete pour modification

function verifyModify(){
	if($_GET["action"] == "mod" && !isset($_GET["choice"])){
		$mess = makeSession();
		$_SESSION["nbrule"] = $_GET["rule"];
		setAlert("status.php?action=mod&","show","Modify "."qqlchose to ".$mess);
	}
	else if($_GET["action"] == "mod" && isset($_GET["choice"])){
		if($_GET["choice"] == "yes"){
			replace($_SESSION["nbrule"],$_SESSION["chain"],$_SESSION["target"],$_SESSION["interf"],unserialize($_SESSION["protocol"]),unserialize($_SESSION["src"]),unserialize($_SESSION["dest"]));
		}
		resetSession();
		$_SESSION["nbrule"] = NULL;
		setAlert("status.php?action=mod&","hide","");
	}
}

//// Fonction d'affichage

function displayRules($chain){
	$rules = getRulesByChain();
	// if($chain == 'input' || $chain == 'output') $j = 6;
	// else $j = 2;

	echo "
		<div class=\"title\">Target</div>
		<div class=\"title\">Protocol</div>
		<div class=\"title\">Options</div>
		<div class=\"title\">Source</div>
		<div class=\"title\">Destination</div>
		<div class=\"title\">Other</div>
		<div class=\"title\">Action</div>
		";

	for($j = 2; $j < count($rules[$chain])-1; $j++){
		foreach($rules[$chain][$j] as $value){
			echo "<div> $value </div>";
		}
		if($j > 5){
			echo "
				<div class=\"action\">
					<a href=\"rules.php?action=mod&chain=$chain&rule=$j\"><button type=\"button\">Mod</button></a>
					<a href=\"status.php?action=del&chain=$chain&rule=$j\"><button type=\"button\">Del</button></a>
				</div>
				";
		}
		else{
			echo "
				<div class=\"action\">
					<a><button type=\"button\" class=\"disable\" >Mod</button></a>
					<a><button type=\"button\" class=\"disable\">Del</button></a>
				</div>
				";
		}
	}
}

// Fonction de modification de règles 

function replace($nbrule,$chain,$target,$interf,$protocol,$src,$dest){
	$cmd = translateRulesToCmd($chain,$target,$interf,$protocol,$src,$dest);
	$newRules = "";
	$j = strlen($chain);
	for($i = strpos($cmd,$chain) + $j; $i < strlen($cmd); $i++){
		$newRules = $newRules.$cmd[$i];
	}
	$cmd = "sudo iptables -R ".$chain." ".($nbrule-1)." ".$newRules;
	system($cmd);
	return $cmd;
}

// Fonction de verification requete pour enregistrement

function verifySave(){
	if($_GET["action"] == "save" && !isset($_GET["choice"])){
		setAlert("status.php?action=save&","show","Save rules");
	}
	else if($_GET["action"] == "save" && isset($_GET["choice"])){
		if($_GET["choice"] == "yes"){
			save();
		}
		setAlert("status.php?action=save&","hide","");
	}
}

// Fonction pour enregistrer les règles établies

function save(){
	system("sudo iptables-save > rules.txt");
}

// Fonction de verification requete pour la restoration de règles

function verifyRestore(){
	if($_GET["action"] == "restore" && empty($_GET["choice"])){
		setAlert("status.php?action=restore&","show","Restore last rules saved");
	}
	else if($_GET["action"] == "restore" && !empty($_GET["choice"])){
		if($_GET["choice"] == "yes"){
			restore();
		}
		setAlert("status.php?action=restore&","hide","");
	}
}

// Fonction pour restorer les règles enregistrés précedement

function restore(){
	system("sudo iptables-restore < rules.txt");
}

// Fonction pour verifier les requetes sur la suppression

function verifyDelete(){
    $rules = getRulesByChain();

	if($_GET["action"] == "del" && empty($_GET["choice"])){
		$mess = "Delete this rules : "."<br>".$rules[$_GET['chain']][$_GET['rule']]['acces']." ".$rules[$_GET['chain']][$_GET['rule']]['prot']." ".$rules[$_GET['chain']][$_GET['rule']]['opt']." ".$rules[$_GET['chain']][$_GET['rule']]['src']." ".$rules[$_GET['chain']][$_GET['rule']]['dest']." ".$rules[$_GET['chain']][$_GET['rule']]['oth'];
		$_SESSION['chain'] = $_GET['chain'];
		$_SESSION['index'] = $_GET['rule'];

		setAlert("status.php?action=del&","show",$mess);
	}
	else if($_GET["action"] == "del" && !empty($_GET["choice"])){
		if($_GET["choice"] == "yes"){
			delRule($_SESSION['chain'],$_SESSION['index']);
			$_SESSION['chain'] = NULL;
			$_SESSION['index'] = NULL;
		}
		else{
			setAlert("status.php?action=reset&","hide","");
		}
	}
}

// Fonction de suppression de règles

function delRule($chain,$index){
	$numbline = $index - 1;

	if($chain == "input") $chain = "INPUT";
	if($chain == "forward") $chain = "FORWARD";
	if($chain == "output") $chain = "OUTPUT";

	$cmd = "sudo iptables -D ".$chain." ".$numbline;
	system($cmd);
}

// Fonction verification requete sur reinitialisation

function verifyReset(){
    $rules = getRulesByChain();

	if($_GET["action"] == "reset" && empty($_GET["choice"])){
		setAlert("status.php?action=reset&","show","Reset all rules");
	}
	else if($_GET["action"] == "reset" && !empty($_GET["choice"])){
		if($_GET["choice"] == "yes"){
			resetRules($rules);
		}
		else{
			setAlert("status.php?action=reset&","hide","");
		}
	}
}

// Fonction d'initialisation des règles 

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
///////////////////////////////////////////////////////////////////// Fonction sur la page Rules /////////////////////////////////////////////////////

// Fonction de verification requete ajout

function verifyAdd(){
	if(isset($_GET["action"]) && $_GET["action"] != "mod"){
		if(isset($_GET["choice"])){
			if($_GET["choice"] == "yes"){
				addRules($_SESSION["chain"],$_SESSION["target"],$_SESSION["interf"],unserialize($_SESSION["protocol"]),unserialize($_SESSION["src"]),unserialize($_SESSION["dest"]));
			}
			resetSession();
			setAlert("rules.php?","hide","");
		}
		else{
			$mess = makeSession();
			setAlert("rules.php?action=add&","block","Add ".$mess);
		}
	}
}

// Fonction de réinitialisation variable SESSION

function resetSession(){
	$_SESSION["chain"] = NULL;
	$_SESSION["target"] = NULL;
	$_SESSION["interf"] = NULL;
	$_SESSION["protocol"] = NULL;
	$_SESSION["src"] = NULL;
	$_SESSION["dest"] = NULL;
}

// Fonction d'ajout de règles

function addRules($chain,$target,$interf,$protocol,$src,$dest){
	$cmd = translateRulesToCmd($chain,$target,$interf,$protocol,$src,$dest);
	if(strpos($cmd,"--sport")){
		system($cmd);
		$cmd[strpos($cmd,"--sport")+2] = 'd';
		system($cmd);
	}
	else if(strpos($cmd,"--dport")){
		system($cmd);
		$cmd[strpos($cmd,"--dport")+2] = 's';
		system($cmd);
	}
	else{
		system($cmd);
	}
}

// Fonction d'ajout de session pour l'ajout de règles

function makeSession(){
	$mess = "";
	if(isset($_GET["chain"])){
		$_SESSION["chain"] = $_GET["chain"];
		$mess .= " a chain ".$_GET["chain"];
	}
	if(isset($_GET["target"])){
		$_SESSION["target"] = $_GET["target"];
		$mess .= " with ".$_GET["target"]." acces";
	}
	if(isset($_GET["inter"]) && !empty($_GET["inter"])){
		$_SESSION["interf"] = $_GET["inter"];
		$mess .= " on ".$_GET["inter"]." interface";
	}
	else{
		$_SESSION["interf"] = "none";  
	}
	if(isset($_GET["protocol"])){
		$prt = [];				// pour l'ensemble
		$i = 1;
		$port = "port".$i;		// liste de ports
		$ports = [];
		$p = "";
		$prot = $_GET["protocol"];
		$mess .= " with the ".$_GET["protocol"]." protocol";
		$prt[0] =  $prot;
		if(isset($_GET[$port])){
			while(isset($_GET[$port])){
				$ports[] = $_GET[$port];
				$i++;
				$port = "port".$i;
			}
			for($j=0; $j < count($ports)-1; $j++){
				$p .= $ports[$j].',';
			}
			$p .= $ports[count($ports)-1];
			$prt[1] = $p;
			$mess .= ": ".$p." port";
		}
		else{
			$prt[1] = "none";
		}
		$_SESSION["protocol"] = serialize($prt);
	}
	else{
		$_SESSION["protocol"] = serialize(["none"]);
	}
	if(isset($_GET["src"]) && $_GET["src"] == "on"){    
		$s = [];
		$s[0] = $_GET["src"];
		if(isset($_GET["sMac"])){
			$s[1] = "on";
		}
		else{
			$s[1] = "off";
		}
		$s[2] = $_GET["smachine"];
		$mess .= " from ".$_GET["smachine"];
		$_SESSION["src"] = serialize($s);
	}
	else{
		$_SESSION["src"] = serialize(["none"]);
	}
	if(isset($_GET["dest"]) && $_GET["dest"] == "on"){
		$d = [];
		$d[0] = $_GET["dest"];
		if(isset($_GET["dMac"])){
			$d[1] = "on";
		}
		else{
			$d[1] = "off";
		}
		$d[2] = $_GET["dmachine"];
		$mess .= " to ".$_GET["dmachine"];
		$_SESSION["dest"] = serialize($d);
	}
	else{
		$_SESSION["dest"] = serialize(["none"]);
	}
	return $mess;
}

// Fonction pour lire les lines des règles déja ajoutés
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

/// Fonction pour classer les éléments de chaque ligne de règlements
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

/// Fonction pour prendre les différents protocols et les ports associés

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

// Fonction pour récuperer la liste des intefaces réseaux

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

////////////////////////////////////////////////////////////////////// Fonction policy /////////////////////////////////////////////////////////////////

// Fonction de verification requete sur les policies

function verifyPolicy($choice,$pIn,$pFor,$pOut){

	$url = "policy.php?";
	$modif = "";
	$cmd = "sudo iptables -P ";

	$policy = getPolicy();
	$pInput = $policy[0];
	$pForward = $policy[1];
	$pOutput = $policy[2];

	if(!isset($choice) && (isset($pIn) || isset($pFor) || isset($pOut))){
		$i = 0;
		$change = 0;

		if(isset($pIn)){
			if($pInput != $pIn){
				$modif = "<div>Change INPUT policy ".$pInput." into ".$pIn."</div>";
				$change = 1;
			}
			$url = $url."pInput=".$pIn;
			$i++;
		}
		if(isset($pFor)){
			if($pForward != $_GET["pForward"]){ 
				$modif = $modif."<div>Change FORWARD policy ".$pForward." into ".$pFor."</div>";
				$change = 1;
			}
			if($i == 0){ 
				$url = $url."pForward=".$pFor; 
				$i++;
			}
			else $url = $url."&pForward=".$pFor;
		}
		if(isset($pOut)){
			if($pOutput != $pOut){ 
				$modif = $modif."<div>Change OUTPUT policy ".$pOutput." into ".$pOut."</div>";
				$change = 1;
			}
			if($i == 0){ 
				$url = $url."pOutput=".$pOut; 
				$i++;
			}
			else $url = $url."&pOutput=".$pOut;
		}
		$url = $url."&";
		if($change == 1) setAlert($url,"block",$modif);
	}
	else if(isset($choice) && $choice == "yes"){
		if(isset($pIn)){
			$pInput = $pIn;
			system($cmd."INPUT ".$pInput);
		}
		if(isset($pFor)){
			$pForward = $pFor;
			system($cmd."FORWARD ".$pForward);
		}
		if(isset($pOut)){
			$pOutput = $pOut;
			system($cmd."OUTPUT ".$pOutput);
		}
		setAlert($url,"hide","Yes");
	}
	else{
		setAlert($url,"hide","No");
	}
	return [$pInput,$pForward,$pOutput];
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

function verifyChecked($input, $policy){
    if($policy == $input) echo "checked";
}

///////////////////////////////////////////////////////////// Fonction utilisée dans toutes les pages /////////////////////////////////////////////

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

// Alerte aux changements 

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

/// Traduire en commande une requete

function translateRulesToCmd($chain,$target,$interf,$protocol,$src,$dest){
	$cmd = "sudo iptables ";
	$cmd = $cmd."-A ".$chain;
	$cmd = $cmd." -j ".$target;

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
				if($chain == "INPUT"){					
					$cmd = $cmd." -m multiport --sport ".$protocol[1];
				}
				else{
					$cmd = $cmd." -m multiport --dport ".$protocol[1];
				}
			}
			else if($protocol[1] != ""){
				if($chain == "INPUT"){					
					$cmd = $cmd." --sport ".$protocol[1];
				}
				else{
					$cmd = $cmd." --dport ".$protocol[1];
				}
			}
		}
	}
	if($src[0] == "on"){
		if(!empty($src[2])){
			if($src[1] == "on"){
				$cmd = $cmd." -m mac --mac-source ".$src[2];
			}
			else{
				$cmd = $cmd." -s ".$src[2];
			}
		}
	}
	if($dest[0] == "on"){
		if(!empty($src[2])){
			if($dest[1] == "on"){
				$cmd = $cmd." -m mac --mac-source ".$dest[2];
			}
			else{
				$cmd = $cmd." -d ".$dest[2];
			}
		}
	}
	return $cmd;
}
?>