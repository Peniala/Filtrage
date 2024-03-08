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
        <a href=""><div class="link">Save</div></a>
        <a href=""><div class="link">Help</div></a>
    </nav>
    <section>
        <fieldset class="center">
            <legend class="lparts">Add rules</legend>
            <form action="" method="">
                <div class="block target-rules">
                    <select name="chain" id="" class="hover-style">
                        <option value="" disabled>Chain</option>
                        <option value="input">INPUT</option>
                        <option value="forward">FORWARD</option>
                        <option value="output">OUTPUT</option>
                    </select>
                    <fieldset class="hover-style">
                        <legend>Target</legend>
                        <input type="radio" name="target" id="accept" value="accept">
                        <label for="accept">ACCEPT</label>
                        <input type="radio" name="target" id="drop" value="drop">
                        <label for="drop">DROP</label>
                    </fieldset>
                    <fieldset class="hover-style" id="prot">
                        <legend>Protocol</legend>
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
                    </fieldset>
                </div>
                <fieldset class="with-add">
                    <legend>Port</legend>
                    <div id="btt-prot">
                        <button id="add" type="button">+</button>
                        <button id="remove" type="button">-</button>
                    </div>
                    <div id="protocols">
                        
                    </div>
                </fieldset>
                <fieldset>
                    <legend><input type="checkbox"> Source</legend>
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
        const tcp = document.querySelector("#tcp");
        const udp = document.querySelector("#udp");
        const ddp = document.querySelector("#ddp");
        const icmp = document.querySelector("#icmp");

        console.log(tcp);

        const port = document.querySelector(".with-add");

        const blc_tcp = document.querySelector("#blc-tcp");
        const blc_udp = document.querySelector("#blc-udp");
        const blc_ddp = document.querySelector("#blc-ddp");
        const blc_icmp = document.querySelector("#blc-icmp");

        let prot = "";

        blc_tcp.addEventListener("click",function(){
            port.style.display = 'flex';
            prot = "tcp";
        });
        blc_udp.addEventListener("click",function(){
            port.style.display = 'flex';
            prot = "udp";
        });
        blc_ddp.addEventListener("click",function(){
            port.style.display = 'flex';
            prot = "ddp";
        });
        blc_icmp.addEventListener("click",function(){
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
                                <option value="<?php echo $value; ?>">tcp : <?php echo $index2." ".$value; ?></option>
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
                                <option value="<?php echo $value; ?>">udp : <?php echo $index2." ".$value; ?></option>
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
                                <option value="<?php echo $value; ?>">ddp : <?php echo $index2." ".$value; ?></option>
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