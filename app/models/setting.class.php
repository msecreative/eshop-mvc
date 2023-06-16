<?php 
    class Setting{
        
        private $error = array();

        public function get_all(){
            
            $db = Database::newInstance();
            $sql = "SELECT * FROM settings";
            return $db->read($sql);
        }

        public function save($post){
            
            $this->error = array();
            $db = Database::newInstance();

            foreach ($post as $key => $value) {
                
                $arr = array();
                $arr["setting"] = $key;
                $arr["value"]   = $value;
                $sql = "UPDATE settings SET `value` = :value WHERE setting = :setting LIMIT 1";
                $db->write($sql,$arr);
                $this->error[] = "Something went wrong!";
            }

            return $this->error;
           

        }

       

    }
?>