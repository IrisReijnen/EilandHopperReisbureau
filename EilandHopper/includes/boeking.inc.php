<?php
session_start();

$i = $_GET["i"];
$reis = $_SESSION["results"][$i];
$reisid = $reis["reisId"];
$terms = $_GET["terms"];
$vertrekDatum = $_GET["datum"];
$aantalPersonen = $_GET["personen"];

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

//echo $reisid;
//stop;
if (!$terms){
    header("location: ../boeking.php?error=noterms&i=$i");
    exit();
} else {
    boeken($conn, $_SESSION["userid"], $reisid, $vertrekDatum, $aantalPersonen);
}