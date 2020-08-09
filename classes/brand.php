<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php'); 
include_once ($filepath.'/../helpers/format.php'); 
 
class brand{

    private $db;
    private $fm;

    public function __construct() {

        $this->db = new Database();
        $this->fm = new Format();
    }

    // add brand
    public function brandInsert($brandName){    // call from admin->brandadd.php line number 12

        $brandName = $this->fm->validation($brandName);  // call to helpers->format.php line number 18 for validation
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);

        if(empty($brandName)){
            $msg = "<span class ='error'> Brand field must not be empty ! </span>";
            return $msg;      // return to admin->brandadd.php line number 12
        }
        else{
            $query = "INSERT INTO  tbl_brand(brandName) VALUES('$brandName')";
            $brandinsert =  $this->db->insert($query);   // call to lib->database.php file line number 39 for insert

            if( $brandinsert){
                $msg = "<span class ='success'> Brand name inserted successfully </span>";
                return $msg;              // return to admin->brandadd.php line number 12
            }
            else{
                $msg = "<span class ='error'> Brand name not inserted successfully </span>";
                return $msg;             // return to admin->brandadd.php line number 12
            }
        }         
    }


    // To taken all brand from the database
    public function getAllBrand(){    // call from admin->brandlist file from line number 43
            
        $query = "SELECT * FROM tbl_brand ORDER BY brandId DESC ";
        $result =  $this->db->select($query); // call to lib->database.php line number 29 for select data
        return  $result;
    }


    // for brand update
    public function brandUpdate($brandName, $id){     // call from catedit file from line number 21

        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        $id = mysqli_real_escape_string($this->db->link, $id);

        if(empty($brandName)){
            $msg = "<span class ='error'> brand field must not be empty ! </span>";
            return $msg;       // return to catedit file from line number 21
        }
        else{
            $query = "UPDATE tbl_brand SET brandName ='$brandName' WHERE brandId ='$id'";
            $updated_row = $this->db->update($query);   // call to database file line number 49

            if( $updated_row){
                $msg = "<span class ='success'> brand successfully updated </span>";
                return $msg;       // return to catedit file from line number 21
            }
            else{
                $msg = "<span class ='error'> brand not updated </span>";
                return $msg;      // return to catedit file from line number 21
            }
        }
    }

   
    // To taken all data from the database
    public function getBrandById($id){       // call from catedit file from line number 41

        $query = "SELECT * FROM tbl_brand WHERE brandId = '$id' ";
        $result =  $this->db->select($query);     // call to database file line number 29
        return  $result;
    }


    // for delete category
    public function delBrandById($id){     // call from catlist file from line number 11

        $query = "DELETE FROM tbl_brand WHERE brandId ='$id'";
        $deldata = $this->db->delete($query);      // call to database file line number 59
        if($deldata){
            $msg = "<span class ='success'> brand successfully deleted </span>";
            return $msg;       // return to  catlist file from line number 11
        }
        else{
            $msg = "<span class ='error'> brand not delete </span>";
            return $msg;       // return to  catlist file from line number 11
        }
    }

  
}
?>