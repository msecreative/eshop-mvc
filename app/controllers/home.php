<?php 
    class Home extends Controller
    {
        public function index() {
            // Pagination formula
            $limit = 6;
            $offset = Page::get_offset($limit);
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
            
            $data["page_title"] = "Home";

            // read the main post
            if ($search) {
                $arr["description"] = "%" . $find. "%";
                $product_rows = $db->read("SELECT * FROM products WHERE `description` LIKE :description limit $limit offset $offset", $arr);
            }else{

                $product_rows = $db->read("SELECT * FROM products limit $limit offset $offset");
            }

            if ($product_rows) {
                foreach ($product_rows as $key => $product_row) {
                    $product_rows[$key]->image = $image_class->get_thumb_post($product_rows[$key]->image);
                }
            }
            $data["product_rows"] = $product_rows;

            // read the product bottom carousel slider 1
            $carousel_post_count = 3;
            for ($i=0; $i < $carousel_post_count; $i++) { 
                
                $slider_rows[$i] = $db->read("SELECT * FROM products ORDER BY RAND() LIMIT 3");
                
                if ($slider_rows[$i]) {
                    foreach ($slider_rows[$i] as $key => $product_row) {
                        $slider_rows[$i][$key]->image = $image_class->get_thumb_post($slider_rows[$i][$key]->image);
                    }
                }
                $data["slider_rows"][] = $slider_rows[$i];
            }
            // get all categories
            $category = $this->load_model("Category");
            $data["categories"] = $category->getAllCategory();

            // get product by category for tab product diplay
            $data["segment_data"] = $this->get_segment_data($db, $data["categories"],$image_class);
            
            $Slider = $this->load_model("Slider");
            $data["slider_row"] = $Slider->get_all();

            if ($data["slider_row"]) {
                foreach ($data["slider_row"] as $key => $row) {
                    $data["slider_row"][$key]->image = $image_class->get_thumb_post($data["slider_row"][$key]->image,448,441);
                }
            }

            $data["show_serach"] = true;
            $this ->view("index", $data);
        }

        private function get_segment_data($db,$categories,$image_class){
            $results = array();
            $num = 0;
            foreach ($categories as $cat) {

                $arr["catId"] = $cat->catId;
                $product_rows = $db->read("SELECT * FROM products WHERE `category` = :catId ORDER BY rand() LIMIT 5", $arr);

                if (is_array($product_rows)) {
                
                    // If I use catname to get catname without cat slug
                    //$cat->category = preg_replace( "/\W+/", "", $cat->category);
                    // this code for crop image an actual size
                    if ($product_rows) {
                        foreach ($product_rows as $key => $row) {
                            $product_rows[$key]->image = $image_class->get_thumb_post($product_rows[$key]->image,448,441);
                        }
                    }
                    
                  $results[$cat->cat_slug] = $product_rows;
                  //show($results);

                    $num++;
                    if ($num > 5) {

                        break;
                    }
              
                }
            }
            return $results;
        }
    }
    
?>