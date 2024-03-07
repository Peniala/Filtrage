<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        if(!empty($_GET["nbport"])) $nbport = $_GET["nbport"];
        else $nbport = 1;
    ?>
    <form action="" method="get">
        <fieldset>
            <legend>Port</legend>
            <div style="display: grid; grid-template-columns : repeat(9,1fr);">
            <?php
                for($i = 1; $i <= $nbport ; $i++){ ?>
                    <select name="prot<?php echo $i; ?>" id="" size="2" style="margin: 1vw;">
                    <?php   for($j=0; $j < 10; $j++){?>
                            <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
                    <?php   }?>
                    </select>
                <?php }
                $nbport++;
                ?>
            </div>
            <a href="test.php?nbport=<?php echo $nbport;?>"><button type="submit">+</button></a>
            <a href="test.php?nbport=<?php echo $nbport-1; ?>"><button type="submit">-</button></a>
        </fieldset>
        <!-- <input type="text" name="ttprot" value=""> -->
        <input type="submit" value="OK">
    </form>
</body>
</html>