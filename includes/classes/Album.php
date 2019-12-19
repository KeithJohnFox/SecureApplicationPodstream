<?php
    class Album {

        private $con;
        private $id;
        private $title;
        private $artistId;
        private $genre;
        private $artworkPath;
        
        

        //VALADIATE FUNCTIONS (Contructor)
        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;
            
            $uid = $this->id;

            $query = mysqli_prepare($this->con, "SELECT * FROM albums WHERE id= ?");
            $query->bind_param("s", $uid);
            $query->execute();
            $result = $query->get_result();
            $album = mysqli_fetch_array($result);

            
            $this->title = $album['title'];
            $this->artistId = $album['artist'];
            $this->genre = $album['genre'];
            $this->artworkPath = $album['artworkPath'];

        }

        public function getTitle() {
                    
            return $this->title;   

        }

        public function getArtworkPath() {
            return $this->artworkPath;  

        }

        public function getArtist() {
            return new Artist($this->con, $this->artistId);  

        }

        public function getGenre() {
            return $this->genre;  

        }

        public function getNumberOfSongs() {
            $uid = $this->id;
            //PrepareStatment
            $query = mysqli_prepare($this->con, "SELECT id FROM songs WHERE album= ?");
            $query->bind_param("s", $uid);
            $query->execute();
            $result = $query->get_result();
            return mysqli_num_rows($result); 
        }

        public function getSongIds() {
            $uid = $this->id;
            //PrepareStatment
            $query = mysqli_prepare($this->con, "SELECT id FROM songs WHERE album= ? ORDER BY albumOrder ASC");
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