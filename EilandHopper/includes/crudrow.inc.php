<?php

session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

print_r($_POST);
//stop;

$tablename = $_SESSION["tablename"];
$row = $_POST["row"];

if (isset($_POST["delete"])) {
    deleteRow($conn, $tablename, $row);
} elseif (isset($_POST["update"]))  {
    updateRow($conn, $tablename, $row);
} elseif (isset($_POST["insert"]))  {
    insertRow($conn, $tablename, $row);
}
$rows = getTable($conn, $tablename);
$_SESSION["table"] = $rows;

header("location: ../admin.php");
exit();
