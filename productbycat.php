<?php include 'inc/header.php'; ?>

<?php
    // catch id from catlist file, fome line number 50
    if(!isset($_GET['catid']) || $_GET['catid'] == NULL ){
        echo "<scriipt> window.location = '404.php' </script>";
    }
    else{
        $id = $_GET['catid'];    
        //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['catid']);
    }
?>

<div class="main">
    <div class="content">
        <div class="content_top">
            <div class="heading">
                <h3>Latest from category</h3>
            </div>
            <div class="clear"></div>
        </div>
        <div class="section group">

            <?php 
				// get all product by category
				$productbycat = $pd->productByCategory($id); // call to product.php line 302
					if($productbycat){
						while($result = $productbycat->fetch_assoc()){
            ?>

            <div class="grid_1_of_4 images_1_of_4">
                <a href="details.php?proid=<?php echo $result['productId'];?>"> <img src="admin/<?php echo $result['image'];?>" alt="" /></a>
                <h2> <?php echo $result['productName'];?> </h2>
                <p> <?php echo $fm->textShorten($result['body'], 60); ?> </p>
                <p> <span class="price">$ <?php echo $result['price'];?> </span> </p>
                <div class="button"><span><a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Details</a></span></div>
            </div>

            <?php } } 
				else{
					header("location:404.php");
					//echo "<h2> products are not available of this category </h2>";
				}

				?>
        </div>

    </div>
</div>
</div>

<?php include 'inc/footer.php';  ?>