<?php 
    class Home extends Controller
    {
        public function index() {
            $user = $this->load_model("User");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $db = Database::newInstance();
            $product_rows = $db->read("SELECT * FROM products");

            $data["page_title"] = "Home";
            $data["product_rows"] = $product_rows;
            $this ->view("index", $data);
        }
    }
    
?>