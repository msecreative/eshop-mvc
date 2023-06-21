<?php 
    class Home extends Controller
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

            $data["page_title"] = "Home";
            if ($product_rows) {
                foreach ($product_rows as $key => $product_row) {
                    $product_rows[$key]->image = $image_class->get_thumb_post($product_rows[$key]->image);
                }
            }
            // get all categories
            $category = $this->load_model("Category");
            $data["categories"] = $category->getAllCategory();
            
            $Slider = $this->load_model("Slider");
            $data["slider_row"] = $Slider->get_all();

            if ($data["slider_row"]) {
                foreach ($data["slider_row"] as $key => $row) {
                    $data["slider_row"][$key]->image = $image_class->get_thumb_post($data["slider_row"][$key]->image,448,441);
                }
            }

            $data["product_rows"] = $product_rows;
            $data["show_serach"] = true;
            $this ->view("index", $data);
        }
    }
    
?>