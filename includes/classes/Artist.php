<?php
    class Artist {
        //private modifiers 
        private $con;
        private $id;
        

        //VALADIATE FUNCTIONS (Contructor)
        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;
        }

        public function getId() {
            return $this->id;
        }

        //Displays Name in podcast listing
        public function getName() {
            //Prepare Statement
            $uid = $this->id;
            $query = mysqli_prepare($this->con, "SELECT name FROM artists WHERE id= ?");
            $query->bind_param("s", $uid);
            $query->execute();
            $result = $query->get_result();
            $artist = mysqli_fetch_array($result);         
            return $artist['name'];  

        }
        
        public function getSongIds() {
            //Prepare Statement
            $uid = $this->id;
            $query = mysqli_prepare($this->con, "SELECT id FROM songs WHERE album= ? ORDER BY plays DESC");
            $query->bind_param("s", $uid);
            $query->execute();
            $result = $query->get_result();
            $array = array();

            while($row = mysqli_fetch_array($result)) {
                array_push($array, $row['id']);
            }
            return $array;

        }
    } 
?>