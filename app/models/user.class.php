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
            $arr['email'] = $data['email'];
            $emailchk = $db->read($sql, $arr);
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
            $data["url_address"] = $this->get_random_string_max(60);
            $sql = "SELECT * FROM users WHERE url_address = :url_address limit 1";
            $arr_url["url_address"] = $data["url_address"];
            $check = $db->read($sql, $arr_url);
            if (is_array($check)) {
                $data["url_address"] = $this->get_random_string_max(60);
            }

            if (empty($this->error)) {
                $data["rank"] = "customer";
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

            $data = array();
            $db = Database::getInstance();
            $data["email"]      = trim($_POST['email']);
            $data["password"]   = trim($_POST['password']);

            
            if (empty($data["email"]) || !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
                
                $this->error .= "Please enter a valid email. <br>";
            }

            if (strlen($data["password"]) < 6 ) {
                $this->error .= "Password must be atleast 6 characters long. <br>";
            }
            
            

            if (empty($this->error)) {
                $data["password"] = hash('sha1', $data["password"]);

                //read data from database
                $sql = "SELECT * FROM users WHERE email = :email && password = :password limit 1";
                $result = $db->read($sql, $data);
                if (is_array($result)) {
                    $_SESSION["user_url"] = $result[0]->url_address;
                    header("Location:" .ROOT . "home");
                    die;
                }
                $this->error .= "Email or Password doesn't match. <br>";

            }

            $_SESSION['error'] = $this->error;

        }

        public function get_user($url){
            
            $db = Database::newInstance();

            $get_arr["url_address"] = addslashes($url);
            $sql = "SELECT * FROM users WHERE url_address = :url_address LIMIT 1";
            $result = $db->read($sql, $get_arr);
            if (is_array($result)) {
                return $result[0];
            }
            return false;
        }

        public function get_customers(){
            
            $db = Database::newInstance();

            $customer_arr["rank"] = "customer";
            $sql = "SELECT * FROM users WHERE `rank` = :rank";
            $result = $db->read($sql, $customer_arr);
            if (is_array($result)) {
                return $result;
            }
            return false;
        }

        public function get_admins(){
            
            $db = Database::newInstance();

            $admin_arr["rank"] = "admin";
            $sql = "SELECT * FROM users WHERE `rank` = :rank";
            $result = $db->read($sql, $admin_arr);
            if (is_array($result)) {
                return $result;
            }
            return false;
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

        function check_login($redirect = false, $allowed = array()){

            $db = Database::getInstance();

            if (count($allowed) > 0 ) {

            $url_arr["url_address"] = $_SESSION["user_url"];
            $sql = "SELECT * FROM users WHERE url_address =:url_address LIMIT 1";
            $result = $db->read($sql,$url_arr);
                if (is_array($result)) {

                    $result = $result[0];
                    if (in_array($result->rank, $allowed)) {

                        return $result;
                    }
                }  //if (is_array($result)) {
                    header("Location:" .ROOT . "login");
                    die;
                
            }else{ //if (count($allowed) > 0 ) {
                
                if (isset($_SESSION["user_url"])) {

                    $arr["url_address"] = $_SESSION["user_url"];
                    $sql = "SELECT * FROM users WHERE url_address = :url_address LIMIT 1";
                    $result = $db->read($sql, $arr);
                    if (is_array($result)) {
                        return $result[0];
                    }

                }
                if ($redirect) {
                    header("Location:" .ROOT . "login");
                    die;
                }
            } //end //if (count($allowed) > 0 ) {
            return false;
        }

        public function logout(){
            if (isset($_SESSION["user_url"])) {
                unset($_SESSION["user_url"]);
            }
            header("Location:" .ROOT . "home");
            die;
        }

    }
?>