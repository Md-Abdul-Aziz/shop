<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php'); 
include_once ($filepath.'/../helpers/format.php'); 

class product{

private $db;
private $fm;

public function __construct() {

    $this->db = new Database();
    $this->fm = new Format();

}

// add category
public function productInsert($data, $file){  // call to lib->category.php line number 17

    $productName = $this->fm->validation($data['productName']);         
    $productName = mysqli_real_escape_string($this->db->link, $productName);   

    $catId = $this->fm->validation($data['catId']);     
    $catId = mysqli_real_escape_string($this->db->link, $catId);   

    $brandId = $this->fm->validation($data['brandId']);          
    $brandId = mysqli_real_escape_string($this->db->link, $brandId);
    
    $body = $this->fm->validation($data['body']);          
    $body = mysqli_real_escape_string($this->db->link, $body);   

    $price = $this->fm->validation($data['price']);          
    $price = mysqli_real_escape_string($this->db->link, $price);   

    $type = $this->fm->validation($data['type']);            
    $type = mysqli_real_escape_string($this->db->link, $type);   


    $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;


    // for example : empty($productName) and  $productName == "" are same
    if( empty($productName) || empty($catId) || empty($brandId) || empty($body) || empty($price) || empty($file_name) || empty($type) ){
        $msg = "<span class ='error'> Product field must not be empty ! </span>";
        return $msg;                              
    }
    elseif ($file_size >1048567) {
        echo "<span class='error'>Image Size should be less then 1MB!</span>";
       } 
    elseif (in_array($file_ext, $permited) === false) {
        echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
       } 
    else{
        move_uploaded_file($file_temp, $uploaded_image);
        $query = "INSERT INTO  tbl_product(productName, catId, brandId, body, price, image, type)
                  VALUES('$productName', '$catId','$brandId','$body','$price','$uploaded_image','$type')";

        $productinsert =  $this->db->insert($query);   // call to lib->database.php line number 39 for insert
        if( $productinsert){
            $msg = "<span class ='success'> Product inserted successfully </span>";
            return $msg;          // return to admin->catadd.php line number 12
        }
        else{
            $msg = "<span class ='error'> Product not inserted successfully </span>";
            return $msg;       // return to admin->catadd.php line number 12
        }
    }         
}

// To taken all brand from the database
public function getAllProduct(){

    $query = " SELECT p.*, c.catName, b.brandName
               FROM tbl_product as p, tbl_category as c, tbl_brand as b
               WHERE p.catId = c.catId AND p.brandId = b.brandId
               ORDER BY p.productId DESC ";
 
 /*
    $query = " SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
              FROM tbl_product
              INNER JOIN tbl_category
              ON tbl_product.catId = tbl_category.catId
              INNER JOIN tbl_brand
              ON tbl_product.brandId = tbl_brand.brandId
             ORDER BY tbl_product.productId DESC ";
*/
    $result =  $this->db->select($query);             // call to lib->database.php line number 29 for select data
    return  $result;
   }


        // To taken all data from the database
        public function getProductById($id){       // call from catedit file from line number 41

            $query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
            $result =  $this->db->select($query);     // call to database file line number 29
            return  $result;
        }


