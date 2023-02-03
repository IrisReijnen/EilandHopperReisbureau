<?php
    include_once 'header.php';
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
?>

<div class="container">
    <div class="gegeven">
        <h2>Gegevens </h2><br>
        <?php
        if (isset($_SESSION["useruid"])) {
            $uid = $_SESSION["useruid"];
            $email = $_SESSION["useremail"];
            $uidExists = uidExists($conn, $email, $email);
            $id = $uidExists["usersId"];
            $naam = $uidExists["usersName"];
        ?>
        <p>Naam: <?php echo $naam ?></p>
        <p>Userid: <?php echo $uid ?></p>
        <p>E-mail: <?php echo $email ?></p><br>
    </div>

    <div class="boekingen">   
        <h2>Mijn boekingen </h2><br>
        <div>
            <span>Reisnaam - Datum</span>
        </div>
    <?php
        $rows = getRows($conn, "boeking", "usersId", $id);
        //print_r($rows);
        if (is_array($rows)) {
            foreach ($rows as $row) {
                $reisid = $row["reisId"];
                $reis = getRows($conn, "reis", "reisId", $reisid)[0];
                //print_r($reis);
                ?>
                
                <span><?php echo $reis["reisNaam"] . " - " . $row["boekingDatumAanbetaald"]?> </span>
                <?php if ($row["boekingGeannuleerd"] == 0) { ?>
                <form action="includes/annuleren.inc.php" method="post">
                    <button name="id" type="submit" value="<?php echo $row['boekingId']?>">Annuleren</button>
                </form>
                <?php } else { ?>
                    <span id="geannuleerd">Geannuleerd</span><br>
                <?php } ?>
            
            <?php
            }
        } else {
            echo "Nog geen boekingen gevonden";
        }
    }
    ?>
    </div>
</div>

<?php
    include_once 'footer.php';
?>