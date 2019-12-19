<?php
require_once("includes/config.php"); 
$account = new Account($con);

//SANITIZATION FUNCTIONS
//Sanitize Passwords
function sanitizeFormPassword($inputText) {
    $inputText = strip_tags($inputText); //Strips HTML & PHP tags
    $inputText = preg_replace('/[^\p{L}\p{N}\s]/u', '', $inputText); //Replace these symbols with nothing
    $inputText = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $inputText); //Replace javascript tags and symbols with nothing
    return $inputText;
}

//Sanitize Username
function sanitizeFormUsername($inputText) {
    $inputText = strip_tags($inputText); //Strips HTML & PHP tags
    $inputText = preg_replace('/[^\p{L}\p{N}\s]/u', '', $inputText); //Replace these symbols with nothing
    $inputText = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $inputText); //Replace javascript tags and symbols with nothing
    $inputText = str_replace(" ", "", $inputText); //Replace space with no space
    return $inputText;
}

//Sanitize Strings (Firstname, Lastname)
function sanitizeFormString($inputText) {
    $inputText = strip_tags($inputText); //Strips HTML & PHP tags
    $inputText = preg_replace('/[^\p{L}\p{N}\s]/u', '', $inputText); //Replace these symbols with nothing
    $inputText = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $inputText); //Replace javascript tags and symbols with nothing
    $inputText = str_replace(" ", "", $inputText); //Replace space with no space
    $inputText = ucfirst(strtolower($inputText)); //Turn capitals to lower
    return $inputText;
}

//Email Sanitization
//validateEmails() Function in Account.class has FILTER_VALIDATE_EMAIL
function sanitizeFormEmail($inputText) {
    $inputText = strip_tags($inputText); //Strips HTML & PHP tags
    $inputText = str_replace(" ", "", $inputText); //Replace space with no space
    $inputText = ucfirst(strtolower($inputText)); //Turn capitals to lower
    return $inputText;
}


//Register button was pressed
if(isset($_POST['registerButton'])){
    //Sends inputs to Santization Functions
    $username = sanitizeFormUsername($_POST['username']);
    $firstName = sanitizeFormString($_POST['firstName']);
    $lastName = sanitizeFormString($_POST['lastName']);
    $email = sanitizeFormEmail($_POST['email']);
    $email2 = sanitizeFormEmail($_POST['email2']);
    $password = sanitizeFormPassword($_POST['password']);
    $password2 = sanitizeFormPassword($_POST['password2']);

    //Sanitized variables sent to account file 
    $wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);
    
    //Here we created a Session variable called userLoggedIn and it stores username
    //To use SESSION it needs to be declared, it is declared in config file
    if($wasSuccessful == true) {
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
        echo "Success";
    }
}

?>
