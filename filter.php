<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="filter.css">
    <link rel="stylesheet" href="rules.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.4.2-web/css/all.css">
    <title>Filter</title>
</head>
<body>
    <?php 
        include "dataRules.php";
    ?>
    <nav>
        <h1>Filter.</h1>
        <a href="policy.php"><div class="link">Policy</div></a>
        <a href="filter.php"><div class="link">Rules</div></a>
        <a href="status.php"><div class="link">Status</div></a>
        <a href=""><div class="link">Help</div></a>
    </nav>
    <section>
        <fieldset class="center">
            <legend class="lparts">Add rules</legend>
            <form action="" method="">
                <div class="block target-rules">
                    <select name="chain" id="" class="hover-style">
                        <option value="" disabled>Chain</option>
                        <option value="INPUT">INPUT</option>
                        <option value="FORWARD">FORWARD</option>
                        <option value="OUTPUT">OUTPUT</option>
                    </select>
                    <fieldset class="hover-style">
                        <legend>Target</legend>
                        <input type="radio" name="target" id="accept" value="ACCEPT">
                        <label for="accept">ACCEPT</label>
                        <input type="radio" name="target" id="drop" value="DROP">
                        <label for="drop">DROP</label>
                    </fieldset>
                    <select name="inter" id="interf" class="hover-style">
                        <option value="" disabled>Interface available</option>
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
                    <fieldset class="with-add">
                        <legend>Port</legend>
                        <div id="btt-prot">
                            <abbr title="Add port"><button id="add" type="button">+</button></abbr>
                            <abbr title="Reduce port"><button id="remove" type="button">-</button></abbr>
                        </div>
                        <div id="protocols">    
                        </div>
                    </fieldset>
                </fieldset>
                <fieldset class="hover-style">
                    <legend id="src">
                        <input type="checkbox" name="src" id="s">
                        <label for="s">Source</label>
                    </legend>
                    <div class="type-machine source">
                        <input type="text" name="machine" placeholder="Enter value">
                        <div>
                            <input type="radio" name="smach" id="sDomain" >
                            <label for="sDomain">Domain Name</label>
                        </div>
                        <div >
                            <input type="radio" name="smach" id="sIp" >
                            <label for="sIp">IP</label>
                        </div>
                        <div>
                            <input type="radio" name="smach" id="sMac" >
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
                        <input type="text" name="machine" placeholder="Enter value">
                        <div>
                            <input type="radio" name="dmach" id="dDomain" >
                            <label for="dDomain">Domain Name</label>
                        </div>
                        <div >
                            <input type="radio" name="dmach" id="dIp" >
                            <label for="dIp">IP</label>
                        </div>
                        <div>
                            <input type="radio" name="dmach" id="dMac" >
                            <label for="dMac">MAC</label>
                        </div>
                    </div>
                </fieldset>
                <div class="under">
                    <div class="over">
                        <i class="fa-sharp fa-solid fa-check" ></i><input type="submit" value="Valid">
                    </div>
                </div>       
            </form>
        </fieldset>
    </section>
    <script>
        const src = document.querySelector("#src");
        const dest = document.querySelector("#dest");

        src.addEventListener("click",function(){
            if(document.querySelector(".source").style.display == 'flex'){
                document.querySelector(".source").style.display = 'none';
                document.querySelector("#s").checked = false;
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
            }
            else{
                document.querySelector(".destination").style.display = 'flex';
                document.querySelector("#d").checked = true;
            }
        });

        const port = document.querySelector(".with-add");

        const blc_tcp = document.querySelector("#blc-tcp");
        const blc_udp = document.querySelector("#blc-udp");
        const blc_ddp = document.querySelector("#blc-ddp");
        const blc_icmp = document.querySelector("#blc-icmp");

        let prot = "";

        blc_tcp.addEventListener("click",function(){
            document.querySelector("#tcp").checked = true;
            port.style.display = 'flex';
            prot = "tcp";
        });
        blc_udp.addEventListener("click",function(){
            document.querySelector("#udp").checked = true;
            port.style.display = 'flex';
            prot = "udp";
        });
        blc_ddp.addEventListener("click",function(){
            document.querySelector("#ddp").checked = true;
            port.style.display = 'flex';
            prot = "ddp";
        });
        blc_icmp.addEventListener("click",function(){
            document.querySelector("#icmp").checked = true;
            port.style.display = 'none';
        });

        // script des boutons add et remove de ports

        const add = document.querySelector("#add");
        const remove = document.querySelector("#remove");

        let index = 1;

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
                document.querySelector("#protocols").append(select);
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
                document.querySelector("#protocols").append(select);
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
                document.querySelector("#protocols").append(select);
            }
            index++;
        });

        remove.addEventListener("click",(event) => {
            if(document.querySelector("#protocols").lastChild.getAttribute("name") !== "prot"){
                console.log(document.querySelector("#protocols").lastChild.getAttribute("name"));
                document.querySelector("#protocols").lastChild.remove();
            }
                
        });
    </script>
</body>
</html>