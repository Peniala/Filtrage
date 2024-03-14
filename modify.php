<?php
    session_start();

    include "dataModify.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="rules.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.4.2-web/css/all.css">
    <title>Filter</title>
</head>
<body>
    <section>
        <fieldset class="center">
            <legend class="lparts">Modify rules</legend>
            <form action="status.php" method="get">
                <input type="text" name="action" value="add" hidden>
                <div class="block target-rules">
                    <select name="chain" class="hover-style" required>
                        <option value="<?php echo $chain;?>" selected><?php echo $chain;?></option>
                    </select>
                    <fieldset class="hover-style">
                        <legend>Target</legend>
                        <input type="radio" name="target" id="accept" value="ACCEPT" <?php if($target == "ACCEPT") echo "checked";?>>
                        <label for="accept">ACCEPT</label>
                        <input type="radio" name="target" id="drop" value="DROP" <?php if($target == "DROP") echo "checked";?>>
                        <label for="drop">DROP</label>
                    </fieldset>
                    <select name="inter" id="interf" class="hover-style">
                        <option value="">Interface available</option>
                        <?php
                            foreach(getInterface() as $inter){
                        ?>
                            <option value="<?php echo $inter;?>"><?php echo $inter;?></option>
                        <?php   }
                        ?>
                    </select>
                </div>
                <fieldset class="hover-style" >
                    <legend>Protocol</legend>
                    <div id="prot">
                        <div id="blc-tcp">
                            <input type="radio" name="protocol" class="p" id="tcp" value="tcp">
                            <label for="tcp">tcp</label>
                        </div>
                        <div id="blc-udp">
                            <input type="radio" name="protocol" class="p" id="udp" value="udp">
                            <label for="udp">udp</label>
                        </div>
                        <div id="blc-ddp">
                            <input type="radio" name="protocol" class="p" id="ddp" value="ddp">
                            <label for="ddp">ddp</label>
                        </div>
                        <div id="blc-icmp">
                            <input type="radio" name="protocol" class="p" id="icmp" value="icmp">
                            <label for="icmp">icmp</label>
                        </div>
                    </div>
                    <fieldset class="with-add" <?php if($protocol != "") echo 'style="display: flex;"';?>>
                        <legend>Port</legend>
                        <div id="btt-prot">
                            <abbr title="Add port"><button id="add" type="button">+</button></abbr>
                            <abbr title="Reduce port"><button id="remove" type="button">-</button></abbr>
                        </div>
                        <div id="ports">
                            <?php
                                if(!empty($rule[$_GET["chain"]][$nbrule]['oth']) && $protocol !=""){
                                    $ports = getListProtocol();
                                    foreach($ports[$protocol] as $service => $value){
                                        if(strpos($rules[$_GET["chain"]][$nbrule]['oth'],$service)){
                                            echo '<select name="port'.$nbports.'" id="">';
                                            foreach($prts[$protocol] as $s => $v){
                                                echo '<option value="$value"';
                                                if($s == $service){
                                                    echo "selected";
                                                }
                                                echo '>'.$protocol.' '.$s.' '.$v.'</option>';
                                            }
                                            echo "</select>";
                                            $nbports++;
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </fieldset>
                </fieldset>
                <fieldset class="hover-style">
                    <legend id="src">
                        <input type="checkbox" name="src" id="s">
                        <label for="s">Source</label>
                    </legend>
                    <div class="type-machine source">
                        <input type="text" name="smachine" value="<?php echo $scr;?>" placeholder="Enter value">
                        <div id="radioSMac">
                            <input type="radio" name="sMac" id="sMac" <?php echo $smac;?>>
                            <label for="sMac">MAC</label>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="hover-style">
                    <legend id="dest">
                        <input type="checkbox" name="dest" id="d">
                        <label for="d">Destinataire</label>
                    </legend>
                    <div class="type-machine destination">
                        <input type="text" name="dmachine" value="<?php echo $dest;?>" placeholder="Enter value">
                        <div id="radioDMac">
                            <input type="radio" name="dMac" id="dMac" <?php echo $dmac;?>>
                            <label for="dMac">MAC</label>
                        </div>
                    </div>
                </fieldset>
                <div class="under">
                    <div class="over">
                        <i class="fa-sharp fa-solid fa-check" ></i><input type="submit" value="Modify">
                    </div>
                </div>       
            </form>
        </fieldset>
    </section>
    <script>

        const smac = document.querySelector("#radioSMac");
        const dmac = document.querySelector("#radioDMac");
        
        smac.addEventListener("click",(){
            if(document.querySelector("#sMac").checked == true){
                document.querySelector("#sMac").checked = false;
            }
            else{
                document.querySelector("#sMac").checked = true;
            }
        });
        dmac.addEventListener("click",(){
            if(document.querySelector("#dMac").checked == true){
                document.querySelector("#dMac").checked = false;
            }
            else{
                document.querySelector("#dMac").checked = true;
            }
        });
        ///////// Evenement sur les destinataires et sources

        const src = document.querySelector("#src");
        const dest = document.querySelector("#dest");

        src.addEventListener("click",function(){
            if(document.querySelector(".source").style.display == 'flex'){
                document.querySelector(".source").style.display = 'none';
                document.querySelector("#s").checked = false;
                smac.checked = false;
            }
            else{
                document.querySelector(".source").style.display = 'flex';
                document.querySelector("#s").checked = true;
            }
        });
        dest.addEventListener("click",function(){
            if(document.querySelector(".destination").style.display == 'flex'){
                document.querySelector(".destination").style.display = 'none';
                document.querySelector("#d").checked = false;
                dMac.checked = false;
            }
            else{
                document.querySelector(".destination").style.display = 'flex';
                document.querySelector("#d").checked = true;
            }
        });

        /////////// evenement sur les radio protocols
        const blc_tcp = document.querySelector("#blc-tcp");
        const blc_udp = document.querySelector("#blc-udp");
        const blc_ddp = document.querySelector("#blc-ddp");
        const blc_icmp = document.querySelector("#blc-icmp");
        const port = document.querySelector(".with-add");

        let prot = "";

        blc_tcp.addEventListener("click",function(){
            if(port.style.display == 'flex' && prot == "tcp"){
                document.querySelector("#tcp").checked = false;
                port.style.display = 'none';
                prot = "";
            }
            else{
                document.querySelector("#tcp").checked = true;
                document.querySelector(".with-add").style.display = 'flex';
                prot = "tcp";
                document.querySelector("#ports").innerHTML = ``;
            }
        });
        blc_udp.addEventListener("click",function(){
            if(port.style.display == 'flex'  && prot == "udp"){
                document.querySelector("#udp").checked = false;
                port.style.display = 'none';
                prot = "";
            }
            else{
                document.querySelector("#udp").checked = true;
                port.style.display = 'flex';
                prot = "udp";
                document.querySelector("#ports").innerHTML = ``;
            }
        });
        blc_ddp.addEventListener("click",function(){
            if(port.style.display == 'flex'  && prot == "ddp"){
                document.querySelector("#ddp").checked = false;
                port.style.display = 'none';
                prot = "";
            }
            else{
                document.querySelector("#ddp").checked = true;
                port.style.display = 'flex';
                prot = "ddp";
                document.querySelector("#ports").innerHTML = ``;
            }
        });
        blc_icmp.addEventListener("click",function(){
            if(document.querySelector("#icmp").checked == true){
                document.querySelector("#icmp").checked = false;
            }
            else{
                document.querySelector("#icmp").checked = true;
            }
            document.querySelector("#ports").innerHTML = ``;
            port.style.display = 'none';
        });

        // script des boutons add et remove de ports
        const add = document.querySelector("#add");
        const remove = document.querySelector("#remove");

        let index = <?php echo $nbports;?>;

        add.addEventListener("click",(event) => {
            const select = document.createElement("select");            
            let name = "port"+index;
            select.setAttribute("name",name);
            select.className = "port";
            if(prot === "tcp"){
                select.innerHTML = `
                    <option value="" disabled>Ports according to Protocol</option>
                        <?php  
                            foreach($protls['tcp'] as $index2 => $value){ ?>
                                <option value="<?php echo $value; ?>">tcp : <?php echo $value." ".$index2; ?></option>
                        <?php   }
                        ?>
                    `;
                document.querySelector("#ports").append(select);
            }
            else if(prot === "udp"){
                select.innerHTML = `
                    <option value="" disabled>Ports according to Protocol</option>
                        <?php  
                            foreach($protls['udp'] as $index2 => $value){ ?>
                                <option value="<?php echo $value; ?>">udp : <?php echo $value." ".$index2; ?></option>
                        <?php   }
                        ?>
                    `;
                document.querySelector("#ports").append(select);
            }
            else if(prot === "ddp"){
                select.innerHTML = `
                    <option value="" disabled>Ports according to Protocol</option>
                        <?php  
                            foreach($protls['ddp'] as $index2 => $value){ ?>
                                <option value="<?php echo $value; ?>">ddp : <?php echo $value." ".$index2; ?></option>
                        <?php   }
                        ?>
                    `;
                document.querySelector("#ports").append(select);
            }
            index++;
        });

        remove.addEventListener("click",(event) => {
            if(index > 1) index--;
            console.log(document.querySelector("#ports").lastChild.getAttribute("name"));
            document.querySelector("#ports").lastChild.remove();
        });
        
    </script>
</body>
</html>