<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/brand.php';

$brand = new brand();

// catch id from catlist file, fome line number 50
if(!isset($_GET['brandid']) || $_GET['brandid'] == NULL ){
    echo "<script> window.location = 'brandlist.php' </script>";
}
else{
      $id = $_GET['brandid'];    
      //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['catid']);
}

// catch name that is given, from this file, from line number 50
if( $_SERVER['REQUEST_METHOD'] == 'POST'){

	$brandName = $_POST['brandName'];
	$updateBrand = $brand->brandUpdate($brandName, $id);    // call to category file line number 65
}
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Update brand</h2>
               <div class="block copyblock"> 

            <?php
                // for show messege
               if(isset($updateBrand))
               {
                   echo $updateBrand;
               }
            ?>

            <?php
             // To taken all data from the database
             $getBrand = $brand->getBrandById($id);             // call to category file line number 56
             if($getBrand){
                while($result =$getBrand->fetch_assoc()){             

            ?>

                 <form action="" method ="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text"  name="brandName" value ="<?php echo $result['brandName']; ?>" class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>

                <?php } } ?> 


                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>