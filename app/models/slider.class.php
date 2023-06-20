<?php 
    class Slider {

        private $errors = "";

        public function create($DATA, $FILES, $image_class = null){

            $db = Database::newInstance();

            $this->errors = "";

            $arr['header1_text']    = ucwords($DATA->header1_text);
            $arr['header2_text']    = ucwords($DATA->header2_text);
            $arr['text']            = ucwords($DATA->text);
            $arr['link_text']       = ucwords($DATA->link_text);
            
            if (empty($arr['header1_text']) || !preg_match("/^[a-zA-Z 0-9._\-,]+$/", trim($arr['header1_text']))) {

                $this->errors .= "Please enter a valid slider header </br>";
            }
            if (empty($arr['header2_text']) || !preg_match("/^[a-zA-Z 0-9._\-,]+$/", trim($arr['header2_text']))) {
                $this->errors .= "Please enter a valid slider subtitle </br>";
            }
            if (empty($arr['text'])) {
                $this->errors .= "Please enter a slider details </br>";
            }
            if (empty($arr['link_text'])) {
                $this->errors .= "Please enter a valid link</br>";
            }

            if (!isset($this->errors) || $this->errors == "") {
            // Check for files
                $arr["image"]  = "";
                $arr["image2"] = "";
                
                // Allow files type
                $allowed[] = "image/jpeg";
                $allowed[] = "image/png";
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
                            $this->errors .= $key . "is bigger than required size";
                        }
                    }
                }

            
                $sql = "INSERT INTO home_slider (`header1_text`,`header2_text`,`text`,`link_text`,`image`,`image2`) VALUES (:header1_text,:header2_text,:text,:link_text,:image,:image2)";
                
                $check = $db->write($sql, $arr);
                if ($check) {
                    return true;
                }
            }

            return false;
        }
    }
?>
