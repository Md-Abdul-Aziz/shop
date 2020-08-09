<?php include 'inc/header.php'; ?>

<?php
   // jodi login kora na thake tahole login page a nea jabe
   $login = session::get("cuslogin");       // take from classes->customer.php line 90
   if($login == false){
	   header("location:login.php");
   }
 ?>

<div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
				<h2>Product Compare</h2>				 					 
				<table class="tblone">
					<tr>
						<th>SL</th>
						<th>Product Name</th>
                        <th>Image</th>
						<th>Price</th>
                        <th>Details</th>
						<th>Action</th>
					</tr>
                            
					<?php
                        $cmrid = session::get("cmrId");              // take from classes->customer.php line 90
						$getpd = $pd->getCompareDate($cmrid);       // call to classes->product.php line 360
						if($getpd){
							$i = 0;
							while($result = $getpd->fetch_assoc()){
								$i++;		
					?>
							
					<tr>
						<td> <?php echo $i ; ?> </td>
						<td><?php echo $result['productName']; ?></td>
						<td><img src="admin/<?php echo $result['image'];?> " alt=""/></td>
						<td>$ <?php echo $result['price']; ?>  </td>
                        <td> <a href="details.php?proid=<?php echo $result['productId'];?>">View </a>  </td>
                        <td><a onclick="return confirm('are you sure to delete! ')" href="?del_cart_id=<?php echo $result['cartId'];?>"> Delete </a></td>
					</tr>

                    <?php } } ?>
							
				</table>
                <div class="shopping">
					<div class="shopleft" style="width: 100%; text-align: center">
						<a href="index.php"> <img src="images/shop.png" alt="" /></a>
			        </div>						
				</div>					
    	    </div>  	
            <div class="clear"></div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';  ?>
