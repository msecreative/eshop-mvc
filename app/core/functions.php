<?php 

    function show($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    function chk_error(){
        if (isset($_SESSION['error']) && $_SESSION['error'] != "") {
           echo  $_SESSION['error'];
           unset($_SESSION['error']);
        }
    }

    function esc($data){
        return addslashes($data);
    }

     // Convert slug from product description
    function str_to_url($url) {
        $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
        $url = trim($url, "-");
        $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
        $url = strtolower($url);
        $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
        return $url;
    }

    function redirect($link){
        header("Location: " . ROOT . $link);
        die;
    }

?>