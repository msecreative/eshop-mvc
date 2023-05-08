<?php 
    class Admin extends Controller
    {
        public function index() {
            $user = $this->load_model("User");
            $user_data = $user->check_login(true, ["admin"]);

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $data["page_title"] = "Admin";
            $this ->view("admin/index", $data);
        }
        // Categories Method
        public function categories() {
            $user = $this->load_model("User");
            $user_data = $user->check_login(true, ["admin"]);

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            // Show category all data after refreshing page
            $db = Database::newInstance();
            $allCategories = $db->read("SELECT * FROM categories ORDER BY catId DESC");

            $category = $this->load_model("Category");
            $table_rows =  $category->make_table($allCategories);

            if (is_array($allCategories)) {
                $data["table_rows"] = $table_rows;
            }

            $data["page_title"] = "Categories";
            $this ->view("admin/categories", $data);
        }
    }
    
?>