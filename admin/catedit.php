<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/category.php';

$cat = new category();

// catch id from catlist file, fome line number 50
if(!isset($_GET['catid']) || $_GET['catid'] == NULL ){
    echo "<scriipt> window.location = 'catlist.php' </script>";
}
else{
      $id = $_GET['catid'];    
      //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['catid']);
}

// catch name that is given, from this file, from line number 50
if( $_SERVER['REQUEST_METHOD'] == 'POST'){

	$catName = $_POST['catName'];
	$updateCat = $cat->catUpdate($catName, $id);    // call to category file line number 65


}
?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Update Category</h2>
               <div class="block copyblock"> 

            <?php
                // for show messege
               if(isset($updateCat))
               {
                   echo $updateCat;
               }
            ?>

            <?php
             // To taken all data from the database
             $getCat = $cat->getCatById($id);  // call to category file line number 56
             if($getCat){
                while($result =$getCat->fetch_assoc()){             

            ?>

                 <form action="" method ="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text"  name="catName" value ="<?php echo $result['catName']; ?>" class="medium" />
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