<?php
 $filepath = realpath(dirname(__FILE__));
 include_once ($filepath.'/../lib/Database.php'); 
 include_once ($filepath.'/../helpers/format.php'); 
 
class customer{

    private $db;
    private $fm;

    public function __construct(){

        $this->db = new Database();
        $this->fm = new Format();
    }


    public function customerRegistration($data){
        
    $name = $this->fm->validation($data['name']);         
    $name = mysqli_real_escape_string($this->db->link, $name);   

    $address = $this->fm->validation($data['address']);     
    $address = mysqli_real_escape_string($this->db->link, $address);   

    $city = $this->fm->validation($data['city']);          
    $city = mysqli_real_escape_string($this->db->link, $city);
    
    $country = $this->fm->validation($data['country']);          
    $country = mysqli_real_escape_string($this->db->link, $country);   

    $zip = $this->fm->validation($data['zip']);          
    $zip = mysqli_real_escape_string($this->db->link, $zip);   

    $phone = $this->fm->validation($data['phone']);            
    $phone = mysqli_real_escape_string($this->db->link, $phone);
    
    $email = $this->fm->validation($data['email']);            
    $email = mysqli_real_escape_string($this->db->link, $email);

    $password = $this->fm->validation(md5($data['password']));            
    $password = mysqli_real_escape_string($this->db->link, $password);

    if( empty($name) || empty($address) || empty($city) || empty($country) || empty($zip) || empty($phone) || empty($email) || empty($password)){
        $msg = "<span class ='error'> Registration field must not be empty ! </span>";
        return $msg;                              
    }

    $mailquery = " SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1 ";
    $mailchk   =  $this->db->select($mailquery);   // call to lib->database.php line number 39 for insert
    if($mailchk != false){
        $msg = "<span class ='success'> This mail already exist </span>";
        return $msg;         
    }else{

        $query = "INSERT INTO  tbl_customer(name, address, city, country, zip, phone, email, password)
                  VALUES('$name','$address','$city','$country','$zip','$phone','$email','$password')";

        $cusInfoinsert =  $this->db->insert($query);   // call to lib->database.php line number 39 for insert
        if( $cusInfoinsert){
            $msg = "<span class ='success'> You are register successfully </span>";
            return $msg;          // return to admin->catadd.php line number 12
        }
        else{
            $msg = "<span class ='error'> You are not register successfully. please try again </span>";
            return $msg;       // return to admin->catadd.php line number 12
        }
    }

  }

  public function customerLogin($data){
      
    $email = $this->fm->validation($data['email']);            
    $email = mysqli_real_escape_string($this->db->link, $email);

    $password = $this->fm->validation(md5($data['password']));            
    $password = mysqli_real_escape_string($this->db->link, $password);

    if(empty($email) || empty($password)){
        $msg = "<span class ='error'> Login field must not be empty ! </span>";
        return $msg;                              
    }

    $query = " SELECT * FROM tbl_customer WHERE email='$email' AND password='$password' ";
    $result   =  $this->db->select($query);   // call to lib->database.php line number 39 for insert
    if($result != false){
        $value = $result->fetch_assoc();
        session::set("cuslogin", true);               // login set
        session::set("cmrId", $value['id']);         // connect to classes->customer.php line 18
        session::set("cmrName", $value['name']);
        header("location:cart.php");    // login korar por cart page a nea jabe.jodi cart page a kono data na thake tahole index page a nea jabe.
    }
    else{
        $msg = "<span class ='error'> email or password not matched </span>";
        return $msg;           
    }
  }
  
  // for take all data from customer table by id
  public function getCustomerData($id){          // call from profile.php line 19

    $query = "SELECT * FROM tbl_customer WHERE id = '$id'";
    $result =  $this->db->select($query);     
    return  $result;    // return to profile.php line 19
            
  }

  // customer information update
  public function customerUpdate($data, $cmrid){  // cal from editprofile.php line 15
           
    $name = $this->fm->validation($data['name']);         
    $name = mysqli_real_escape_string($this->db->link, $name);   

    $address = $this->fm->validation($data['address']);     
    $address = mysqli_real_escape_string($this->db->link, $address);   

    $city = $this->fm->validation($data['city']);          
    $city = mysqli_real_escape_string($this->db->link, $city);
    
    $country = $this->fm->validation($data['country']);          
    $country = mysqli_real_escape_string($this->db->link, $country);   

    $zip = $this->fm->validation($data['zip']);          
    $zip = mysqli_real_escape_string($this->db->link, $zip);   

    $phone = $this->fm->validation($data['phone']);            
    $phone = mysqli_real_escape_string($this->db->link, $phone);
    
    $email = $this->fm->validation($data['email']);   
    $email = mysqli_real_escape_string($this->db->link, $email);

    if( empty($name) || empty($address) || empty($city) || empty($country) || empty($zip) || empty($phone) || empty($email)){
        $msg = "<span class ='error'> Update field must not be empty ! </span>";
        return $msg;                              
    }
    else{
        $query = "UPDATE tbl_customer
                  SET 
                  name     ='$name',
                  address  ='$address',
                  city     ='$city',
                  country  ='$country',
                  zip      ='$zip',
                  phone    ='$phone',            
                  email    ='$email'
                  WHERE id ='$cmrid'";
        $updated_row = $this->db->update($query);   // call to database file line number 49
        if( $updated_row){
        $msg = "<span class ='success'> details successfully updated </span>";
        return $msg;       // return to editprofile.php from line number 15
        }
        else{
        $msg = "<span class ='error'> details not updated </span>";
        return $msg;      // return to editprofile.php from line number 15
        }
    }
  }



}
?>