<?php
    session_start();
    include "dataStatus.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="status.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.4.2-web/css/all.css">
    <title>Filter</title>
</head>
<body>
    <nav>
        <h1>Filter.</h1>
        <a href="policy.php"><div class="link">Policy</div></a>
        <a href="rules.php"><div class="link">Rules</div></a>
        <a href="status.php"><div class="link">Status</div></a>
        <a href=""><div class="link">Help</div></a>
    </nav>
    <section>
        <div style="width: 100%; display: flex;">
            <a style="width:33%; margin: 1vw;" href="status.php?action=reset" ><abbr title="Reset rules"><button type="button" class="act-button">Reset</button></abbr></a>
            <a style="width:33%; margin: 1vw;" href="status.php?action=save" ><abbr title="Save all rules into register"><button type="button" class="act-button">Save</button></abbr></a>
            <a style="width:33%; margin: 1vw;" href="status.php?action=restore" ><abbr title="Restore rules from last register"><button type="button" class="act-button">Restore last register</button></abbr></a>
        </div>
        <fieldset class="center">
            <legend><div id="view-in">Chain Policy : Input <?php echo $policy[0];?></div></legend>
            <div class="each-rule" id="input">
                <div class="title">Target</div>
                <div class="title">Protocol</div>
                <div class="title">Options</div>
                <div class="title">Source</div>
                <div class="title">Destination</div>
                <div class="title">Other</div>
                <div class="title">Action</div>
            <?php
                for($j=6; $j < count($rules['input'])-1; $j++){ ?>
                    <div><?php echo $rules['input'][$j]['acces']; ?></div>
                    <div><?php echo $rules['input'][$j]['prot']; ?></div>
                    <div><?php echo $rules['input'][$j]['opt']; ?></div>
                    <div><?php echo $rules['input'][$j]['src']; ?></div>
                    <div><?php echo $rules['input'][$j]['dest']; ?></div>
                    <div><?php echo $rules['input'][$j]['oth']; ?></div>
                    <div class="action">
                        <a href="rules.php?action=mod&chain=input&rule=<?php echo $j;?>"><button type="button">Mod</button></a>
                        <a href="status.php?action=del&chain=input&rule=<?php echo $j;?>"><button type="button">Del</button></a>
                    </div>
                <?php }
            ?>
            </div>
        </fieldset>
        <fieldset class="center">
            <legend><div id="view-forw">Chain Policy : Forward <?php echo $policy[1];?></div></legend>
            <div class="each-rule" id="forward">
                <div class="title">Target</div>
                <div class="title">Protocol</div>
                <div class="title">Options</div>
                <div class="title">Source</div>
                <div class="title">Destination</div>
                <div class="title">Other</div>
                <div class="title">Action</div>
            <?php
                for($j=2; $j < count($rules['forward'])-1; $j++){ ?>
                    <div><?php echo $rules['forward'][$j]['acces']; ?></div>
                    <div><?php echo $rules['forward'][$j]['prot']; ?></div>
                    <div><?php echo $rules['forward'][$j]['opt']; ?></div>
                    <div><?php echo $rules['forward'][$j]['src']; ?></div>
                    <div><?php echo $rules['forward'][$j]['dest']; ?></div>
                    <div><?php echo $rules['forward'][$j]['oth']; ?></div>
                    <div class="action">
                        <a href="rules.php?action=mod&chain=forward&rule=<?php echo $j;?>"><button type="button">Mod</button></a>
                        <a href="status.php?action=del&chain=forward&rule=<?php echo $j;?>"><button type="button">Del</button></a>
                    </div>
                <?php }
            ?>
            </div>
        </fieldset>
        <fieldset class="center">
            <legend><div id="view-out">Chain Policy : Output <?php echo $policy[2];?></div></legend>
            <div class="each-rule" id="output">
                <div class="title">Target</div>
                <div class="title">Protocol</div>
                <div class="title">Options</div>
                <div class="title">Source</div>
                <div class="title">Destination</div>
                <div class="title">Other</div>
                <div class="title">Action</div>
            <?php
                for($j=6; $j < count($rules['output'])-1; $j++){ ?>
                    <div><?php echo $rules['output'][$j]['acces']; ?></div>
                    <div><?php echo $rules['output'][$j]['prot']; ?></div>
                    <div><?php echo $rules['output'][$j]['opt']; ?></div>
                    <div><?php echo $rules['output'][$j]['src']; ?></div>
                    <div><?php echo $rules['output'][$j]['dest']; ?></div>
                    <div><?php echo $rules['output'][$j]['oth']; ?></div>
                    <div class="action">
                        <a href="rules.php?action=mod&chain=output&rule=<?php echo $j;?>"><button type="button">Mod</button></a>
                        <a href="status.php?action=del&chain=output&rule=<?php echo $j;?>"><button type="button">Del</button></a>
                    </div>
                <?php }
            ?>
            </div>
        </fieldset>
    </section>
    <script>
        const view_in = document.querySelector("#view-in");
        const inp = document.querySelector("#input");
        const view_forw = document.querySelector("#view-forw");
        const forw = document.querySelector("#forward");
        const view_out = document.querySelector("#view-out");
        const out = document.querySelector("#output");
        view_in.addEventListener("click",function(){
            if(inp.style.display === 'grid'){
                inp.style.display = "none";
            }
            else{
                inp.style.display = 'grid';
            }
        });
        view_forw.addEventListener("click",function(){
            if(forw.style.display === 'grid'){
                forw.style.display = "none";
            }
            else{
                forw.style.display = 'grid';
            }
        });
        view_out.addEventListener("click",function(){
            if(out.style.display === 'grid'){
                out.style.display = "none";
            }
            else{
                out.style.display = 'grid';
            }
        });
    </script>
</body>
</html>