<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>

<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/cart.php'); 
$ct = new cart();
$fm = new Format();
?>
<?php
if(isset($_GET['shiftId'])){

	$cmrid =  $_GET['shiftId'];
	$date  =  $_GET['date'];
	$price =  $_GET['price'];
	$shift =  $ct->productShiftes($cmrid, $date, $price);
}
if(isset($_GET['delId'])){

	$cmrid =  $_GET['delId'];
	$date  =  $_GET['date'];
	$price =  $_GET['price'];
	$delOrder =  $ct->delproductShiftes($cmrid, $date, $price);
}


?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Inbox</h2>

		<?php
			// show messege when quantity update 
			if(isset($shift)){
			    echo $shift;
			}
		
			// show messege when quantity update 
			if(isset($delOrder)){
			    echo $delOrder;
			}												
														
		?>

        <div class="block">        
            <table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>OrderID</th>
						<th>Order time</th>
						<th>ProductName</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>CustomerID</th>
						<th>Address</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				    <?php
                        // call to classes->cart.php line 175
						$getOrder = $ct->getAllOrderProduct();
						if($getOrder){
							while($result = $getOrder->fetch_assoc()){
                    ?>

					<tr class="odd gradeX">
					    <td><?php echo $result['id']; ?></td>
						<td><?php echo $fm->formatDate($result['date']); ?></td>
						<td><?php echo $result['productName']; ?></td>
						<td><?php echo $result['quantity']; ?></td>
						<td>$<?php echo $result['price']; ?></td>
						<td><?php echo $result['cmrId']; ?></td>
						<td><a href="customer.php?custId=<?php echo $result['cmrId'];?>">View details</a></td>

						<?php if($result['status'] == '0'){ ?>
                            <td>
								<a href="?shiftId=<?php echo $result['cmrId']; ?> & 
								price=<?php echo $result['price']; ?> & 
								date=<?php echo $result['date']; ?>">Shifted</a>
							</td>	
						<?php } elseif( $result['status'] == '1'){ ?>	
						 <td> Pending </td>						 
                        <?php } else{ ?>
                            <td>
								<a href="?delId=<?php echo $result['cmrId']; ?> &
								price=<?php echo $result['price']; ?> & 
								date=<?php echo $result['date']; ?>">Remove</a>
							</td>
                        <?php } ?>
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
