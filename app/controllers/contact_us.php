<?php 
    class Contact_us extends Controller
    {
        public function index() {

            $user = $this->load_model("User");
            $Message = $this->load_model("Message");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $data["errors"] = array();

            if (count($_POST) > 0) {
                $data["POST"] = $_POST;
                //show($_POST);
                 
                $data["errors"] = $Message->create($_POST);
                if (!is_array($data["errors"]) && $data["errors"]) {
                    redirect("contact_us?success=true");
                }
            }

            $db = Database::newInstance();

            $data["page_title"] = "Contact-Us";
            $this ->view("contact", $data);
        }
    }
    
?>