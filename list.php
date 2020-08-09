<?php include 'inc/header.php'; ?>
<?php
if(isset($_GET['del_pro_id'])){
    $cmrid = session::get("cmrId");              // take from classes->customer.php line 90
    $pro_id = $_GET['del_pro_id'];
	$del_list = $pd->del_list_data($cmrid, $pro_id);  // call to classes->cart.php line 19
}

?>

<div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
				<h2>Product list</h2>				 					 
				<table class="tblone">
					<tr>
						<th>SL</th>
						<th>Product Name</th>
                        <th>Image</th>
						<th>Price</th>
						<th>Action</th>
					</tr>
                            
					<?php
                        $cmrid = session::get("cmrId");              // take from classes->customer.php line 90
						$getpd = $pd->getWlistDate($cmrid);       // call to classes->product.php line 360
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
                        <td> <a href="details.php?proid=<?php echo $result['productId'];?>">Buy now </a> 
                        || <a onclick="return confirm('are you sure to delete! ')" href="?del_pro_id=<?php echo $result['productId'];?>"> Delete </a></td>
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
