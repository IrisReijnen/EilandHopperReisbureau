<?php
session_start();

$boekingId = $_POST["id"];

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

annuleren($conn, $boekingId);