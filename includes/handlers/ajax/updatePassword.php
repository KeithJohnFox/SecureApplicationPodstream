<?php

include("../../config.php");

if(!isset($_POST['username'])) {
    echo "ERROR: Could not set username";
    exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Not all passwords have been set";
    exit();
}

if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
    echo "Please fill in all fields";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

//SANITIZATION
//Username sanitization
$username = strip_tags($username); //Strips HTML & PHP tags
$username = preg_replace('/[^\p{L}\p{N}\s]/u', '', $username); //Replace these symbols with nothing
$username = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $username); //Replace javascript tags and symbols with nothing

//oldPassword sanitization
$oldPassword = strip_tags($oldPassword); //Strips HTML & PHP tags
$oldPassword = preg_replace('/[^\p{L}\p{N}\s]/u', '', $oldPassword); //Replace these symbols with nothing
$oldPassword = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $oldPassword); //Replace javascript tags and symbols with nothing

//oldPassword sanitization
$oldPassword = strip_tags($oldPassword); //Strips HTML & PHP tags
$oldPassword = preg_replace('/[^\p{L}\p{N}\s]/u', '', $oldPassword); //Replace these symbols with nothing
$oldPassword = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $oldPassword); //Replace javascript tags and symbols with nothing


//Hashing original password 
$oldpw = hash("sha512", $oldPassword);

$passwordCheck = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$oldpw'");
if(mysqli_num_rows($passwordCheck) != 1 ) {
    echo "Password is incorrect";
    exit();
}

if($newPassword1 != $newPassword2) {
    echo "Your new Passwords do not match";
    exit();
}

if(preg_match('/[^A-Za-z0-9]/', $newPassword1)) {
    echo "Your password must only contain letters and/or numbers";
    exit();
}

if(strlen($newPassword1) > 128 || strlen($newPassword1) < 9) {
    echo "Your username must be between 9 and 128 characters";
    exit();
}

//Hash new password
$newpw = hash("sha512", $newPassword1);

//Updating new Password
$query = mysqli_query($con, "UPDATE users SET password = '$newpw' WHERE username='$username'");
echo "Update successful";

?>
