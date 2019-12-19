<?php
    class Song {

        private $con;
        private $id;
        private $mysqliData;
        private $title;
        private $artistId;
        private $albumId;
        private $genre; 
        private $duration;
        private $path;
       

        //VALADIATE FUNCTIONS (Contructor)
        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;

            
            $uid = $this->id;
            $query = mysqli_prepare($this->con, "SELECT * FROM songs WHERE id= ?");
            $query->bind_param("s", $uid);
            $query->execute();
            $result = $query->get_result();

            
            $this->mysqliData = mysqli_fetch_array($result);
            $this->title = $this->mysqliData['title'];
            $this->artistId = $this->mysqliData['artist'];
            $this->albumId = $this->mysqliData['album'];
            $this->duration = $this->mysqliData['duration'];
            $this->path = $this->mysqliData['path'];     
   
        }

        public function getTitle() {
            return $this->title;
        }

        public function getId() {
            return $this->id;
        }

        public function getArtist() {
            return new Artist($this->con, $this->artistId);
        }

        public function getAlbum() {
            return new Album($this->con, $this->albumId);
        }

        public function getPath() {
            return $this->path;
        }

        public function getDuration() {
            return $this->duration;
        }

        public function getMysqliData() {
            return $this->mysqliData;
        }

        public function getGenre() {
            return $this->genre;
        }

    } 
?>