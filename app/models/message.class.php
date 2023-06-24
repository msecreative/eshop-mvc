<?php
    class Message {

        protected $error = array();

        public function create($DATA){

            $this->error = array();

            $db = Database::newInstance();
            $arr['name']      = ucwords($DATA["name"]);
            $arr['email']     = $DATA["email"];
            $arr['subject']   = ucwords($DATA["subject"]);
            $arr['message']   = ucwords($DATA["message"]);
            $arr['date']      = date("Y-m-d H:i:s");

            if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['name']))) {
                $this->error[] = "Only letter and spacess are allowed";
            }
            if (empty($arr['email']) || !filter_var($arr['email'], FILTER_VALIDATE_EMAIL)) {
                $this->error[] = "Please enter a valid emails";
            }
            if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['subject']))) {
                $this->error[] = "Please enter a valid subject";
            }
            if (empty($arr['message'])) {
                $this->error[] = "Please enter a valid message";
            }

            if (count($this->error) == 0) {
            
                $sql = "INSERT INTO contact_us (`name`,`email`,`subject`,`message`,`date`) VALUES (:name,:email,:subject,:message,:date)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return $this->error;
        } 

        public function delete($contactId){

            $db = Database::newInstance();
            $contactId = (int)$contactId;
            $sql = "DELETE FROM contact_us WHERE contactId = '$contactId' LIMIT 1";
            $db->write($sql);

        } 
        // Get All Category
        public function get_all(){
            $db = Database::newInstance();
            return $db->read("SELECT * FROM contact_us ORDER BY contactId DESC");
        }

        // Get single category
        public function get_one($contactId){
            $contactId = (int)$contactId;
            $db = Database::newInstance();
            $data =  $db->read("SELECT * FROM contact_us WHERE contactId = '$contactId' LIMIT 1 ");
            return $data[0];
        }

    }

