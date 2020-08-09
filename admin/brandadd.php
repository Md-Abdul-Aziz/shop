<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/brand.php';

$brand = new brand();

// add brand
if( $_SERVER['REQUEST_METHOD'] == 'POST'){

	$brandName = $_POST['brandName'];                   // catch brand name from this file from line number 34
	$insertBrand = $brand->brandInsert($brandName);     // call to classes->brand.php line number 17

}
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Add New Brand</h2>
               <div class="block copyblock"> 

            <?php
            // for show messege
               if(isset($insertBrand))
               {
                   echo $insertBrand;
               }
            ?>

                 <form action="" method ="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text"  name="brandName"    placeholder="Enter brand Name..." class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>