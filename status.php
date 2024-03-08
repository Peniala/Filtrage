<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="filter.css">
    <link rel="stylesheet" href="status.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.4.2-web/css/all.css">
    <title>Filter</title>
</head>
<body>
    <?php include "dataStatus.php"; ?>
    <nav>
        <h1>Filter.</h1>
        <a href="policy.php"><div class="link">Policy</div></a>
        <a href="filter.php"><div class="link">Rules</div></a>
        <a href="status.php"><div class="link">Status</div></a>
        <a href=""><div class="link">Save</div></a>
        <a href=""><div class="link">Help</div></a>
    </nav>
    <section>
        <a href="status.php?action=reset" ><abbr title="Reset rules"><button type="button" id="reset-button">Reset</button></abbr></a>
        <fieldset class="center">
            <legend>Chain Policy : Input <?php echo $policy[0];?></legend>
            <div class="each-rule">
            <?php
                for($j=2; $j < count($rules['input'])-1; $j++){ ?>
                    <div><?php echo $rules['input'][$j]['acces']; ?></div>
                    <div><?php echo $rules['input'][$j]['prot']; ?></div>
                    <div><?php echo $rules['input'][$j]['opt']; ?></div>
                    <div><?php echo $rules['input'][$j]['src']; ?></div>
                    <div><?php echo $rules['input'][$j]['dest']; ?></div>
                    <div><?php echo $rules['input'][$j]['oth']; ?></div>
                    <div class="action">
                        <a href="status.php?action=mod&chain=input&rule=<?php echo $j;?>"><button type="button">Mod</button></a>
                        <a href="status.php?action=del&chain=input&rule=<?php echo $j;?>"><button type="button">Del</button></a>
                    </div>
                <?php }
            ?>
            </div>
        </fieldset>
        <fieldset class="center">
            <legend>Chain Policy : Forward <?php echo $policy[1];?></legend>
            <div class="each-rule">
            <?php
                for($j=2; $j < count($rules['forward']); $j++){
                    foreach($rules['forward'][$j] as $value){
                        echo "<div>$value</div>";
                    }
                }
            ?>
            </div>
        </fieldset>
        <fieldset class="center">
            <legend>Chain Policy : Output <?php echo $policy[2];?></legend>
            <div class="each-rule">
            <?php
                for($j=2; $j < count($rules['output']); $j++){
                    foreach($rules['output'][$j] as $value){
                        echo "<div>$value</div>";
                    }
                }
            ?>
            </div>
        </fieldset>
    </section>
</body>
</html>