<?php
    include_once 'header.php';
    require_once 'includes/dbh.inc.php';
?>
<?php 
if (!isset($_SESSION["useruid"])) {
    header("location: signup.php?error=notsignedup");
    exit();
}
?>

<script src="includes/js/validation.js"></script>

 <form action='includes/boeking.inc.php' methode='get' name = "myForm" onsubmit = "return validate_cc(document.myForm.cc_number.value, document.myForm.cc_expiry.value, document.myForm.cc_cvc.value)">  
    <div class="container">
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "noterms") {
                $i = $_GET["i"];
            }
        } else {
            $i = $_GET["reis"];
        }
        $reis = $_SESSION["results"][$i];
        $reisid = $reis["reisId"];
        $reisnaam = $reis["reisNaam"];
        ?>
        <h1><?php echo $reisnaam?></h1>
        <div>
            <label for="datum">Wanneer?</label>
            <input type='date' name='datum'>
            <label for="personen">Aantal personen:</label>
            <select name='personen' id=''> <!-- aantal personen -->
                <option value='1'>1</option>
            </select>
            <p>Betaalgegevens invullen</p>
            <p><input type='text' name='cc_number'> Credit card number</p>
            <p><input type='text' name='cc_holder'> Name cardholder</p>
            <p><input type='text' name='cc_expiry'> Expiry date dd/mm</p>
            <p><input type='text' name='cc_cvc'> CVC code</p>
            <input type='checkbox' name='terms' id='terms'>
            <span>You have read and agree with the <a href='terms.php'>Terms of Service</a>.</span> <br>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "noterms") {
                    echo "<p>You didn't agree to our Terms of Service.</p>";
                }
            }
            ?>
            <button name='i' type='submit' value='<?php echo $i?>'>Boeken</button>
        </div>
    </div>
</form>


<?php
    include_once 'footer.php';
?>