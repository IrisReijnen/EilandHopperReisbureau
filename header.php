<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Reisbureau</title>
    <!--From https://jqueryui.com/dialog/ -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
</head>
<body>

    <nav>
        <div class="wrapper">
            <ul>
                <li><img src="img/EilandHopperLogo.png" height="50px" alt="EilandHopper"></li>
                <li><a href="index.php">Home</a></li>
                <li><a href="over-ons.php">Over ons</a></li>
                <li><a href="info-over-locaties.php">Informatie over locaties</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php
                    if (isset($_SESSION["useruid"])) {
                        //echo $_SESSION["useruid"];
                        //stop;
                        if ($_SESSION["useruid"]==="admin") {
                            echo "<li class='floatright'><a href='includes/logout.inc.php'>Log out</a></li>";
                            echo "<li class='floatright'><a href='admin.php'>Admin</a></li>";
                        }
                        else {
                            echo "<li class='floatright'><a href='includes/logout.inc.php'>Log out</a></li>";
                            echo "<li class='floatright'><a href='profile.php'>Profile</a></li>";
                        }
                    }
                    else {
                        echo "<li class='floatright'><a href='login.php'>Login</a></li>";
                        echo "<li class='floatright'><a href='signup.php'>Sign up</a></li>";
                    }
                ?>
            </ul>
        </div>
    </nav>
    
    <div class="wrapper">