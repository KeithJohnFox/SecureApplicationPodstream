<?php
    class Account {

        private $con;
        private $errorArray;
        

        //VALADIATE FUNCTIONS (Contructor)
        public function __construct($con){
            $this->con = $con;
            $this->errorArray = array();
        }

        public function login($un, $pw){
            $pw = hash("sha512", $pw);

            $stmt = mysqli_prepare($this->con, "SELECT * FROM users WHERE username=? and password = ?");
            $stmt->bind_param("ss", $un, $pw);
           
            $stmt->execute();
            $result = $stmt->get_result();

            if(mysqli_num_rows($result) == 1) {
                return true;
            }
            else {
                //if login failed we push out an error array of the constant class fail message
                echo "Failed";
                array_push($this->errorArray, Constants::$loginFailed);
                return;
            }
        }

        //Validation and Sanitization
        // variables set to null due to error 
        public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
            //call inputs to validate functions
            $this->validateUsername($un);
            $this->validateFirstName($fn);
            $this->validateLastName($ln);
            $this->validateEmails($em, $em2);
            $this->validatePasswords($pw, $pw2);

            if(empty($this->errorArray) == true){
                //Insert into DataBase
                return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
            }
            else{
                return false;
                
            }
        }

        //Function to output the error message to the user if user details is unsuccessful
        public function getError($error) {
            
            if(!in_array($error, $this->errorArray)){           //This checks to see if the $error paramater exists in the errorArray
               $error = "";                                     //if it doesnt find a msg in error array it will set error paramater to empty string
            }                                                   //TIP** if you want to use quotes in quotes you need to use single quotes ' ' because using "" will end the previous ""
            return "<span class='errorMessage'>$error</span>";  //Outputs an error message        
        }


        //here we insert user details into the database
        //SECURITY to Hash password using sha512 algorithm  
        public function insertUserDetails($un, $fn, $ln, $em, $pw) {
            

            $pw = hash("sha512", $pw);
            $date = date("Y-m-d");
            $profilePic = "assets/images/profilePictures/default.png";
            
            $result = $this->con->prepare("INSERT INTO users (username, firstName, lastName, email, password, signUpDate, profilePic) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
            $result->bind_param("sssssss", $un, $fn, $ln, $em, $pw, $date, $profilePic);

            
            
            return $result->execute();
        }


        private function validateUsername($un){
            if(strlen($un) > 25 || strlen($un) < 5){
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }

            $stmt = mysqli_prepare($this->con, "SELECT username FROM users WHERE username=?");
            $stmt->bind_param("s", $un);
           
            $stmt->execute();
            $result = $stmt->get_result();

            if(mysqli_num_rows($result) != 0) {
                array_push($this->errorArray, Constants::$usernameTaken);
            }
        }


        //Validates First & last Name
        private function validateFirstName($fn){ 
            if(strlen($fn) > 25 || strlen($fn) < 2){
                array_push($this->errorArray, Constants::$firstNameCharacters);
                return;
            }
        }

        private function validateLastName($ln){
            if(strlen($ln) > 25 || strlen($ln) < 2){
                array_push($this->errorArray, Constants::$lastNameCharacters);
                return;
            }    
        }

        private function validateEmails($em, $em2){
            if($em != $em2){
                array_push($this->errorArray, Constants::$emailsDoNotMatch);
                return;
            }
            
            //Checks the email is valid with a .com at the end
            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }

            //Checks if email is already taken
            $checkEmailQuery = mysqli_prepare($this->con, "SELECT email FROM users WHERE email= ?");
            $checkEmailQuery->bind_param("s", $em);
           
            $checkEmailQuery->execute();
            $result = $checkEmailQuery->get_result();

            if(mysqli_num_rows($result) != 0) {
                array_push($this->errorArray, Constants::$emailTaken);
            }
        }

        
        //Validates password
        private function validatePasswords($pw, $pw2){
           if($pw != $pw2){
                array_push($this->errorArray, Constants::$passwordsDoNotMatch);
                return;    
           } 

            if(preg_match('/[^A-Za-z0-9]/', $pw)){
                array_push($this->errorArray, Constants::$passwordsNotAlphanumeric);
                return; 
            } 
            
            if(strlen($pw) > 128 || strlen($pw) < 9){
                array_push($this->errorArray, Constants::$passwordsCharacters);
                return;
            }   
        }
    
    } 
?>