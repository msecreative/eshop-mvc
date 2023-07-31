<?php 
    class Shop extends Controller
    {
        public function index() {
            // Pagination formula
            $limit = 3;
            $page_number = isset($_GET["pg"]) ? (int)$_GET["pg"] : 1;
            $offset = ($page_number - 1) * $limit;

            // check if its a search
            $search = false;
            if (isset( $_GET["find"])) {
                    $find = addslashes( $_GET["find"]);
                    $search = true;
            }
            $user = $this->load_model("User");
            $image_class = $this->load_model("Image");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $db = Database::newInstance();

            if ($search) {
                $arr["description"] = "%" . $find. "%";
                $product_rows = $db->read("SELECT * FROM products WHERE `description` LIKE :description limit $limit offset $offset", $arr);
            }else{

                $product_rows = $db->read("SELECT * FROM products limit $limit offset $offset");
            }

            $data["page_title"] = "Shop";

            if ($product_rows) {
                foreach ($product_rows as $key => $product_row) {
                    $product_rows[$key]->image = $image_class->get_thumb_post($product_rows[$key]->image);
                }
            }
            // get all categories
            $category = $this->load_model("Category");
            $data["categories"] = $category->getAllCategory();


            $data["product_rows"] = $product_rows;
            $data["show_serach"] = true;

            $this ->view("shop", $data);
        }

        public function category($cat_find = ""){
             // Pagination formula
             $limit = 3;
             $page_number = isset($_GET["pg"]) ? (int)$_GET["pg"] : 1;
             $offset = ($page_number - 1) * $limit;
           
            $user = $this->load_model("User");
            $category = $this->load_model("Category");
            $image_class = $this->load_model("Image");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }
            //show($cat_find);

            $db = Database::newInstance();
            $cat_id = null;

            $check = $category->get_one_by_name($cat_find);
            //show($check);

            if (is_object($check)) {
                $cat_id = $check->catId;
                $cat_id = $cat_id;
            }
            $product_rows = $db->read("SELECT * FROM products WHERE category = :cat_id limit $limit offset $offset", ["cat_id"=>$cat_id]);

            $data["page_title"] = "Shop";
            
            if ($product_rows) {
                foreach ($product_rows as $key => $product_row) {
                    $product_rows[$key]->image = $image_class->get_thumb_post($product_rows[$key]->image);
                }
            }
            // get all categories
            $data["categories"] = $category->getAllCategory();


            $data["product_rows"] = $product_rows;
            $data["show_serach"] = true;
            $this ->view("shop", $data);
        }
    }
    
?>