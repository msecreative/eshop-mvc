<?php 
    class Settings{
        
        private $error = array();
        protected static $settings_Obj = null;

        public function get_all_settings(){
            
            $db = Database::newInstance();
            $sql = "SELECT * FROM settings";
            return $db->read($sql);
        }

        static function  __callStatic($name, $params)
        {
            if (self::$settings_Obj) {

                $settings = self::$settings_Obj;

            }else{

                $settings = self::get_all_settings_as_object();
            }

            if (isset($settings->$name)) {
                
                return $settings->$name;
            }
            return "";
        }
        public static function get_all_settings_as_object(){
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
            self::$settings_Obj = $settingsObj;

            return $settingsObj;
        }

        public function save_settings($post){
            
            $this->error = array();
            $db = Database::newInstance();

            foreach ($post as $key => $value) {
                
                $arr = array();
                $arr["setting"] = $key;

                if ( strstr($key, "_link") ) {
                    if  (trim($value) != "" && !strstr($value, "https://")) {
                        $value = "https://" . $value;
                    }
                }
                $arr["value"]   = $value;
                $sql = "UPDATE settings SET `value` = :value WHERE setting = :setting LIMIT 1";
                $db->write($sql,$arr);
                $this->error[] = "Something went wrong!";
            }

            return $this->error;
           

        }
    }


?>