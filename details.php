<?php include 'inc/header.php';
$ct = new cart();

// catch proid from index.php line 30
if(isset($_GET['proid'])){

      $id = $_GET['proid'];    
}

// catch quantity  from this file from line number 47
if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

	$quantity = $_POST['quantity'];
	$addCart = $ct->addToCart($quantity, $id);  // call to classes->cart.php line 19
}
?>

<?php	
    $cmrid = session::get("cmrId");       // take from classes->customer.php line 91
	// to take all data from input 			
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])){
		$productId = $_POST['productId'];

        $insertCom = $pd->insertCompareData( $productId, $cmrid);    // call to classes->customer.php line 110
	}
?>
<?php	
    $cmrid = session::get("cmrId");       // take from classes->customer.php line 91
	// to take all data from input 			
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['wlist'])){

        $insertwlist = $pd->insertwlistData( $id, $cmrid);    // call to classes->product.php line 385
	}
?>
<style>
.mybutton{width: 100px; float: left; margin-right: 50px;}

</style>

<div class="main">
    <div class="content">
    	<div class="section group">
			<div class="cont-desc span_1_of_2">	

				   <?php
				    $getPd = $pd->getSingleProduct($id);          
                    if($getPd){
                       while($result =$getPd->fetch_assoc()){   				            
                   ?>

					<div class="grid images_3_of_2">
						<img src="admin/<?php echo $result['image'];?>" alt="" />
					</div>
				<div class="desc span_3_of_2">
					<h2> <?php echo $result['productName']; ?> </h2>
					<div class="price">
						<p>Price: <span>$<?php echo $result['price']; ?> </span></p>
						<p>Category: <span><?php echo $result['catName']; ?></span></p>
						<p>Brand:<span><?php echo $result['brandName']; ?></span></p>
					</div>
				<div class="add-cart">
					<form action="" method="post">
						<input type="number" class="buyfield" name="quantity" value="1"/>
						<input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
					</form>				
				</div>

				<span style="color:red; font-size: 18px">
				  <?php
				    // for show messege if product already added 
					if(isset($addCart))
					{
						echo $addCart;
					}
                  ?>
                </span>		

				  <?php
				    // for show messege if product already added 
					if(isset($insertCom))
					{
						echo $insertCom;					
					}
				    // for show messege if product already added 
					if(isset($insertwlist))
					{
						echo $insertwlist;
					}
                  ?>
		<?php 
		// jodi login kora thake tahole add to compare show korbe  . na hoi show korbe na.
	        $login = session::get("cuslogin");        // take from classes->customer.php line 90
	        if($login == true){  ?>				
																		    
				<div class="add-cart">
				<div class="mybutton">

					<form action="" method="post">
					    <input type="hidden" class="buyfield" name="productId" value="<?php echo $result['productId']; ?>"/>
						<input type="submit" class="buysubmit" name="compare" value=" add to compare "/>
					</form>	
				</div>
				<div class="mybutton">

					<form action="" method="post">
					    <input type="hidden" class="buyfield" name="productId" value="<?php echo $result['productId']; ?>"/>
						<input type="submit" class="buysubmit" name="wlist" value=" Save to list "/>
					</form>	
				</div>
				
				</div>

		<?php } ?>


				
			</div>
			<div class="product-desc">
			<h2>Product Details</h2>
			<p> <?php echo $fm->textShorten($result['body'], 100); ?> </p>

		</div>
		
	   <?php } } ?>

	</div>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>

					<?php 
					// get all category
					   $getCat = $cat->getAllCat(); // call to category.php line 45
					   if($getCat){
						while($result = $getCat->fetch_assoc()){
                    ?>

				      <li><a href="productbycat.php?catid=<?php echo $result['catId']; ?>">
					        <?php echo $result['catName']; ?></a></li>

					<?php } } ?>

    				</ul>
    	
        </div>
 	</div>
</div>

<?php include 'inc/footer.php';  ?>
