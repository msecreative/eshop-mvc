<?php 
    class ProductDetails extends Controller
    {
        public function index($pId) {

            $pId = (int)$pId;

            $user = $this->load_model("User");
            $user_data = $user->check_login();

            if (is_object($user_data)) {
                $data["user_data"] = $user_data;
            }

            $db = Database::newInstance();
            $product_detail = $db->read("SELECT * FROM products WHERE pId = :pId",['pId' =>$pId]);

            $data["page_title"] = "Product Details";
            $data["product_detail"] = $product_detail[0];
            $this ->view("product-details", $data);
        }
    }
    
?>