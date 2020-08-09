<!-- this file connect to cart.php line 154 -->

<?php include 'inc/header.php'; ?>

<?php
    // jodi login kora na thake tahole login page a nea jabe
    $login = session::get("cuslogin");       // take from classes->customer.php line 90
    if($login == false){
	   header("location:login.php");
    }
?>

<?php
// get order data
if(isset($_GET['orderid']) && $_GET['orderid'] == 'order'){
    $cmrid = session::get("cmrId");             // take from classes->customer.php line 90
    $insertOrder = $ct->orderProduct($cmrid);   // call to classes->cart.php line 125 
    $delData = $ct->delCustomerCart();          // call to classes->cart.php line 119 for delete data after order
    header("location:success.php");
}
?>

<style>
.division{width: 50%; float: left;}
.tblone{width: 500px; margin: 0 auto; border: 2px solid #ddd;}
.tblone tr td{text-align: justify;}
.tbltwo{float:right; text-align:left; width: 60%;  border: 2px solid #ddd; margin-right: 14px; margin-top: 12px;}
.tbltwo tr td{text-align: justify; padding: 5px 10px;}
.ordernow{padding-bottom: 30px}
.ordernow a{ width: 160px; text-align: center; margin: 5px auto 0; padding-bottom: 4px; display:block; background : #555; border: 1px solid #333; color: white; border-radius: 3px; font-size: 25px;}

</style>

<div class="main">
    <div class="content">
        <div class="section group">
            <div class ="division"> 	 
				<table class="tblone">
					<tr>
						<th>No</th>
						<th>Product</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>
					</tr>

					<?php
						$getpro = $ct->getCartProduct();
						if($getpro){
							$i = 0;
							$sum = 0;
							$qty = 0;
							while($result = $getpro->fetch_assoc()){
							    $i++;		
					?>

					<tr>
						<td> <?php echo $i ; ?> </td>
						<td><?php echo $result['productName']; ?></td>
						<td>$ <?php echo $result['price']; ?>  </td>
                        <td><?php echo $result['quantity']; ?>  </td>
						<td>$
							<?php 
								$total = $result['price'] *  $result['quantity'];
								echo $total; 	
							?> 						
						</td>						
					</tr>
					<?php
                        $qty = $qty + $result['quantity'];        // for sum all quantity 
						$sum = $sum + $total;
					?>
                    <?php } } ?>							
				</table>             			
                <table class="tbltwo">
					<tr>
						<td>Sub Total</td>
                        <td>:</td>
						<td>$ <?php echo $sum; ?></td>
					</tr>
					<tr>
						<td>VAT</td>
                        <td>:</td>
						<td>10% ($<?php echo $vat = $sum * 0.1;?>) </td>
					</tr>
					<tr>
						<td>Grand Total</td>
                        <td>:</td>
						<td>$ 
						    <?php
							    $vat    = $sum * 0.1;
                                $gtotal = $sum + $vat;
							    echo $gtotal;
						    ?>
						</td>
					</tr>
                    <tr>
						<td>Quantity</td>
                        <td>:</td>
						<td><?php echo $qty;?></td>
					</tr>
				</table>
            </div>

            <div class ="division">
                <?php
                    $id = session::get("cmrId");          // connect to classes->customer.php line 91
                    $getdata = $cmr->getCustomerData($id);   // call to classes->customer.php line 102
                    if($getdata){
                        while($result = $getdata->fetch_assoc()){
                ?> 
                <table class="tblone">                                              
                    <tr> 
                        <td colspan="3"><h2>Your profile details</h2></td>
                    </tr>                                
                    <tr> 
                        <td width="20%">name</td>
                        <td width="5%">:</td>
                        <td> <?php echo $result['name']; ?> </td>                        
                    </tr>
                    <tr> 
                        <td>phone</td>
                        <td>:</td>
                        <td> <?php echo $result['phone']; ?> </td>                        
                    </tr>
                    <tr> 
                        <td>email</td>
                        <td>:</td>
                        <td> <?php echo $result['email']; ?> </td>                        
                    </tr>
                    <tr> 
                        <td>address</td>
                        <td>:</td>
                        <td> <?php echo $result['address']; ?> </td>                        
                    </tr>
                    <tr> 
                        <td>city</td>
                        <td>:</td>
                        <td> <?php echo $result['city']; ?> </td>                        
                    </tr>
                    <tr> 
                        <td>zip-code</td>
                        <td>:</td>
                        <td> <?php echo $result['zip']; ?> </td>                        
                    </tr>
                    <tr> 
                        <td>country</td>
                        <td>:</td>
                        <td> <?php echo $result['country']; ?> </td>                        
                    </tr>   
                    <tr> 
                        <td></td>
                        <td></td>
                        <td> <a href="editprofile.php">Update Details </a> </td>                        
                    </tr>                                                       
                </table>

                <?php } } ?>

            </div>
        </div>
 	</div>
    <div class="ordernow"><a href="?orderid=order" >Order</a> </div>
</div>

<?php include 'inc/footer.php';  ?>
