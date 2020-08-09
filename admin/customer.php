<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../classes/customer.php'); 
?>
<?php
$cus = new customer();

// catch custId from inbox.php line 43
if(!isset($_GET['custId']) || $_GET['custId'] == NULL ){
    echo "<script> window.location = 'inbox.php'; </script>";
}
else{
      $id = $_GET['custId'];    
      //$id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['catid']);
}

// jokhon ok click korbe tokhon inbox page a nea jabe
if( $_SERVER['REQUEST_METHOD'] == 'POST'){
    
    echo "<script> window.location = 'inbox.php'; </script>";

}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Customer Information</h2>
        <div class="block copyblock"> 

            <?php
                // To taken all data from the database
                $cusInfo = $cus->getCustomerData($id);       // call to classes->customer.php line 101
                if($cusInfo){
                    while($result =$cusInfo->fetch_assoc()){             
            ?>

            <form action="" method ="post">
                <table class="form">

                        <tr>
                            <td> Name </td>
                            <td> 
                                <input type="text"  readonly="readonly" value ="<?php echo $result['name']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td> address </td>
                            <td> 
                                <input type="text"  readonly="readonly" value ="<?php echo $result['address']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td> city </td>
                            <td> 
                                <input type="text"  readonly="readonly" value ="<?php echo $result['city']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td> country </td>
                            <td> 
                                <input type="text"  readonly="readonly" value ="<?php echo $result['country']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td> zip </td>
                            <td> 
                                <input type="text"  readonly="readonly" value ="<?php echo $result['zip']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td> phone </td>
                            <td> 
                                <input type="text"  readonly="readonly" value ="<?php echo $result['phone']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td> email </td>
                            <td> 
                                <input type="text"  readonly="readonly" value ="<?php echo $result['email']; ?>" class="medium" />
                            </td>
                        </tr>
                        <tr> 
                            <td>
                                <input type="submit" name="submit" Value="OK" />
                            </td>
                        </tr>

                    </table>
                </form>

                    <?php } } ?> 


                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>