<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/brand.php';

$brand = new brand();

// for delete brand
if(isset($_GET['delbrand'])){
  $id = $_GET['delbrand'];
  //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['delcat']);
  $delBrand = $brand->delBrandById($id);   // call to category file line number 93

}
?>

    <div class="grid_10">
        <div class="box round first grid">
                <h2>Category List</h2>
            <div class="block">     
     	         
			<?php
               // for show messege
               if(isset($delBrand))
               {
                   echo $delBrand;
               }
            ?>

                <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

                      
					   <?php
					       // To taken all data from the database
						   $getBrand = $brand->getAllBrand();   // call to classes->brand.php file line number 46
						   if($getBrand){
							   $i = 0;
							   while($result = $getBrand->fetch_assoc()){
								   $i++;				   
                        ?>

						<tr class="odd gradeX">
							<td> <?php echo $i ; ?> </td>
							<td> <?php echo $result['brandName']; ?>  </td>
							<td><a href="brandedit.php?brandid=<?php echo $result['brandId'];?>">Edit</a>
							 || <a onclick="return confirm('are you sure to delete! ')" href="?delbrand=<?php echo $result['brandId'];?>"> Delete </a></td>
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

