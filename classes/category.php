<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php'); 
include_once ($filepath.'/../helpers/format.php'); 

class category{

    private $db;
    private $fm;

    public function __construct() {

        $this->db = new Database();
        $this->fm = new Format();
    }
        
    // add category
    public function catInsert($catName){      // call from category file line number 12

        $catName = $this->fm->validation($catName);           // call to helpers->format.php line number 18 for validation
        $catName = mysqli_real_escape_string($this->db->link, $catName);   

        if(empty($catName)){
            $msg = "<span class ='error'> category field must not be empty ! </span>";
            return $msg;      // return to admin->catadd.php line number 12
        }
        else{
            $query = "INSERT INTO  tbl_category(catName) VALUES('$catName')";
            $catinsert =  $this->db->insert($query);   // call to lib->database.php line number 39 for insert
            if( $catinsert){
                $msg = "<span class ='success'> category inserted successfully </span>";
                return $msg;          // return to admin->catadd.php line number 12
            }
            else{
                $msg = "<span class ='error'> category not inserted successfully </span>";
                return $msg;       // return to admin->catadd.php line number 12
            }
        }         
    }


    // To taken all data from the database
    public function getAllCat(){    // call from catlist file from line number 41
                      
        $query = "SELECT * FROM tbl_category ORDER BY catId DESC ";
        $result =  $this->db->select($query);  
        return  $result;
    }


    // To taken all data from the database
    public function getCatById($id){       // call from catedit file from line number 41

        $query = "SELECT * FROM tbl_category WHERE catId = '$id' ";
        $result =  $this->db->select($query);     // call to database file line number 29
        return  $result;
    }


    // for category update
    public function catUpdate($catName, $id){     // call from catedit file from line number 21

        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->link, $catName);
        $id = mysqli_real_escape_string($this->db->link, $id);

        if(empty($catName)){
            $msg = "<span class ='error'> category field must not be empty ! </span>";
            return $msg;       // return to catedit file from line number 21
        }
        else{
            $query = "UPDATE tbl_category SET catName ='$catName' WHERE catId ='$id'";
            $updated_row = $this->db->update($query);   // call to database file line number 49

            if( $updated_row){
                $msg = "<span class ='success'> category successfully updated </span>";
                return $msg;       // return to catedit file from line number 21
            }
            else{
                $msg = "<span class ='error'> category not updated </span>";
                return $msg;      // return to catedit file from line number 21
            }
        }
    }


    // for delete category
    public function delCatById($id){     // call from catlist file from line number 11

        $query = "DELETE FROM tbl_category WHERE catId ='$id'";
        $deldata = $this->db->delete($query);      // call to database file line number 59
        if($deldata){
            $msg = "<span class ='success'> category successfully deleted </span>";
            return $msg;       // return to  catlist file from line number 11
        }
        else{
            $msg = "<span class ='error'> category not delete </span>";
            return $msg;       // return to  catlist file from line number 11
        }
    }

}
?>