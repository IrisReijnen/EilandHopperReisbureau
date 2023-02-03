<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_GET["add"])) {
    $userid = $_SESSION["userid"];
    $message = $_GET["message"];
    $i = $_GET["add"];
    $reis = $_SESSION["results"][$i];
    $reisid = $reis["reisId"];

    addReferentie($conn, $userid, $reisid, $message);
}

header("location: ../referentie.php?i=$i");
exit();