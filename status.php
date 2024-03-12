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
        <a href="status.php?logout=yes"><div class="link">Log out</div></a>
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
                <?php
                    displayRules('input');
                ?>
            </div>
        </fieldset>
        <fieldset class="center">
            <legend><div id="view-forw">Chain Policy : Forward <?php echo $policy[1];?></div></legend>
            <div class="each-rule" id="forward">
                <?php
                    displayRules('forward');
                ?>
            </div>
        </fieldset>
        <fieldset class="center">
            <legend><div id="view-out">Chain Policy : Output <?php echo $policy[2];?></div></legend>
            <div class="each-rule" id="output">
                <?php
                    displayRules('output');
                ?>
            </div>
        </fieldset>
    </section>
    <script src="status.js"></script>
</body>
</html>