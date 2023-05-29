<?php 
    class Countries {

       public function get_countries(){

        $db = Database::newInstance();
        $sql = "SELECT * FROM countries ORDER BY country ASC";
        $data = $db->read($sql);

        return $data;
        
       } 
   
       public function get_states($countryId){

        $arr["countryId"] = (int)$countryId;
        $db = Database::newInstance();
        $sql = "SELECT * FROM states WHERE countryId = :countryId ORDER BY `state` DESC";
        $data = $db->read($sql,$arr);

        return $data;

       } 
    }