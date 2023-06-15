<?php 
    class Product{
        
        public function create($DATA, $FILES, $image_class = null){

            $db = Database::newInstance();

            $_SESSION['error'] = "";

            $arr['description'] = ucwords($DATA->description);
            $arr['category']    = ucwords($DATA->category);
            $arr['quantity']    = ucwords($DATA->quantity);
            $arr['price']       = ucwords($DATA->price);
            $arr['date']        = date("Y-m-d H:i:s");
            $arr['user_url']    = $_SESSION["user_url"];
            $arr['slag']        = str_to_url($DATA->description);

            if (!preg_match("/^[a-zA-Z 0-9._\-,]+$/", trim($arr['description']))) {

                $_SESSION['error'] .= "Please enter a valid product name </br>";
            }
            if (!is_numeric($arr['category'])) {
                $_SESSION['error'] .= "Please enter a valid category </br>";
            }
            if (!is_numeric($arr['quantity'])) {
                $_SESSION['error'] .= "Please enter a valid quantity </br>";
            }
            if (!is_numeric($arr['price'])) {
                $_SESSION['error'] .= "Please enter a valid price </br>";
            }

            // Make sure slag is unique
            $slag_arr['slag'] = $arr['slag'];
            $sql = "SELECT slag FROM products WHERE slag =:slag LIMIT 1";
            
                $check = $db->read($sql,$slag_arr);
                if ($check) {
                    $arr['slag'] .= "-" . rand(0,99999);
                }

            // Check for files
                $arr["image"]  = "";
                $arr["image2"] = "";
                $arr["image3"] = "";
                $arr["image4"] = "";
                // Allow files type
                $allowed[] = "image/jpeg";
                // $allowed[] = "image/png";
                // $allowed[] = "image/gif";
                // $allowed[] = "application/pdf";
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
            
                $sql = "INSERT INTO products (`description`,`category`,`quantity`,`price`,`date`,`user_url`,`image`,`image2`,`image3`,`image4`,`slag`) VALUES (:description,:category,:quantity,:price,:date,:user_url,:image,:image2,:image3,:image4,:slag)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return false;
        } 

        public function edit($data,$FILES, $image_class = null){
            // $id
            $arr['pId']         = $data->pId;
            $arr['description'] = $data->description;
            $arr['slag']        = str_to_url($data->description);
            $arr['category']    = $data->category;
            $arr['quantity']    = $data->quantity;
            $arr['price']       = $data->price;

            $image_string = "";

            if (!preg_match("/^[a-zA-Z 0-9._\-,]+$/", trim($arr['description']))) {

                $_SESSION['error'] .= "Please enter a valid product name </br>";
            }
            if (!is_numeric($arr['category'])) {
                $_SESSION['error'] .= "Please enter a valid category </br>";
            }
            if (!is_numeric($arr['quantity'])) {
                $_SESSION['error'] .= "Please enter a valid quantity </br>";
            }
            if (!is_numeric($arr['price'])) {
                $_SESSION['error'] .= "Please enter a valid price </br>";
            }

            // Check for files
           
            // Allow files type
            $allowed[] = "image/jpeg";
            // $allowed[] = "image/png";
            // $allowed[] = "image/gif";
            // $allowed[] = "application/pdf";
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

                        $image_string .=",". $key ." = :".$key;
                    }else{
                        $_SESSION['error'] .= $key . "is bigger than required size";
                    }
                }
            }
            // Check for files end

            if (!isset($_SESSION['error']) || $_SESSION['error'] == "") {
                $db = Database::newInstance();
                $sql = "UPDATE products SET `description` = :description,`category` = :category, `quantity` = :quantity, `price` = :price, `slag` = :slag $image_string  WHERE pId = :pId LIMIT 1";
                $db->write($sql,$arr);
            }

        } 

        public function delete($pId){

            $db = Database::newInstance();
            $pId = (int)$pId;
            $sql = "DELETE FROM products WHERE pId = '$pId' LIMIT 1";
            $db->write($sql);

        } 
        public function getAllproduct(){
            $db = Database::newInstance();
            return $db->read("SELECT * FROM products ORDER BY pId DESC");


        }

        public function make_table($allproduct, $catModal = NULL){
            $result = "";
            if (is_array($allproduct)) {
                $i = 1;
                foreach ($allproduct as $productRow) {
                    $editArgs = $productRow->pId.",'".$productRow->description."'";
                    $info = array();
                    $info["pId"] = $productRow->pId;
                    $info["description"] = $productRow->description;
                    $info["category"] = $productRow->category;
                    $info["quantity"] = $productRow->quantity;
                    $info["price"] = $productRow->price;
                    $info["image"] = $productRow->image;
                    $info["image2"] = $productRow->image2;
                    $info["image3"] = $productRow->image3;
                    $info["image4"] = $productRow->image4;
                    
                    $info = str_replace('"',"'",json_encode($info));

                    $singleCat = $catModal->getSingleCategory($productRow->category);
                    $result .= "<tr>";
                        $result .= '
                            <td>'.$i.'</td>
                            <td class="hidden-phone"><a href="'.$productRow->pId.'">'.$productRow->description.'</a></td>
                            <td>'.$singleCat->category.'</td>
                            <td>'.$productRow->quantity.'</td>
                            <td>'.$productRow->price.'</td>
                            <td>'.date("d-M-Y H:i:s", strtotime($productRow->date)).'</td>
                            <td><a href=""><img src="' .ROOT. $productRow->image.'" alt="product_img" style="height: 50px; width: 50px;"></a></td>
                            <td>
                                <!--<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>-->
                                <button info="'.$info.'" onclick="show_edit_product('.$editArgs.',event)" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                <button onclick="delete_row('.$productRow->pId.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                            </td>
                        ';
                    $result .= "</tr>";
                    $i++;
                }
            }

            return $result;

        } 
    }
?>
