<?php 
    class Admin extends Controller
    {
        use Setting;

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
            $forSubCategories = $db->read("SELECT * FROM categories WHERE `disabled` = 1 ORDER BY catId DESC");

            $category = $this->load_model("Category");
            $table_rows =  $category->make_table($allCategories);

            $data["table_rows"] = $table_rows;
            $data["forSubCategories"] = $forSubCategories;

            $data["page_title"] = "Admin - Categories";
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
            $category = $this->load_model("Category");
            $table_rows =  $product->make_table($allProducts,$category);

            $data["table_rows"] = $table_rows;
            $data["allcategories"] = $allcategories;

            $data["page_title"] = "Admin - Products";
            $this ->view("admin/products", $data);
        }

        public function orders(){

            $user = $this->load_model("User");
            $order = $this->load_model("Order");
            $user_data = $user->check_login(true, ["admin"]);

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $orders = $order->get_all_orders();

            if (is_array($orders)) {

                foreach ($orders as $key => $order_row) {

                    $details = $order->get_all_orders_details($order_row->orderId);
                    $orders[$key]->details = $details;

                    $user_name = $user->get_user($order_row->user_url);
                    $orders[$key]->user_name = $user_name;

                }
                
            }

            $data["orders"] = $orders;

            $data["page_title"] = "Admin - Orders";
            $this ->view("admin/orders", $data);
        }

        function users($type = "customers"){

            $user = $this->load_model("User");
            $order = $this->load_model("Order");

            $user_data = $user->check_login(true, ["admin"]);

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }


            if ( $type == "admins") {
                $users = $user->get_admins();
            }else{
                $users = $user->get_customers();
            }
            if (is_array($users)) {
                foreach ($users as $key => $row) {
                    $orders_num = $order->get_orders_count($row->url_address);
                    $users[$key]->orders_count = $orders_num;
                }
            }
           
            $data["users"] = $users;
            //show($data["users"]);

            $data["page_title"] = "Admin - $type";
            $this ->view("admin/users", $data);
        }

        function settings($type){

            $user = $this->load_model("User");

            $user_data = $user->check_login(true, ["admin"]);

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }
            if (count($_POST) > 0) {
                //show($_POST);
                $errors = $this->save_settings($_POST);
                header("Location: " . ROOT . "admin/settings/socials");
                die;
            }
            $data["settings"] = $this->get_all_settings();
            //$data["settings_obj"] = $this->get_all_settings_as_object();

            $data["page_title"] = "Admin - $type";
            $this ->view("admin/socials", $data);
        }

    }
    
?>