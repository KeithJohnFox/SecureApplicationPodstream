<?php
    //Creation of our Session, we Store userLoggedin within Session to insure access to website is from a signed up account  
    ob_start();
    session_start(); //This enables the use of SESSIONS

    //Standard European Time set
    $timezone = date_default_timezone_set("Europe/London");

    //Connection to database into var con
    $con = mysqli_connect("localhost", "root", "", "musicapp",);

    //Connection failed error message
    if(mysqli_connect_errno()){
        echo "Failed to connect: " . mysqli_connect_errno();    
    }

    
    //Creation of our Session, we Store userLoggedin within Session to insure access to website is from a signed up account  
    // ob_start();
    // session_start(); //This enables the use of SESSIONS

    // //Standard European Time set
    // $timezone = date_default_timezone_set("Europe/London");

    // //Connection to database into var con
    // $con = mysqli_connect("localhost", "root", "", "musicapp",);
    // //using real_escape_string to escape characters that could change the nature of the SQL command
    // $username = mysqli_real_escape_string($con, $_POST['username']);
    // $password = mysqli_real_escape_string($con, $_POST['password']);
    // // $sql_command = "select * from users where username = '" . $username; sql_command .= "' AND password = '" . $password . "'";

    // //Connection failed error message
    // if(mysqli_connect_errno()){
    //     echo "Failed to connect: " . mysqli_connect_errno();    
    // }


?>