        // for category update
        public function productUpdate($data, $file, $id){  
    
    $id = $this->fm->validation($id);         
    $id = mysqli_real_escape_string($this->db->link, $id);           
            
    $productName = $this->fm->validation($data['productName']);         
    $productName = mysqli_real_escape_string($this->db->link, $productName);   

    $catId = $this->fm->validation($data['catId']);     
    $catId = mysqli_real_escape_string($this->db->link, $catId);   

    $brandId = $this->fm->validation($data['brandId']);          
    $brandId = mysqli_real_escape_string($this->db->link, $brandId);
    
    $body = $this->fm->validation($data['body']);          
    $body = mysqli_real_escape_string($this->db->link, $body);   

    $price = $this->fm->validation($data['price']);          
    $price = mysqli_real_escape_string($this->db->link, $price);   

    $type = $this->fm->validation($data['type']);            
    $type = mysqli_real_escape_string($this->db->link, $type);   

    $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;

    // for example : empty($productName) and  $productName == "" are same
    if( empty($productName) || empty($catId) || empty($brandId) || empty($body) || empty($price) || empty($type) ){
        $msg = "<span class ='error'> Product field must not be empty ! </span>";
        return $msg;                              
    }
    else{  
          if(!empty($file_name)){

              if($file_size >1048567){
                 echo "<span class='error'>Image Size should be less then 1MB!</span>";
              } 
              elseif (in_array($file_ext, $permited) === false){
                echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
              }        
              else{
               move_uploaded_file($file_temp, $uploaded_image);

                $query = "UPDATE tbl_product 
                          SET 
                          productName ='$productName',
                          catId ='$catId', 
                          brandId ='$brandId',
                          body ='$body', 
                          price ='$price',
                          image ='$uploaded_image', 
                          type ='$type' 
                          WHERE productId ='$id'";

                $updated_row = $this->db->update($query);   // call to database file line number 49

                if( $updated_row){
                    $msg = "<span class ='success'> Product successfully updated </span>";
                    return $msg;       // return to catedit file from line number 21
                }
                else{
                    $msg = "<span class ='error'> Product not updated </span>";
                    return $msg;      // return to catedit file from line number 21
                }
            }

        }
       else{
            
        $query = "UPDATE tbl_product 
        SET 
        productName ='$productName',
        catId ='$catId', 
        brandId ='$brandId',
        body ='$body',
        price ='$price',
        type ='$type' 
        WHERE productId ='$id'";

       $updated_row = $this->db->update($query);   // call to database file line number 49

      if( $updated_row){
         $msg = "<span class ='success'> Product successfully updated </span>";
         return $msg;       // return to catedit file from line number 21
       }
      else{
          $msg = "<span class ='error'> Product not updated </span>";
          return $msg;      // return to catedit file from line number 21
        }

     }
     
    }
 }


 
        // for delete product
        public function delProductById($id){     

            $query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
            $result =  $this->db->select($query); 
            if($result){
                while($delimage = $result->fetch_assoc()){
                   $dellink = $delimage['image'];
                   unlink($dellink);
                 }
            }

            $query = "DELETE FROM tbl_product WHERE productId ='$id'";
            $delproduct = $this->db->delete($query);      
            if($delproduct){
                $msg = "<span class ='success'> Product successfully deleted </span>";
                return $msg;       
            }
            else{
                $msg = "<span class ='error'> Product not delete </span>";
                return $msg;       
            }
        }

        // get feature product
        public function getFeaturedProduct(){        //  call from index.php from line number 17
         $query = "SELECT * FROM tbl_product WHERE type = '1' ORDER BY productId DESC LIMIT 4 ";
         $result =  $this->db->select($query);  
         return  $result;
        }

        // get general product
        public function getNewProduct(){      //  call from index.php from line number 44
            $query = "SELECT * FROM tbl_product WHERE type = '2' ORDER BY productId DESC LIMIT 4 ";
            $result =  $this->db->select($query);  
            return  $result;
           }

           // details a click korar por details file a sob information show korar jnno
           public function getSingleProduct($id){     // call from details.php from line number 28
            $query = " SELECT p.*, c.catName, b.brandName
                     FROM tbl_product as p, tbl_category as c, tbl_brand as b
                     WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId='$id'";

           $result =  $this->db->select($query);             // call to lib->database.php line number 29 for select data
           return  $result;
            
           }

           // to get all iphon brand product
           public function latestFromIphone(){

            $query = "SELECT * FROM tbl_product WHERE brandId = '2' ORDER BY productId DESC LIMIT 1 ";
            $result =  $this->db->select($query);  
            return  $result;

           }

            // to get all samsung brand product
           public function latestFromSAMSUNG(){

            $query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1 ";
            $result =  $this->db->select($query);  
            return  $result;

           }

            // to get all acer brand product
           public function latestFromACER(){

            $query = "SELECT * FROM tbl_product WHERE brandId = '1' ORDER BY productId DESC LIMIT 1 ";
            $result =  $this->db->select($query);  
            return  $result;

           }

            // to get all camon brand product
           public function latestFromCANON(){

            $query = "SELECT * FROM tbl_product WHERE brandId = '4' ORDER BY productId DESC LIMIT 1 ";
            $result =  $this->db->select($query);  
            return  $result;

           }


           //to get all product order by category . call from productbycat.php line 27
           public function productByCategory($id){        

            $id = $this->fm->validation($id);         
            $id = mysqli_real_escape_string($this->db->link, $id);        
               
            $query = "SELECT * FROM tbl_product WHERE catId = '$id' ORDER BY productId DESC LIMIT 8 ";
            $result =  $this->db->select($query);  
            return  $result;   // return to productbycat.php line 27

           }


