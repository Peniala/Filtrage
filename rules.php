const src = document.querySelector("#src");
const dest = document.querySelector("#dest");

src.addEventListener("click",function(){
    document.querySelector(".source").style.display = 'flex';
});
dest.addEventListener("click",function(){
    document.querySelector(".destination").style.display = 'flex';
});

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
