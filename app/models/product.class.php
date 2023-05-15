<?php 
    class Product{
        
        public function create($DATA){

            $db = Database::newInstance();

            $_SESSION['error'] = "";

            $arr['description'] = ucwords($DATA->description);
            $arr['category']    = ucwords($DATA->category);
            $arr['quantity']    = ucwords($DATA->quantity);
            $arr['price']       = ucwords($DATA->price);
            $arr['date']        = date("Y-m-d H:i:s");
            $arr['user_url']    = $_SESSION["user_url"];

            if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['description']))) {

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

            if (isset($_SESSION['error']) || $_SESSION['error'] == "") {
            
                $sql = "INSERT INTO products (`description`,`category`,`quantity`,`price`,`date`,`user_url`) VALUES (:description,:category,:quantity,:price,:date,:user_url)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return false;
        } 

        public function edit($pId,$description){

            $db = Database::newInstance();
            $arr['pId'] = $pId;
            $arr['description'] = $description;
            $sql = "UPDATE products SET `description` = :description  WHERE pId = :pId LIMIT 1";
            $db->write($sql,$arr);

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
                    //$catClass = $this->load_model("Category");
                    $singleCat = $catModal->getSingleCategory($productRow->category);
                    $result .= "<tr>";
                        $result .= '
                            <td>'.$i.'</td>
                            <td class="hidden-phone"><a href="'.$productRow->pId.'">'.$productRow->description.'</a></td>
                            <td>'.$singleCat->category.'</td>
                            <td>'.$productRow->quantity.'</td>
                            <td>'.$productRow->price.'</td>
                            <td>'.date("d-M-Y H:i:s", strtotime($productRow->date)).'</td>
                            <td>
                                <!--<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>-->
                                <button onclick="show_edit_product('.$editArgs.')" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
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