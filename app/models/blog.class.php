<?php 
    class Blog{
        
        public function create($DATA, $FILES, $image_class = null){

            $_SESSION['error'] = "";
            $db = Database::newInstance();


            $arr['title']       = ucwords($DATA["title"]);
            $arr['post']        = $DATA["post"];
            $arr['date']        = date("Y-m-d H:i:s");
            $arr['user_url']    = $_SESSION["user_url"];
            $arr['url_address'] = str_to_url($DATA["title"]);

            if (!preg_match("/^[a-zA-Z 0-9._\-,]+$/", trim($arr['title']))) {

                $_SESSION['error'] .= "Please enter a valid post title </br>";
            }
            if (empty($arr['post'])) {
                $_SESSION['error'] .= "Please enter a valid post details </br>";
            }

            // Make sure slag is unique
            $url_address_arr['url_address'] = $arr['url_address'];
            $sql = "SELECT url_address FROM blogs WHERE url_address =:url_address LIMIT 1";
            
                $check = $db->read($sql,$url_address_arr);
                if ($check) {
                    $arr['url_address'] .= "-" . rand(0,99999);
                }

            // Check for files
                $arr["image"]  = "";
                // Allow files type
                $allowed[] = "image/jpeg";
                $size = 10;
                $size = ($size * 1024 * 1024);

                $folder = "uploads/";
                if (!file_exists($folder)) {
                    mkdir($folder,0777,true);
                }

            foreach ($FILES as $key => $img_row) {

                if ($img_row["error"] == 0 && in_array($img_row["type"], $allowed)) {

                    if ($img_row["size"] < $size) {
                        $destination = $folder . $image_class->generate_filename(60) . ".jpg";
                        move_uploaded_file($img_row["tmp_name"], $destination);
                        $arr[$key] = $destination;
                        $image_class->resize_image($destination,$destination,1500,1500);
                    }else{
                        $_SESSION['error'] .= $key . "is bigger than required size";
                    }
                }
            }

            if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
            
                $sql = "INSERT INTO blogs (`title`,`post`,`date`,`user_url`,`image`,`url_address`) VALUES (:title,:post,:date,:user_url,:image,:url_address)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return false;
        } 

        public function edit($DATA,$FILES, $image_class = null){
            $_SESSION['error'] = "";
            // $id
            $arr['blogId']       = ucwords($DATA["blogId"]);
            $arr['title']       = ucwords($DATA["title"]);
            $arr['post']        = $DATA["post"];
            $arr['url_address'] = str_to_url($DATA["title"]);

            if (!preg_match("/^[a-zA-Z 0-9._\-,]+$/", trim($arr['title']))) {

                $_SESSION['error'] .= "Please enter a valid post title </br>";
            }
            if (empty($arr['post'])) {
                $_SESSION['error'] .= "Please enter a valid post details </br>";
            }

            // Check for files
           
            // Check for files
            $arr2["image"]  = "";
            // Allow files type
            $allowed[] = "image/jpeg";
            $size = 10;
            $size = ($size * 1024 * 1024);

            $folder = "uploads/";
            if (!file_exists($folder)) {
                mkdir($folder,0777,true);
            }

        foreach ($FILES as $key => $img_row) {

            if ($img_row["error"] == 0 && in_array($img_row["type"], $allowed)) {

                if ($img_row["size"] < $size) {
                    $destination = $folder . $image_class->generate_filename(60) . ".jpg";
                    move_uploaded_file($img_row["tmp_name"], $destination);
                    $arr2[$key] = $destination;
                    $image_class->resize_image($destination,$destination,1500,1500);
                }else{
                    $_SESSION['error'] .= $key . "is bigger than required size";
                }
            }
        }
            // Check for files end

            if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
                $db = Database::newInstance();
                if ($arr2["image"]  == "") {
                    
                    $sql = "UPDATE blogs SET `title` = :title,`post` = :post,`url_address` = :url_address WHERE blogId = :blogId LIMIT 1";
                }else{
                    $arr["image"] = $arr2["image"];
                    $sql = "UPDATE blogs SET `title` = :title,`post` = :post,`url_address` = :url_address, `image` = :image  WHERE blogId = :blogId LIMIT 1";
                }
                $db->write($sql,$arr);
            }

        } 

        public function delete($blogId){

            $db = Database::newInstance();
            $blogId = (int)$blogId;
            $sql = "DELETE FROM blogs WHERE blogId = '$blogId' LIMIT 1";
            $db->write($sql);

        } 
        // Get All Category
        public function get_all(){
            $db = Database::newInstance();
            return $db->read("SELECT * FROM blogs ORDER BY blogId DESC");
        }

        // Get single category
        public function get_one($blogId){
            $blogId = (int)$blogId;
            $db = Database::newInstance();
            $data =  $db->read("SELECT * FROM blogs WHERE blogId = '$blogId' LIMIT 1 ");
            return $data[0];
        }
    }
?>
