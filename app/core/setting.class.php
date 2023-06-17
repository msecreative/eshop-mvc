<?php 
    trait Setting{
        
        private $error = array();
        //protected $settingsObj = null;

        public function get_all_settings(){
            
            $db = Database::newInstance();
            $sql = "SELECT * FROM settings";
            return $db->read($sql);
        }

        public function get_all_settings_as_object(){
            
            $db = Database::newInstance();
            $sql = "SELECT * FROM settings";
            $data = $db->read($sql);

            $settingsObj = (object)[];
            if (is_array($data)) {
              
                foreach ($data as $settingsRow) {
                    $setting_name = $settingsRow->setting;
                    $settingsObj->$setting_name = $settingsRow->value;
                }
            }
            return $settingsObj;
        }

        public function save_settings($post){
            
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