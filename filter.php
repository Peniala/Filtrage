<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="filter.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.4.2-web/css/all.css">
    <title>Filter</title>
</head>
<body>
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
                <div class="target-policy target-rules">
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
                        <input type="radio" name="target" id="reject" value="reject">
                        <label for="reject">REJECT</label>
                    </fieldset>
                    <fieldset class="hover-style">
                        <legend>Protocol</legend>
                        <input type="radio" name="protocol" id="accept" value="accept">
                        <label for="accept">ACCEPT</label>
                        <input type="radio" name="protocol" id="drop" value="drop">
                        <label for="drop">DROP</label>
                        <input type="radio" name="protocol" id="reject" value="reject">
                        <label for="reject">REJECT</label>
                    </fieldset>
                </div>
                <fieldset class="with-add">
                    <legend>Port</legend>
                </fieldset>
                <div class="target-policy">
                    <fieldset>
                        <input type="checkbox" name="target" id="source" value="accept">
                        <label for="source">Source</label>
                        <input type="checkbox" name="target" id="dest" value="drop">
                        <label for="dest">Destination</label>
                    </fieldset>
                </div>
                <fieldset class="with-add">
                    <legend>IP</legend>
                    <input type="text" name="protocol" placeholder="IP" class="hover-style">
                </fieldset>
                <fieldset class="with-add">
                    <legend>MAC</legend>
                    <input type="text" name="protocol" placeholder="MAC" class="hover-style">
                </fieldset>
                <div class="under">
                    <div class="over">
                        <i class="fa-sharp fa-solid fa-check" ></i><input type="submit" value="Valid">
                    </div>
                </div>       
            </form>
        </fieldset>
    </section>
</body>
</html>