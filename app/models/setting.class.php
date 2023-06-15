<?php 
    class Setting{
        
        private $error = "";

        public function get_all(){
            
            $db = Database::newInstance();
            $sql = "SELECT * FROM settings";
            return $db->read($sql);
        }

       

    }
?>