<?php
    class Category {

        public function create($DATA){
            $db = Database::newInstance();
            $arr['category'] = ucwords($DATA->category);
            $arr['parent'] = ucwords($DATA->parent);

            if (!preg_match("/^[a-zA-Z ]+$/", trim($arr['category']))) {
                $_SESSION['error'] = "Please enter a valid category name";
            }

            if (isset($_SESSION['error']) || $_SESSION['error'] == "") {
            
                $sql = "INSERT INTO categories (category,parent) VALUES (:category,:parent)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return false;
        } 

        public function edit($data){

            $db = Database::newInstance();
            $arr['catId'] = $data->catId;
            $arr['category'] = $data->category;
            $arr['parent'] = $data->parent;
            $sql = "UPDATE categories SET category = :category, parent =:parent  WHERE catId = :catId LIMIT 1";
            $db->write($sql,$arr);

        } 

        public function delete($catId){

            $db = Database::newInstance();
            $catId = (int)$catId;
            $sql = "DELETE FROM categories WHERE catId = '$catId' LIMIT 1";
            $db->write($sql);

        } 
        // Get All Category
        public function getAllCategory(){
            $db = Database::newInstance();
            return $db->read("SELECT * FROM categories ORDER BY catId DESC");



        }
        // Get single category
        public function getSingleCategory($catId){
            $catId = (int)$catId;
            $db = Database::newInstance();
            $data =  $db->read("SELECT category FROM categories WHERE catId = '$catId' LIMIT 1 ");
            return $data[0];


        }

        public function make_table($allCategory){
            $result = "";
            if (is_array($allCategory)) {
                $i = 1;
                foreach ($allCategory as $catRow) {
                    $catRow->disabled = $catRow->disabled ? "Enabled" : "Disabled";
                    $status_color = $catRow->disabled == "Enabled" ? "info" : "danger";

                    $args = $catRow->catId.",'".$catRow->disabled."'";
                    $editArgs = $catRow->catId.",'".$catRow->category."'";
                    $result .= "<tr>";
                        $result .= '
                            <td>'.$i.'</td>
                            <td class="hidden-phone"><a href="'.$catRow->catId.'">'.$catRow->category.'</a></td>
                            <td><span onclick="disable_row('.$args.')" class="label label-'.$status_color.' label-mini" style="cursor:pointer">'.$catRow->disabled.'</span></td>
                            <td>
                                <!--<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>-->
                                <button onclick="show_edit_category('.$editArgs.')" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                <button onclick="delete_row('.$catRow->catId.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                            </td>
                        ';
                    $result .= "</tr>";
                    $i++;
                }
            }

            return $result;

        } 

    }

