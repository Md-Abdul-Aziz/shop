<?php include 'inc/header.php'; ?>

<?php
   // jodi login kora na thake tahole login page a nea jabe
   $login = session::get("cuslogin");       // take from classes->customer.php line 90
   if($login == false){
   header("location:login.php");
}
?>

<?php
if(isset($_GET['shiftId'])){

	$cmrid =  $_GET['shiftId'];
	$date  =  $_GET['date'];
	$price =  $_GET['price'];
	$confirm =  $ct->productConfirm($cmrid, $date, $price);
}
?>

<style>
   .tblone tr td{text-align: justify}
</style>


<div class="main">
   <div class="content">
      <div class="section group"> 
         <div class="order">
            <h2> Your Order details </h2>
            <table class="tblone">
               <tr>
                  <th>No</th>
                  <th>Product Name</th>
                  <th>Image</th>
                  <th>Quantity</th>
                  <th>Total Price</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
               </tr>

               <?php
                  $cmrid  = session::get("cmrId");            // take from classes->customer.php line 90
                  $getOrder = $ct->getOrderProduct($cmrid);      // call to classes->cart.php line 58

                  if($getOrder){
                     $i = 0;
                     while($result = $getOrder->fetch_assoc()){
                        $i++;		
               ?>

               <tr>
                  <td> <?php echo $i ; ?> </td>
                  <td><?php echo $result['productName']; ?></td>
                  <td><img src="admin/<?php echo $result['image'];?>" alt=""/></td>
                  <td><?php echo $result['quantity']; ?>  </td>				            
                  <td>$<?php echo $result['price']; ?> </td>
                  <td><?php echo $fm->formatDate($result['date']); ?></td>
                  <td>
                     <?php 
                        if($result['status'] == '0'){
                           echo "Pending";
                        }
                        elseif($result['status'] == '1'){ 
                           echo "Shifted";
                        } 
                        else{
                           echo "OK";
                        }
                     ?>
                  </td>

                  <?php if($result['status'] == '1'){  ?>

                     <a href="?shiftId=<?php echo $result['cmrId']; ?> & 
                     price=<?php echo $result['price']; ?> & 
                     date=<?php echo $result['date']; ?>">Confirm</a>

                  <?php } elseif($result['status'] == '2'){  ?>

                     <td> OK </td>

                  <?php } elseif($result['status'] == '0'){  ?>

                     <td> N/A </td>

                  <?php }  ?>
               </tr>			

               <?php } } ?>

            </table>                
         </div>
      </div>
      <div class="clear"></div>
   </div>
</div>
<?php include 'inc/footer.php';  ?>


