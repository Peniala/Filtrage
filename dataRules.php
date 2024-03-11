<?php
    
    session_start();

    include "function.php";

    if(!empty($_GET["nbport"])) $nbport = $_GET["nbport"];
    else $nbport = 1;

    $protls = getListProtocol();

    if(isset($_GET["action"]) && $_GET["action"] != "mod"){
        if(isset($_GET["choice"])){
            if($_GET["choice"] == "yes"){
                $mess = addRules($_SESSION["chain"],$_SESSION["target"],$_SESSION["interf"],unserialize($_SESSION["protocol"]),unserialize($_SESSION["src"]),unserialize($_SESSION["dest"]));
                session_destroy();
            }
            setAlert("rules.php?","block",$mess);
        }
        else{
            $mess = "Add a ";
            if(isset($_GET["chain"])){
                $_SESSION["chain"] = $_GET["chain"];
                $mess .= "chain ".$_GET["chain"];
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
                $prt = [];
                $i = 1;
                $port = "port".$i;
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
            setAlert("rules.php?action=add&","block",$mess);
        }
    }

?>