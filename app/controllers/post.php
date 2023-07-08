<?php 
    class Post extends Controller
    {
        public function index($url_address = "") {

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
                $arr["title"] = "%" . $find. "%";
                $blog_rows = $db->read("SELECT * FROM blogs WHERE `title` LIKE :title", $arr);
            }else{
                $arr = array();
                $arr["url_address"] = $url_address;

                $blog_rows = $db->read("SELECT * FROM blogs WHERE `url_address` = :url_address LIMIT 1", $arr);
            }

            $data["page_title"] = "Blog - Unknown";
            if ($blog_rows) {

                $data["page_title"] = $blog_rows[0]->title;
                if (file_exists($blog_rows[0]->image)) {
                    $blog_rows[0]->image = $image_class->get_thumb_blog_post($blog_rows[0]->image);
                }
                
                $blog_rows[0]->user_data = $user->get_user($blog_rows[0]->user_url);
                
            }
            // get all categories
            $category = $this->load_model("Category");
            $data["categories"] = $category->getAllCategory();
            

            $data["blog_rows"] = $blog_rows[0];
            $data["show_serach"] = true;
            $this ->view("single_post", $data);
        }
    }
    
?>