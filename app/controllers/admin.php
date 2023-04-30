<?php 
    class Admin extends Controller
    {
        public function index() {
            $user = $this->load_model("User");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $data["page_title"] = "Admin";
            $this ->view("admin/index", $data);
        }
    }
    
?>