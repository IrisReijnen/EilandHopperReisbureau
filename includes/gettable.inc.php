<?php


session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST["tablename"])){
    $tablename = $_POST["tablename"];
    $rows = getTable($conn, $_POST["tablename"]);
} elseif (isset($_POST["geannuleerd"])){
    $tablename = "geannuleerd";
    $rows = getRows($conn, $_POST["geannuleerd"], "boekingGeannuleerd", 1);
}

$_SESSION["tablename"] = $tablename;
$_SESSION["table"] = $rows;

header("location: ../admin.php");
exit();
