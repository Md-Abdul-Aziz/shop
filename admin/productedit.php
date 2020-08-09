<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/product.php';
include '../classes/category.php';
include '../classes/brand.php';
?>

<?php

$pd = new product();

// catch id from admin->productlist.php, fome line number 60
if(!isset($_GET['productid']) || $_GET['productid'] == NULL ){
    echo "<scriipt> window.location = 'productlist.php' </script>";
}
else{
      $id = $_GET['productid'];    
      //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['catid']);
}

// add category
if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){

    $updateProduct = $pd->productUpdate($_POST, $_FILES, $id);  // call to lib->category.php line number 17
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Edit New Product</h2>
        <div class="block"> 

            <?php
            // for show messege
               if(isset($updateProduct))
               {
                   echo $updateProduct;
               }
           ?>

           <?php
             // To taken all data from the database
             $getProduct = $pd->getProductById($id);             // call to category file line number 56
             if($getProduct){
                while($value =$getProduct->fetch_assoc()){             
            ?>

         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td>
                        <input type="text" name = "productName" value ="<?php echo $value['productName']; ?>" class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Category</label>
                    </td>
                    <td>
                        <select id="select" name="catId" >
                            <!--<option>Select Category</option> -->
                            <option>Select Category</option> 

                            <?php 
                            $cat = new category();
                            $getCat = $cat->getAllCat();
                            if($getCat){
                                while($result = $getCat->fetch_assoc()){
                            ?>

                            <option 
                            <?php
                            //edit a click korle product page theke category ta update product page a nea jawar jonno
                            if($value['catId'] == $result['catId']){ ?>
                                selected = "selected"
                            <?php } ?>
                       
                             value="<?php echo $result['catId'];?>"><?php echo $result['catName'];?> 
                             </option>

                             <?php } } ?>

                        </select>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Brand</label>
                    </td>
                    <td>
                        <select id="select" name="brandId">
                            <option>Select Brand</option>

                           <?php 
                              $brand = new brand();
                              $getBrand = $brand->getAllBrand();
                              if($getBrand){
                              while($result = $getBrand->fetch_assoc()){
                            ?>

                            <option
                            <?php
                   //edit a click korle product page theke brand ta update product page a nea jawar jonno    
                            if($value['brandId'] == $result['brandId']){ ?>
                                selected = "selected";
                            <?php } ?>
                                                   
                        value="<?php echo $result['brandId'];?>"><?php echo $result['brandName'];?> 
                        </option>

                        <?php } } ?>

                        </select>
                    </td>
                </tr>
				
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Description</label>
                    </td>
                    <td>
                        <textarea class="tinymce" name = "body">
                        <?php echo $value['body']; ?>
                        </textarea>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Price</label>
                    </td>
                    <td>
                        <input type="text" name = "price" value ="<?php echo $value['price']; ?>"  class="medium" />
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
        <!-- edit a click korle product page theke brand ta update product page a nea jawar jonno -->    
                     <img src="<?php echo $value['image']; ?>" height="80px" width="200px"/><br/>
                        <input type="file" name = "image" />
                    </td>
                </tr>
				
				<tr>
                    <td>
                        <label>Product Type</label>
                    </td>
                    <td>
                        <select id="select" name="type">
                            <option>Select Type</option>
         <!--edit a click korle product page theke brand ta update product page a nea jawar jonno -->    
                            <?php if($value['type'] == 1){ ?> 

                            <option selected = "selected" value="1">Featured</option>
                            <option value="2">General</option>

                            <?php } else{ ?>

                                <option selected = "selected" value="2">General</option>
                                <option value="1">Featured</option>

                            <?php } ?>

                        </select>
                    </td>
                </tr>

				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
  
            <?php } } ?> 

        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>


