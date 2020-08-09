<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/product.php';
include_once '../helpers/format.php'; 

$pd = new product();
$fm = new Format();

// for delete product
if(isset($_GET['delproduct'])){
  $id = $_GET['delproduct'];
  //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['delcat']);
  $delProduct = $pd->delProductById($id);   // call to category file line number 93

}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Product List</h2>
        <div class="block">  


            <?php
               // for show messege
               if(isset($delProduct))
               {
                   echo $delProduct;
               }
            ?>


            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>SL</th>
					<th>Product name</th>
					<th>Category</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Price</th>
					<th>Image</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

			   <?php
				// To taken all data from the database
				$getProduct = $pd->getAllProduct();   // call to classes->brand.php file line number 46
				if($getProduct){
				  $i = 0;
				  while($result = $getProduct->fetch_assoc()){
						$i++;				   
              ?>

				<tr class="odd gradeX">
				    <td> <?php echo $i ; ?> </td>
					<td> <?php echo $result['productName']; ?> </td>
					<td> <?php echo $result['catName']; ?>  </td>
					<td> <?php echo $result['brandName']; ?>  </td>
					<td> <?php echo $fm->textShorten($result['body'], 50); ?>  </td>
					<td> $<?php echo $result['price']; ?>  </td>
					<td> <img src="<?php echo $result['image']; ?>" height="40px" width="60px"/></td>
					<td> 
					  <?php
					   if($result['type'] == 1){
						   echo "Featured";
					    }  
					    else{
						echo "General";
					    }
					  ?>
					</td>
					<td><a href="productedit.php?productid=<?php echo $result['productId'];?>">Edit</a>
					 || <a onclick="return confirm('are you sure to delete! ')" href="?delproduct=<?php echo $result['productId'];?>"> Delete </a>
					</td>
				</tr>

				<?php } } ?>

			
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
