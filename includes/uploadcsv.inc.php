<?php

require_once 'functions.inc.php';

session_start();

// Example code from https://www.w3schools.com/php/php_file_upload.asp

$target_dir = "../csv/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
$check = true; //fgetcsv($_FILES["fileToUpload"]["tmp_name"]);
if($check !== false) {
    $uploadmsg = "The file is a csv format - " . $check["mime"];
} else {
    $_SESSION["uploadmsg"] = "Sorry, your file has not been uploaded because it is not a CSV file.";
    header("location: ../admin.php");
    exit();
}
}

// Allow certain file formats
if($imageFileType != "csv") {
    $_SESSION["uploadmsg"] = "Sorry, your file has not been uploaded because only CSV files are allowed.";
    header("location: ../admin.php");
    exit();
}

// Upload the file if the format is the correct.
$file_size = $_FILES["fileToUpload"]["size"];
$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
$uploadmsg = uploadFile($target_file, $file_size, $tmp_name);
$_SESSION["uploadmsg"] = $uploadmsg;
header("location: ../admin.php");
exit();
