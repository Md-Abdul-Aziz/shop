<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php'); 
include_once ($filepath.'/../helpers/format.php'); 
?>

<?php

class cart{

    private $db;
    private $fm;

    public function __construct() {

        $this->db = new Database();
        $this->fm = new Format();
    }

    // call from details.php line 17
    public function addToCart($quantity, $id){

        $quantity  = $this->fm->validation($quantity);         
        $quantity  = mysqli_real_escape_string($this->db->link, $quantity);    
        $productId = mysqli_real_escape_string($this->db->link, $id);    
        $sId       = session_id();

       
        $squery = "SELECT * FROM tbl_product WHERE productId = '$productId' ";
        $result =  $this->db->select($squery)->fetch_assoc(); 

        $productName = $result['productName'];
        $price       = $result['price'];
        $image       = $result['image'];

        // can not add to cart same product next time if this product already exist in cart
        $chsquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId' ";
        $getPro =  $this->db->select($chsquery);

        if($getPro){
            $msg = "this product already added !";
            return $msg;       
        }
        else{
            $query = "INSERT INTO tbl_cart(sId, productId, productName, price, quantity, image)
                      VALUES('$sId','$productId','$productName','$price','$quantity','$image')";

            $inserted_row =  $this->db->insert($query);  

            if( $inserted_row){
                header("location:cart.php");
            }
            else{
                header("location:404.php");
            }
        }
    }


    //call from cart.php line 64 
    public function getCartProduct(){
        $sId    = session_id();
        $query  = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
        $result =  $this->db->select($query);     
        return  $result;       // return to cart.php line 64
    }

    
    // quantity update korar jonno
    public function updateCartQuantity($cartId, $quantity){

        $cartId = $this->fm->validation($cartId);           
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);    
 
        $quantity  = $this->fm->validation($quantity);         
        $quantity  = mysqli_real_escape_string($this->db->link, $quantity);  

        $query = "UPDATE tbl_cart SET quantity ='$quantity' WHERE cartId ='$cartId'";
        $updated_row = $this->db->update($query);   // call to database file line number 49

