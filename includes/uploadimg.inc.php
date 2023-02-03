<?php

require_once 'functions.inc.php';

session_start();

// Example code from https://www.w3schools.com/php/php_file_upload.asp

$target_dir = "../img/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if($check !== false) {
    $uploadmsg = "The file is an image - " . $check["mime"];
} else {
    $_SESSION["uploadmsg"] = "Sorry, your file has not been uploaded because it is not an image.";
    header("location: ../admin.php");
    exit();
}
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $_SESSION["uploadmsg"] = "Sorry, your file has not been uploaded because only JPG, JPEG, PNG & GIF files are allowed.";
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
