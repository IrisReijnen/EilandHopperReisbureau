<?php
session_start();

$stad = $_POST["stad"];
$activiteit = $_POST["activiteit"];
$minprijs = $_POST["minPrijs"];
$maxprijs = $_POST["maxPrijs"];
$duur = $_POST["duur"];

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

print "Printing...\n";
print "Searching..." . " stad " . $stad . " , activiteit " . $activiteit . " , minPrijs " . $minprijs. " , maxPrijs " . $maxprijs . " , duur " . $duur . "\n";
echo "From JSlider" . $minprijs .  $maxprijs;

$rows = searchReis($conn, $stad, $activiteit, $minprijs, $maxprijs, $duur);
// By using mysqli_fetch_all we will always get an array of rows, even if there is only 1 result: [[stad, land, ...]]
// If a single result would be [stad, land, ...] the first element would not be an array, which can be used to check
// reset($rows) (or $rows[0]?) takes first array element, which could be used to check if 1- or 2-dimensional array
//if (is_array(reset($rows)))   // true would mean that $rows is an array of rows, and false that it is a single row
//$numrows = count($rows);
//print "Found $numrows rows.";

if ($rows === false) {
    header("location: ../index.php?zoeken=false");
    exit();
}
if (is_array($rows)) {
    session_start();
    $_SESSION["results"] = $rows;
    header("location: ../index.php?zoeken=true");
    exit();
}