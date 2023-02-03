<?php
    include_once 'header.php';
    require_once 'includes/dbh.inc.php';
    require_once 'includes/functions.inc.php';
?>
<!-- CHECKEN OF DE USER ADMIN IS! -->
<?php
    if (isset($_SESSION["useruid"])) {
        if (!($_SESSION["useruid"] == "admin")) {
            header("location: index.php");
            exit();
        }
        
    } else{
        header("location: index.php");
        exit();
    }
    if (isset($_SESSION["uploadmsg"])) {
        echo "<p>Upload message: " . $_SESSION["uploadmsg"] . "</p>";
    }
?>

<div class="container">
    <h1>Admin</h1><br>
    <div class="uploadimg">
        <form action="includes/uploadimg.inc.php" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload" name="submit">
        </form>
    </div><br>

    <div class="gettable">
        <form action="includes/gettable.inc.php" method="post" id="gettable">
            <button type="submit" value="boeking" name="tablename">Boekingen</button>
            <button type="submit" value="reis" name="tablename">Reizen</button>
            <button type="submit" value="users" name="tablename">Users</button>
            <button type="submit" value="boeking" name="geannuleerd">Geannuleerde boekingen</button>
        </form>
    </div>

    <div id="reis" class="tabcontent">
    <?php
        if (isset($_SESSION["tablename"])){
            $tablename = $_SESSION["tablename"];
            if ($tablename == "boeking") {
                $tablecols = ["User nr.", "reis nr.", "aanbetaald", "betaald", "reis begonnen", "geannuleerd", "datum aanbetaling", "datum annulering", "datum betaling"];
                echo "<h3>Boekingen</h3>";
            } elseif ($tablename == "reis") {
                $tablecols = ["reis naam", "land", "stad", "prijs", "reisduur", "activiteit", "omschrijving", "image"];
                echo "<h3>Reizen</h3>";
            } elseif ($tablename == "users") {
                $tablecols = ["naam", "email", "stad", "userid", "password"];
                echo "<h3>Users</h3>";
            } elseif ($tablename == "geannuleerd") {
                $tablecols = ["User nr.", "reis nr.", "aanbetaald", "betaald", "reis begonnen", "geannuleerd", "datum aanbetaling", "datum annulering", "datum betaling"];
                echo "<h3>Geannuleerde boekingen</h3>";
            }
            $table = $_SESSION["table"];
            $count = count($table);
            if ($count > 0){
                //print_r($table);
                //stop;
                // First take row, then column names of row
                $colnames = array_keys($table[0]);
                // print_r($colnames);
                echo "<form action='includes/crudrow.inc.php' method='post' enctype='multipart/form-data'>";
                // foreach ($tablecols as $col){
                //     echo " $col - ";
                // }
                echo "<br>";
                foreach ($colnames as $colname){
                    if ($colname === $colnames[0]){
                        echo "-Add column- ";
                    }
                    else {
                        // Input text field for each column except the first column which is the id
                        // echo "at save $colname";
                        // The array notation in the name causes the POST to collect the inputs as an array 'row'
                        echo "<input type='text' value='$colname' name='row[$colname]'>";
                    }
                }
                echo "<button type='submit' name='insert'>Insert</button>";
                echo "<br><br>";
                echo "</form>";
                foreach ($table as $row){
                    echo "<form action='includes/crudrow.inc.php' method='post' enctype='multipart/form-data'>";
                    echo "<button type='submit' name='delete'>Delete</button>";
                    foreach ($row as $colname => $column){
                        if ($colname === $colnames[0]){
                            // For the first column = $...Id only display the value, hide the input field so it cannot be edited
                            echo " $column<input type='hidden' value='$column' name='row[$colname]'> ";
                        }
                        else {
                            // Input text field for each column except the first column which is the id
                            // The array notation in the name causes the POST to collect the inputs as an array 'row'
                            echo "<input type='text' value='$column' name='row[$colname]'>";
                        }
                    }
                    echo "<button type='submit' name='update'>Save</button>";
                    echo "<br><br>";
                    echo "</form>";
                }
            }
        } else {
            echo "<h3>Kies een van de tabellen hierboven.<h3>";
        }
    ?>
    </div>
</div>

<?php
    include_once 'footer.php';
?>