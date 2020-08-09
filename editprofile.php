<?php include 'inc/header.php'; ?>

<?php
   // jodi login kora na thake tahole login page a nea jabe
   $login = session::get("cuslogin");       // take from classes->customer.php line 90
   if($login == false){
	   header("location:login.php");
   }
?>

<?php	
    $cmrid = session::get("cmrId");       // take from classes->customer.php line 91
	// to take all data from input 			
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $updatecmr = $cmr->customerUpdate($_POST, $cmrid);    // call to classes->customer.php line 110
	}
?>

<style>
.tblone{width: 550px; margin: 0 auto; border: 2px solid #ddd;}
.tblone tr td{text-align: justify;}
.tblone input[type="text"]{width: 400px; padding: 5px auto; font-size: 15px;}
</style>

<div class="main">
    <div class="content">
        <div class="section group">

            <?php
                $id = session::get("cmrId");          // connect to classes->customer.php line 91
                $getdata = $cmr->getCustomerData($id);   // call to classes->customer.php line 102
                if($getdata){
                    while($result = $getdata->fetch_assoc()){
            ?>
    
        <form action="" method ="post">
            <table class="tblone">   

                <?php
                    // for show messege
                    if(isset($updatecmr)){         
                    echo "<tr><td colspan='2'>".$updatecmr."</td></tr>";
                    }
			    ?>
                                          
                <tr> 
                    <td colspan="2"><h2>Update profile details</h2></td>
                </tr>                                
                <tr> 
                    <td width="20%">name</td>
                    <td><input type="text" name="name" value="<?php echo $result['name']; ?>" > </td>                        
                </tr>
                <tr> 
                    <td>phone</td>
                    <td><input type="text" name="phone" value="<?php echo $result['phone']; ?>" > </td>                        
                </tr>
                <tr> 
                    <td>email</td>
                    <td><input type="text" name="email" value="<?php echo $result['email']; ?>" > </td>                        
                </tr>
                <tr> 
                    <td>address</td>
                    <td><input type="text" name="address" value="<?php echo $result['address']; ?>" > </td>                        
                <tr> 
                    <td>city</td>
                    <td><input type="text" name="city" value="<?php echo $result['city']; ?>" > </td>                        
                </tr>
                <tr> 
                    <td>zip-code</td>
                    <td><input type="text" name="zip" value="<?php echo $result['zip']; ?>" > </td>                        
                </tr>
                <tr> 
                    <td>country</td>
                    <td><input type="text" name="country" value="<?php echo $result['country']; ?>" > </td>                        
                </tr>   
                <tr> 
                    <td></td>
                    <td><input type="submit" name="submit" value="save"></td>                        
                </tr>                                                       
            </table>
        </form>
            <?php } } ?>
        </div>
 	</div>
</div>

<?php include 'inc/footer.php';  ?>
