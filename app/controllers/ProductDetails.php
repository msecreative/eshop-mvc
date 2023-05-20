<?php 
    class ProductDetails extends Controller
    {
        public function index($slag) {

            $slag = esc($slag);

            $user = $this->load_model("User");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $db = Database::newInstance();
            $product_detail = $db->read("SELECT * FROM products WHERE slag = :slag",['slag' =>$slag]);

            $data["page_title"] = "Product Details";
            $data["product_detail"] = is_array($product_detail) ? $product_detail[0] : false;
            $this ->view("product-details", $data);
        }
    }
    
?>