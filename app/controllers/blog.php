<?php 
    class Blog extends Controller
    {
        public function index() {

            // Pagination formula
            $limit = 2;
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
            
            if ($search) {
                $arr["title"] = "%" . $find. "%";
                $blog_rows = $db->read("SELECT * FROM blogs WHERE `title` LIKE :title limit $limit offset $offset", $arr);
            }else{

                $blog_rows = $db->read("SELECT * FROM blogs ORDER BY blogId DESC limit $limit offset $offset");
            }

            $data["page_title"] = "Blog";
            if ($blog_rows) {
                foreach ($blog_rows as $key => $blog_row) {
                    
                    if (file_exists($blog_rows[$key]->image)) {
                    $blog_rows[$key]->image = $image_class->get_thumb_blog_post($blog_rows[$key]->image);
                    }
                    
                    $blog_rows[$key]->user_data = $user->get_user($blog_rows[$key]->user_url);
                }
                
            }
            // get all categories
            $category = $this->load_model("Category");
            $data["categories"] = $category->getAllCategory();
            

            $data["blog_rows"] = $blog_rows;
            $data["show_serach"] = true;
            $this ->view("blog", $data);
        }
    }
    
?>