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
            $product_rows = false;
            $product_ids = array();

            if (isset($_SESSION["CART"])) {
                $product_ids = array_column($_SESSION["CART"], "pId");
                $ids_str = "'" . implode("','", $product_ids) . "'";

                $product_rows = $db->read("SELECT * FROM products WHERE pId in ($ids_str)");
            }
           
            if (is_array($product_rows)) {

                foreach ($product_rows as $key => $product_row) {
                
                    foreach ($_SESSION["CART"] as $item) {

                        if ($product_row->pId == $item["pId"]) {
                            $product_rows[$key]->cart_qty = $item["qty"];
                            break;
                        }
                    }
                    
                }
                
            }
           

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