    // call from details.php line 62
    public function insertCompareData($cmprId, $cmrid){
              
        $cmrid = $this->fm->validation($cmrid);         
        $cmrid = mysqli_real_escape_string($this->db->link, $cmrid);
      
        $cmprId = $this->fm->validation($cmprId);         
        $product_id = mysqli_real_escape_string($this->db->link, $cmprId);
        
        $cquery = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrid' AND productId ='$product_id'";
        $result =  $this->db->select($cquery);
        if($result){
            $msg = "<span class ='error'> Already added to compare </span>";
            return $msg;       
        }
        else{

        $query  = "SELECT * FROM tbl_product WHERE productId = '$product_id'";
        $result =  $this->db->select($query)->fetch_assoc();
        if($result){

        $productId   = $result['productId'];
        $productName = $result['productName'];
        $price       = $result['price'];
        $image       = $result['image'];

        $query = "INSERT INTO tbl_compare(cmrId, productId, productName, price, image)
                  VALUES('$cmrid','$productId','$productName','$price','$image')";

        $inserted_row =  $this->db->insert($query);

        if($inserted_row){
            $msg = "<span class ='success'> Added ! check compare page </span>";
            return $msg;       
        }
        else{
            $msg = "<span class ='error'> Not added to compare </span>";
            return $msg;       
        }
    }

}
             
}


  public function getCompareDate($cmrid){

    $cmrid  = $this->fm->validation($cmrid);         
    $cmrid  = mysqli_real_escape_string($this->db->link, $cmrid);  

    $query  = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrid'";
    $result =  $this->db->select($query);     
    return  $result;


  }

  // call from header.php line 93
  public function delCompareData($cmrid){

    $cmrid  = $this->fm->validation($cmrid);         
    $cmrid  = mysqli_real_escape_string($this->db->link, $cmrid);  

    $query = " DELETE FROM tbl_compare WHERE cmrId = '$cmrid'";
    $result =  $this->db->delete($query); 
    
  }


  // call from details.php line 32
  public function insertwlistData($id, $cmrid){
              
    $cmrid = $this->fm->validation($cmrid);         
    $cmrid = mysqli_real_escape_string($this->db->link, $cmrid);
  
    $id = $this->fm->validation($id);         
    $product_id = mysqli_real_escape_string($this->db->link, $id);
    
    $cquery = "SELECT * FROM tbl_wlist WHERE cmrId = '$cmrid' AND productId ='$product_id'";
    $result =  $this->db->select($cquery);
    if($result){
        $msg = "<span class ='error'> Already added to list </span>";
        return $msg;       
    }
    else{

    $query  = "SELECT * FROM tbl_product WHERE productId = '$product_id'";
    $result =  $this->db->select($query)->fetch_assoc();
    if($result){

    $productId   = $result['productId'];
    $productName = $result['productName'];
    $price       = $result['price'];
    $image       = $result['image'];

    $query = "INSERT INTO tbl_wlist(cmrId, productId, productName, price, image)
              VALUES('$cmrid','$productId','$productName','$price','$image')";

    $inserted_row =  $this->db->insert($query);

    if($inserted_row){
        $msg = "<span class ='success'> Added ! check list page </span>";
        return $msg;       
    }
    else{
        $msg = "<span class ='error'> Not added to list </span>";
        return $msg;       
    }
}
}
  }
 // call from list.php line 20 and call from header.php line 154
  public function getWlistDate($cmrid){

    $cmrid  = $this->fm->validation($cmrid);         
    $cmrid  = mysqli_real_escape_string($this->db->link, $cmrid);  

    $query  = "SELECT * FROM tbl_wlist WHERE cmrId = '$cmrid'";
    $result =  $this->db->select($query);     
    return  $result;


  }

  public function del_list_data($cmrid, $pro_id){

    $cmrid  = $this->fm->validation($cmrid);         
    $cmrid  = mysqli_real_escape_string($this->db->link, $cmrid);  

    $pro_id  = $this->fm->validation($pro_id);         
    $pro_id  = mysqli_real_escape_string($this->db->link, $pro_id);  
    
        $query = " DELETE FROM tbl_wlist WHERE productId = '$pro_id' AND cmrId ='$cmrid' ";
        $result =  $this->db->delete($query); 
        
      }
    

  }

?>