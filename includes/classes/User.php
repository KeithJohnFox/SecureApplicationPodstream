<?php
class User {

    private $con;
    private $username;

    //VALADIATE FUNCTIONS (Contructor)
    public function __construct($con, $username){
        $this->con = $con;
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    //For Update Details
    public function getEmail() {
        $usern = $this->username;
        //PrepareStatment
        $query = mysqli_prepare($this->con, "SELECT email FROM users WHERE username= ?");
        $query->bind_param("s", $usern);
        $query->execute();
        $result = $query->get_result();

        $row = mysqli_fetch_array($result);
        return $row['email'];
    }

    public function getFirstAndLastName() {
        //Binding
        //take in username into usern
        $usern = $this->username;
        //PrepareStatment
        $query = mysqli_prepare($this->con, "SELECT concat(firstName, ' ', lastName) as 'name' FROM users WHERE username= ?");
        $query->bind_param("s", $usern);
        $query->execute();
        $result = $query->get_result();
        $row = mysqli_fetch_array($result);
        return $row['name'];
    }
} 
?>
