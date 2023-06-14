<?php 
    class Shop extends Controller
    {
        public function index() {

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
                $product_rows = $db->read("SELECT * FROM products WHERE `description` LIKE :description", $arr);
            }else{

                $product_rows = $db->read("SELECT * FROM products");
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

        public function category($category = ""){
           
            $user = $this->load_model("User");
            $image_class = $this->load_model("Image");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $db = Database::newInstance();

            $product_rows = $db->read("SELECT * FROM products");

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
    }
    
?>