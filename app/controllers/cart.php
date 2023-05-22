<?php 
    class Cart extends Controller
    {
        public function index() {
            $user = $this->load_model("User");
            $image_class = $this->load_model("Image");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $db = Database::newInstance();

            $product_ids = array();

            if (isset($_SESSION["CART"])) {
                $product_ids = array_column($_SESSION["CART"], "pId");
                $ids_str = "'" . implode("','", $product_ids) . "'";

                $product_rows = $db->read("SELECT * FROM products WHERE pId in ($ids_str)");
            }
            show($product_rows);
            show($product_ids);
            show($_SESSION["CART"]);
            $product_rows = $db->read("SELECT * FROM products");

            $data["page_title"] = "Cart";
            if ($product_rows) {
                foreach ($product_rows as $key => $product_row) {
                    $product_rows[$key]->image = $image_class->get_thumb_post($product_rows[$key]->image);
                }
            }
            $data["product_rows"] = $product_rows;
            $this ->view("cart", $data);
        }
    }
    
?>