<?php
    include_once 'header.php';
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
?>

<div class="container">
<?php
if (isset($_GET["i"])) {
    $i = $_GET["i"];
    $reis = $_SESSION["results"][$i];
    $reisid = $reis["reisId"];
    $reisnaam = $reis["reisNaam"];
    echo "<h1>$reisnaam</h1>";
}
?>

<!-- Alle bestaande referenties -->
<div>
    <?php
    $rows = getValue($conn, "*", "referentie", "reisId", $reisid);
    // stop;
    foreach($rows as $row){
        $refuid = getValue($conn, "usersUid", "users", "usersId", $row["usersId"])[0]["usersUid"];
        $reftext = $row["referentieText"];
        echo "<h3>" . $refuid . "</h3>";
        echo "<p>$reftext</p>";
    }
    ?>
    <p></p>
</div>

<!-- Add een referentie -->
<br>
<?php if (isset($_SESSION["useruid"])) { ?>
<form action="includes/referentie.inc.php" method="get">
    <?php 
        echo "<h3>" . $_SESSION["useruid"] . "</h3>";
    ?>
    <textarea name="message" rows="10" cols="30">Write your reference.</textarea>
    <button type="submit" name="add" value="<?php echo $i; ?>">Post</button>
</form>
<?php } ?>
</div>

<?php
    include_once 'footer.php';
?>