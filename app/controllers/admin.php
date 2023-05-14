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

            $data["table_rows"] = $table_rows;

            $data["page_title"] = "Categories";
            $this ->view("admin/categories", $data);
        }

        // Products Method
        public function products() {
            $user = $this->load_model("User");
            $user_data = $user->check_login(true, ["admin"]);

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            // Show Product all data after refreshing page
            $db = Database::newInstance();
            $allProducts = $db->read("SELECT * FROM products ORDER BY pId DESC");
            // For display add product
            $db = Database::newInstance();
            $allcategories = $db->read("SELECT * FROM categories WHERE `disabled` = 1 ORDER BY catId DESC");

            $product = $this->load_model("Product");
            $table_rows =  $product->make_table($allProducts);

            $data["table_rows"] = $table_rows;
            $data["allcategories"] = $allcategories;

            $data["page_title"] = "Products";
            $this ->view("admin/products", $data);
        }

    }
    
?>