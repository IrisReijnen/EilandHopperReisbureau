<?php
    // Now changed in php.ini file
    // display_errors = on
    // This worked after restarting teh Apache Server
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    include_once 'header.php';
    require_once 'includes/dbh.inc.php';
?>
<!-- <?php
    if (isset($_SESSION["useruid"])) {
        echo "<p>Hello " . $_SESSION["useruid"] . "</p>";
    }
?> -->

<!-- <div class="logo"><a href="index.php"><img src="img/plane.gif" alt="Gohar" /></a></div> -->
<div class="" align="center"><img src="img/plane.gif" /></div>

<form action="includes/index.inc.php" method="post" id="zoek">
    <div class="zoeken">
        <div class="keuzeContainer">
            <label for="stad">Stad</label>
            <select name="stad" form="zoek">
                <?php 
                    echo "<option value='%'>Any</option>";
                    $sql = mysqli_query($conn, "SELECT reisStad FROM reis");
                    while ($row = $sql->fetch_assoc()){
                        $stad = $row['reisStad'];
                        echo "<option value='$stad'>$stad</option>";
                    }
                ?>
            </select>
        </div>
        <div class="keuzeContainer">
            <label for="activiteit">Activiteit</label>
            <select name="activiteit" >
                <?php 
                    echo "<option value='%'>Any</option>";
                    $sql = mysqli_query($conn, "SELECT reisActiviteit FROM reis");
                    while ($row = $sql->fetch_assoc()){
                        $activiteit = $row['reisActiviteit'];
                        echo "<option value='$activiteit'>$activiteit</option>";
                    }
                ?>
            </select>
        </div>
        <div class="keuzeContainer">
            <!-- From: https://jqueryui.com/slider/#range -->
        <?php
            $sql = mysqli_query($conn, "SELECT MAX(reisPrijs) as maxPrijs FROM reis");
            $row = mysqli_fetch_array($sql);
        ?>
        <script>
        $( function() {
            $( "#slider-range" ).slider({
            range: true,
            min: 0,
            max: <?php echo $row["maxPrijs"]?>,
            values: [ 0, <?php echo $row["maxPrijs"]?> ],
            slide: function( event, ui ) {
                // write slider handle positions to html elements by id (#)
                $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                $( "#minPrijs" ).val( ui.values[ 0 ]);
                $( "#maxPrijs" ).val( ui.values[ 1 ]);
            }
            });
            // write initial slider handle positions to html elements by id (#)
            jQuery( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
            " - $" + $( "#slider-range" ).slider( "values", 1 ) );
            $( "#minPrijs" ).val( $( "#slider-range" ).slider( "values", 0 ));
            $( "#maxPrijs" ).val( $( "#slider-range" ).slider( "values", 1 ));
        } );
        </script>
        <p>
        <label for="amount" style="color:black;">Price range:</label>
        <input type="text" id="amount" readonly style="border:0; color:black; font-weight:bold; background-color: rgba(0, 0, 0, 0);">
        <input type="hidden" id="minPrijs", name="minPrijs">
        <input type="hidden" id="maxPrijs", name="maxPrijs">
        </p> 
        <div id="slider-range" style="width: 100%"></div>
        </div>
        <div class="keuzeContainer">
            <label for="duur">Duur</label>
            <select name="duur" >
                <?php
                    echo "<option value='%'>Any</option>";
                    $sql = mysqli_query($conn, "SELECT reisDuur FROM reis");
                    while ($row = $sql->fetch_assoc()){
                        $duur = $row['reisDuur'];
                        echo "<option value='$duur'>$duur</option>";
                    }
                ?>
            </select>
        </div>
        <!-- Examples line prints
        console.log("Hello world!");
        <?php echo "php print"?>;
        -->
        <button type="submit" name="submit">Zoeken</button>
    </div>
</form>

<div class="container">
<?php
if (isset($_GET["zoeken"])) {
    $rows = $_SESSION["results"];
    $i = 0;
    foreach($rows as $row){
        $hover = 'hover' . $i;
?>

            <div class='reisContainer'>
                <div class='sideimg'>
                    <img src='img/<?php echo $row["reisPlaatje"] ?>' width=250px alt='Eiland Hopper'>
                </div>
                <div class='reis'>
                    <H1><?php echo $row["reisNaam"] ?></H1>
                    <h2><?php echo $row["reisStad"] ?>, <?php echo $row["reisLand"] ?></h2>
                    <h2>Duur: <?php echo $row["reisDuur"] ?> dagen</h2>
                    <h2>Prijs: <?php echo $row["reisPrijs"] ?> p.p.</h2>
                    <h2><?php echo $row["reisActiviteit"] ?></h2>
                    <!-- Trigger/Open The Modal -->
                    <button id="myBtn<?php echo $i ?>">Klik voor omschrijving.</button>
                    <div id="myModal<?php echo $i ?>" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div id="cross<?php echo $i ?>"><span class="close">&times;</span></div>
                            <p><?php echo $row["reisOmschrijving"] ?></p>
                        </div>
                    </div>
                    <!-- <div id="<?php //echo $hover?>" title="Omschrijving">
                        <p>Klik voor omschrijving.</p>
                    </div>
                    <div id="<?php //echo "box" . $i?>" class="box" title="Omschrijving">
                        <p> <?php //echo $row["reisOmschrijving"]?> ...............................................................................</p>
                    </div> -->
                    <a href='referentie.php?i=<?php echo $i ?>'>Referenties</a>
                    <form action='boeking.php' methode='get'>
                        <button name='reis' type='submit' value='<?php echo $i ?>'>Boeken</button>
                    </form>
                </div>
                <div class='sideimg'>
                    <img class='sideimg' src='img/<?php echo $row["reisKaart"] ?>' width=250px alt='Eiland Hopper'>
                </div>
            </div><br>
            <script>
            // Get the modal
            var modal<?php echo $i ?> = document.getElementById("myModal<?php echo $i ?>");

            // Get the button that opens the modal
            var btn<?php echo $i ?> = document.getElementById("myBtn<?php echo $i ?>");

            // Get the <span> element that closes the modal
            var span = document.getElementById("cross<?php echo $i ?>");

            // When the user clicks the button, open the modal 
            btn<?php echo $i ?>.onclick = function() {
            modal<?php echo $i ?>.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
            modal<?php echo $i ?>.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
            if (event.target == modal<?php echo $i ?>) {
                modal<?php echo $i ?>.style.display = "none";
            }
            }
            </script>
            
            <!-- <script>
            $( function() {
                // jQuery is explained in https://api.jquery.com/id-selector/
                // Shorthand:
                // jQuery( ) = $( ) 
                // document.getElementById() = # : the id selector
                // .dialog() function in https://jqueryui.com/dialog/ and https://api.jqueryui.com/dialog/
                // Turns text in element to popup dialog
                var box = $( "#<?php echo "box" . $i?>" ).dialog();
                box.dialog( "close" );
                $( "#<?php echo $hover?>" ).click(function() {  // mouseover
                box.dialog( "open" ).dialog("widget").position({
                    my: 'middle',
                    at: 'middle',
                    of: $(this)
                    });;
                //}).mouseout(function() {
                //box.dialog( "close" );
            });
            } );
            </script> -->
            <?php
                $i = $i + 1;
                }
            }
            ?>
</div>

<?php
    include_once 'footer.php';
?>