        if( $updated_row){
            header("location:cart.php");
            //$msg = "<span class ='success'> Quantity successfully updated </span>";
            // return $msg;       // return to catedit file from line number 21
        }
        else{
            $msg = "<span class ='error'> Quantity not updated </span>";
            return $msg;      // return to catedit file from line number 21
        }
    }

   
    // delete cart
    public function delCartById($deletecart){                 // call from cart.php line 15
            
        $delcart = mysqli_real_escape_string($this->db->link, $deletecart);    

        $query = "DELETE FROM tbl_cart WHERE cartId ='$delcart'";
        $deldata = $this->db->delete($query);      // call to database.php line number 59
        if($deldata){
            $msg = "<span class ='success'> Cart successfully deleted </span>";
            return $msg;       // return to  cart.php line number 15
        }
        else{
            $msg = "<span class ='error'> Cart not delete </span>";
            return $msg;       // return to  cart.php line number 15
        }
    }


    // cart a jookhon kono data thakbe na tokhon empty show korar jonno
    public function checkCartTable(){     // call from header.php line 67

        $sId       = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result =  $this->db->select($query);     
        return  $result;    // return to header.php line 67                 
    }
     
    
    // call from header.php line 89
    public function delCustomerCart(){     // delete all cart data when logout
        $sId       = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
        $this->db->delete($query);     
    }


    public function orderProduct($cmrid){
        $sId    = session_id();
        $query  = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $getPro =  $this->db->select($query);
        if($getPro){
            while($result    = $getPro->fetch_assoc()){

                $productId   = $result['productId'];
                $productName = $result['productName'];
                $quantity    = $result['quantity'];
                $price       = $result['price'] * $quantity;
                $image       = $result['image'];
                    
                $query = "INSERT INTO tbl_order(cmrId, productId, productName, quantity, price, image)
                          VALUES('$cmrid','$productId','$productName','$quantity','$price','$image')";

                $inserted_row =  $this->db->insert($query);  
            }  
        }               
    } 
    

    public function payableAmount($cmrid){

        $query  = "SELECT price FROM tbl_order WHERE cmrId = '$cmrid' AND date = now() ";
        $result =  $this->db->select($query);     
        return $result;   
    }

    public function getOrderProduct($cmrid){
        
        $query  = "SELECT * FROM tbl_order WHERE cmrId = '$cmrid' ORDER BY date DESC ";
        $result =  $this->db->select($query);     
        return $result;   
    }

    // call from header.php line 132
    public function checkOrder($cmrid){

        $query  = "SELECT * FROM tbl_order WHERE cmrId = '$cmrid'";
        $result =  $this->db->select($query);     
        return  $result;
    }

    // call from admin->inbox.php line 23
    public function getAllOrderProduct(){
        
        $query  = "SELECT * FROM tbl_order ORDER BY date DESC";
        $result =  $this->db->select($query);     
        return  $result;
    }


    // call from admin->inbox.php line 16 for update status 0 to 1 after click shift
    public function productShiftes($cmrid, $date, $price){
        
        $cmrid  = $this->fm->validation($cmrid);         
        $cmrid  = mysqli_real_escape_string($this->db->link, $cmrid);  
       
        $date  = $this->fm->validation($date);         
        $date  = mysqli_real_escape_string($this->db->link, $date);  
        
        $price  = $this->fm->validation($price);         
        $price  = mysqli_real_escape_string($this->db->link, $price);  

        
        $query = "UPDATE tbl_order
                  SET
                  status ='1' WHERE cmrId ='$cmrid' AND price = '$price' AND date ='$date' ";
        $updated_row = $this->db->update($query);   // call to database file line number 49

        if( $updated_row){
            $msg = "<span class ='success'> successfully updated </span>";
            return $msg;                           // return to catedit file from line number 21
        }
        else{
            $msg = "<span class ='error'>  not updated </span>";
            return $msg;                           // return to catedit file from line number 21
        }
    }

    // call from admin->inbox.php line 23 for remove product from inbox page
    public function delproductShiftes($cmrid, $date, $price){
        
        $cmrid  = $this->fm->validation($cmrid);         
        $cmrid  = mysqli_real_escape_string($this->db->link, $cmrid);  
       
        $date  = $this->fm->validation($date);         
        $date  = mysqli_real_escape_string($this->db->link, $date);  
        
        $price  = $this->fm->validation($price);         
        $price  = mysqli_real_escape_string($this->db->link, $price);  

        
        $query = "DELETE FROM tbl_order WHERE cmrId ='$cmrid' AND price = '$price' AND date ='$date' ";
        $updated_row = $this->db->delete($query);   // call to database file line number 49

        if( $updated_row){
            $msg = "<span class ='success'> Remove successfully  </span>";
            return $msg;                           // return to catedit file from line number 21
        }
        else{
            $msg = "<span class ='error'>  not Remove </span>";
            return $msg;                           // return to catedit file from line number 21
        }
    }
        
    // call from orderdetails.php line 16
    public function productConfirm($cmrid, $date, $price){
        
            $cmrid  = $this->fm->validation($cmrid);         
            $cmrid  = mysqli_real_escape_string($this->db->link, $cmrid);  
           
            $date  = $this->fm->validation($date);         
            $date  = mysqli_real_escape_string($this->db->link, $date);  
            
            $price  = $this->fm->validation($price);         
            $price  = mysqli_real_escape_string($this->db->link, $price);  
    
            
            $query = "UPDATE tbl_order
                      SET
                      status ='2' WHERE cmrId ='$cmrid' AND price = '$price' AND date ='$date' ";
            $updated_row = $this->db->update($query);   // call to database file line number 49
    
            if( $updated_row){
                $msg = "<span class ='success'> successfully updated </span>";
                return $msg;                           // return to catedit file from line number 21
            }
            else{
                $msg = "<span class ='error'>  not updated </span>";
                return $msg;                           // return to catedit file from line number 21
            }
        }

    
        
}
?>