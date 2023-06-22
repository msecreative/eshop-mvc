<?php 
    class Contact_us extends Controller
    {
        public function index() {

            $user = $this->load_model("User");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            if (count($_POST) > 0) {
                $data["POST"] = $_POST;
                show($_POST); 
            }

            $db = Database::newInstance();

            $data["page_title"] = "Contact";
            $this ->view("contact", $data);
        }
    }
    
?>