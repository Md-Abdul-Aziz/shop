<?php 
include 'inc/header.php';  
if( $_SERVER['REQUEST_METHOD'] == 'POST'){

	$cartId = $_POST['cartId'];
	$quantity = $_POST['quantity'];

	$updateCart = $ct->updateCartQuantity($cartId, $quantity);  // call to classes->cart.php line 18

	if($quantity <= 0){
		$delCart = $ct->delCartById($cartId);   // call to classes->cart.php line number 90

	}
}

// delete cart
if(isset($_GET['del_cart_id'])){      // get del_cart_id from this file line 82
	$deletecart = $_GET['del_cart_id'];
	//$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['delcat']);
	$delCart = $ct->delCartById($deletecart);   // call to classes->cart.php line number 90
  
  }


// jokhon product add kora hobe cart a tokhon page load kora chara update howar jonno
if(!isset($_GET['id'])){
	echo "<meta http-equiv='refresh' content ='0;URL=?id=live'/>";
}
?>

<div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
					<h2>Your Cart</h2>
					
					    <?php
							// show messege when quantity update 
							if(isset($updateCart))
							{
								echo $updateCart;
							}					
							// show messege when quantity delete
							if(isset($delCart))
							{
								echo $delCart;
							}
				     	?>
						 						 
						 
						<table class="tblone">
							<tr>
							    <th width="5%">SL</th>
								<th width="30%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
								<th width="15%">Total Price</th>
								<th width="10%">Action</th>
							</tr>

							<?php
							// call to classes->cart.php line 58
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
								<td><img src="admin/<?php echo $result['image'];?> " alt=""/></td>
								<td>$ <?php echo $result['price']; ?>  </td>
					            <td>
						            <form action="" method="post">
						                <input type="hidden" name="cartId" value="<?php echo $result['cartId'];?>"/>
						    	        <input type="number" name="quantity" value="<?php echo $result['quantity'];?>"/>
							            <input type="submit" name="submit" value="Update"/>
						            </form>
					            </td>
								<td>$
								    <?php 
								        $total = $result['price'] *  $result['quantity'];
								        echo $total; 	
								   ?> 						
								</td>
								<td>
								    <a onclick="return confirm('are you sure to delete! ')" href="?del_cart_id=<?php echo $result['cartId'];?>"> Delete </a>
								</td>
							</tr>

							<?php
                              $qty = $qty + $result['quantity'];        // for sum all quantity 
							  $sum = $sum + $total;
							  session::set("qty",$qty );    // upore total quantity show korar jonno
							  session::set("sum",$sum );  	// uporer cart a total amount show korar jonno. this line connect to header.php line 69
							?>

						    <?php } } ?>
							
						</table>
                         

						 <?php
						   $getData = $ct->checkCartTable();  // call to classes->cart.php line 107
							if($getData){	                  // when get session id then enter 
					     ?>	


						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td>$ <?php echo $sum; ?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>$ 
								   <?php
								      $vat    = $sum * 0.1;
                                      $gtotal = $sum + $vat;
								      echo $gtotal;
								   ?>
								</td>
							</tr>
					   </table>


							<?php 
							  } 
							  else{
								  header("location:index.php");
								//echo "Cart Empty ! please shope now";  // when not get session id then show this msg
							  } 
							?>


					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
</div>

<?php include 'inc/footer.php';  ?>


