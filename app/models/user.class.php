<?php 
    class User{
        
        private $error = "";

        public function signup($post){
            $data               = array();
            $db = Database::getInstance();
            $data["name"]       = trim($_POST['name']);
            $data["email"]      = trim($_POST['email']);
            $data["password"]   = trim($_POST['password']);
            $password2          = trim($_POST['password2']);

            
            if (empty($data["email"]) || !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                
                $this->error .= "Please enter a valid email. <br>";
            }

            //Check email if already exist
            $sql = "SELECT * FROM users WHERE email = :email limit 1";
            //$arr['email'] = $data['email'];
            $emailchk = $db->read($sql, array("email" => $data["email"]));
            if (is_array($emailchk)) {
                $this->error .= "That email is already used. <br>";
            }

            if (empty($data["name"]) || !preg_match("/^[a-zA-Z]+$/", $data["name"])) {

                $this->error .= "Please enter a valid name. <br>";
            }

            if ($data["password"] !== $password2) {
                $this->error .= "Password don't match. <br>";
            }

            if (strlen($data["password"]) < 6 ) {
                $this->error .= "Password must be atleast 6 characters long. <br>";
            }

            if (empty($this->error)) {
                $data["rank"] = "customer";
                $data["url_address"] = $this->get_random_string_max(60);
                $data["date"] = date("Y-m-d H:i:s");
                $data["password"] = hash('sha1', $data["password"]);

                $query = "insert into users (url_address,name,email,password,`rank`,date)values(:url_address,:name,:email,:password,:rank,:date)";
                $result = $db->write($query,$data);

                if ($result) {
                   header("Location:" .ROOT . "login");
                   die;
                }
            }

            $_SESSION['error'] = $this->error;

        }

        public function login($post){

        }

        public function get_user($url){

        }

        private function get_random_string_max($length){
            $array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','x','A','B','C','D','E','F','G','H','I','J','L','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            
            $text = "";
             $length = rand(4,$length);

             for ($i=0; $i < $length; $i++) { 
                $random = rand(0,61);

                $text .= $array[$random];
             }

             return $text;
        }
    }
?>