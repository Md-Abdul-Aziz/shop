<!-- this file connect to cart.php line 154 -->
<?php include 'inc/header.php'; ?>
<?php
// jodi login kora na thake tahole login page a nea jabe
   $login = session::get("cuslogin");       // take from classes->customer.php line 90
   if($login == false){
	   header("location:login.php");
    }
?>
<style>
.payment{ width: 500px; min-height: 200px; text-align: center; margin: 0 auto; border: 1px solid #ddd; padding: 50px;}
.payment h2{ border-bottom: 1px solid #ddd; margin-bottom: 40px; padding-bottom: 10px; }
.payment a{background:#ff0000 none repeat scroll 0 0; border-radius: 3px; color: green; font-size: 25px; padding: 5px 30px;}
.back a{ width: 160px; text-align: center; margin: 5px auto 0; padding-bottom: 4px; display:block; background : #555; border: 1px solid #333; color: white; border-radius: 3px; font-size: 25px;}
</style>

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="payment">
                <h2> Choose payment option </h2>
                <a href="paymentoffline.php"> Offline payment </a>
                <a href="paymentonline.php"> Online payment </a>
            </div>
            <div class="back">
                <a href = "cart.php">Previous </a>
            </div>
        </div>
 	</div>
</div>

<?php include 'inc/footer.php';  ?>
