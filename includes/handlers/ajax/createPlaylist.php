<?php
include("../../config.php");

if(isset($_POST['name']) && isset($_POST['username'])) {
    
    $name = $_POST['name'];
    //Playlist Name Sanitization
    $name = strip_tags($name); //Strips HTML & PHP tags
    $name = preg_replace('/[^\p{L}\p{N}\s]/u', '', $name); //Replace these symbols with nothing
    $name = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $name); //Replace javascript tags and symbols with nothing

    if(strlen($name) > 50 || strlen($name) < 1) {
        echo "Your Playlist needs to be under 50 characters";
        exit();
    }
        $username = $_POST['username'];
        $date = date("Y-m-d");

        $query = mysqli_query($con, "INSERT INTO playlists VALUES('', '$name', '$username', '$date')");    
}
else {
    echo "Name or username parameters not passed into file";
}
?>