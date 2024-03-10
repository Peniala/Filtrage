<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="policy.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.4.2-web/css/all.css">
    <title>Filter</title>
</head>
<body>
    <?php
        include "dataPolicy.php";
    ?>
    <nav>
        <h1>Filter.</h1>
        <a href="policy.php"><div class="link">Policy</div></a>
        <a href="rules.php"><div class="link">Rules</div></a>
        <a href="status.php"><div class="link">Status</div></a>
        <a href=""><div class="link">Help</div></a>
    </nav>
    <section>
        <fieldset class="center">
            <legend class="lparts">Change policy</legend>
            <form action="policy.php" method="get">
                <fieldset class="hover-style">
                    <legend>Input</legend>
                    <input type="radio" name="pInput" id="acceptIn" value="ACCEPT" <?php verifyChecked($pInput,"ACCEPT"); ?> >
                    <label for="acceptIn">ACCEPT</label>
                    <input type="radio" name="pInput" id="dropIn" value="DROP" <?php verifyChecked($pInput,"DROP"); ?> >
                    <label for="dropIn">DROP</label>
                    <abbr title="Commit change"><input type="submit" value=">" class="sub"></abbr>
                </fieldset>
            </form>
            <form action="policy.php" method="get">
                <fieldset class="hover-style">
                    <legend>Forward</legend>
                    <input type="radio" name="pForward" id="acceptFor" value="ACCEPT" <?php verifyChecked($pForward,"ACCEPT"); ?> >
                    <label for="acceptFor">ACCEPT</label>
                    <input type="radio" name="pForward" id="dropFor" value="DROP" <?php verifyChecked($pForward,"DROP"); ?> >
                    <label for="dropFor">DROP</label>
                    <abbr title="Commit change"><input type="submit" value=">" class="sub"></abbr>
                </fieldset>
            </form>
            <form action="policy.php" method="get">
                <fieldset class="hover-style">
                    <legend>Output</legend>
                    <input type="radio" name="pOutput" id="acceptOut" value="ACCEPT" <?php verifyChecked($pOutput,"ACCEPT"); ?> >
                    <label for="acceptOut">ACCEPT</label>
                    <input type="radio" name="pOutput" id="dropOut" value="DROP" <?php verifyChecked($pOutput,"DROP"); ?> >
                    <label for="dropOut">DROP</label>
                    <abbr title="Commit change"><input type="submit" value=">" class="sub"></abbr>
                </fieldset>
            </form>
            <fieldset class="box-button">
                <a href="policy.php?pInput=ACCEPT&pForward=ACCEPT&pOutput=ACCEPT"><button>ACCEPT ALL</button></a>
                <a href="policy.php?pInput=DROP&pForward=DROP&pOutput=DROP"><button>DROP ALL</button></a>
            </fieldset>
        </fieldset>
        <fieldset class="center block">
            <legend class="lparts">Status Policy</legend>
            <fieldset class="hover-style">
                <legend>Input</legend>
                <h1><?php echo $pInput;?></h1>
            </fieldset>
            <fieldset class="hover-style">
                <legend>Forward</legend>
                <h1><?php echo $pForward;?></h1>
            </fieldset>
            <fieldset class="hover-style">
                <legend>Output</legend>
                <h1><?php echo $pOutput;?></h1>
            </fieldset>
        </fieldset>
    </section>
</body>
</html>