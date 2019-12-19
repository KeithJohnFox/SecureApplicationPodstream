<?php

//If user clicks login button run code
if(isset($_POST['loginButton'])){
    //Login button was pressed
    $username = $_POST['loginUsername'];    //Login username is the name made on the html input tag in register page
    $password = $_POST['loginPassword']; 
    
    //Username Sanitization
    $username = strip_tags($username); //Strips HTML & PHP tags
    $username = preg_replace('/[^\p{L}\p{N}\s]/u', '', $username); //Replace these symbols with nothing
    $username = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $username); //Replace javascript tags and symbols with nothing

    //Password Sanitization
    $password = strip_tags($password); //Strips HTML & PHP tags
    $password = preg_replace('/[^\p{L}\p{N}\s]/u', '', $password); //Replace these symbols with nothing
    $password = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $password); //Replace javascript tags and symbols with nothing
    
    //Login Function called login
    $result = $account->login($username, $password);

    //If the login was successful this code directs the user to the index page
    if($result == true){
        //Here we created a Session variable called userLoggedIn and it stores username
        //To use SESSION it needs to be declared, it is declared in config file
        $_SESSION['userLoggedIn'] = $username;
        //Login Successful direct user to main index page
        header("Location: index.php");
    }
}
?>