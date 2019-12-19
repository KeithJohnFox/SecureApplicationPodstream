<?php
    class Playlist {

        private $con;
        private $id;
        private $name;
        private $owner;

        //VALADIATE FUNCTIONS (Contructor)
        public function __construct($con, $data){
          
            if(!is_array($data)) {
                //data is an id (string)
                $query = mysqli_query($con, "SELECT * FROM playlists WHERE id='$data'");
                $data = mysqli_fetch_array($query);
            }

            $this->con = $con;
            $this->id = $data['id'];
            $this->name = $data['name'];
            $this->owner = $data['owner'];
        }

        public function getName() {
            return $this->name;
        }

        public function getOwner() {
            return $this->owner;
        }

        public function getId() {
            return $this->id;
        }

        public function getNumberOfSongs() {
            $uid = $this->id;

            //PrepareStatment
            $query = mysqli_prepare($this->con, "SELECT songId FROM playlistSongs WHERE playlistId= ?");
            $query->bind_param("s", $uid);
            $query->execute();
            $result = $query->get_result();
            return mysqli_num_rows($result); 
        }

        public function getSongIds() {
            $uid = $this->id;

            //PrepareStatment
            $query = mysqli_prepare($this->con, "SELECT songId FROM playlistSongs WHERE playlistId= ? ORDER BY playlistOrder ASC");
            $query->bind_param("s", $uid);
            $query->execute();
            $result = $query->get_result();
            $array = array();

            while($row = mysqli_fetch_array($result)) {
                array_push($array, $row['songId']);
            }
            return $array;
        }

        public static function getPlaylistsDropdown($con, $username) {


            $dropdown = '<select class="item playlist">
                        <option value="">Add to playlist</option>';


            
            $query = mysqli_prepare($con, "SELECT id, name FROM playlists WHERE owner= ?");
            $query->bind_param("s", $username);
            $query->execute();
            $result = $query->get_result();
            

            while($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $name = $row['name'];

                $dropdown = $dropdown . "<option value='$id'>$name</option>";
            }
                        
            return $dropdown . "</select>";

        }

    } 
?>
