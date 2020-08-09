<!-- this file connect to cart.php line 154 -->

<?php include 'inc/header.php'; ?>

<?php
    // jodi login kora na thake tahole login page a nea jabe
    $login = session::get("cuslogin");             // take from classes->customer.php line 90
    if($login == false){
	    header("location:login.php");
    }
?>

<style>
    .psuccess {
        width: 500px;
        min-height: 200px;
        text-align: center;
        margin: 0 auto;
        border: 1px solid #ddd;
        padding: 20px;
    }     
    .psuccess h2 {
        border-bottom: 1px solid #ddd;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    .psuccess p {
        font-size: 18px;
        text-align: left;
        line-height: 25px;
    }
</style>

<div class="main">
    <div class="content">
        <div class="section group">
            <div class="psuccess">
                <h2> Success </h2>

                <?php
                    $cmrid  = session::get("cmrId");             // take from classes->customer.php line 90
                    $amount = $ct->payableAmount($cmrid);
                    if($amount){
                        $sum = 0;
                        while($result = $amount->fetch_assoc()){
                            $price = $result['price'];
                            $sum   = $sum + $price;
                        }
                    }
                ?>

                <p style="color: red"> Total payable amount (Including vat) : $

                    <?php 
                        $vat   = $sum * 0.1;
                        $total = $sum + $vat;
                        echo $total; 
                    ?>

                </p>
                <p>
                    Thank you for purchas. Reasive your order successfully. We will contact you. here your order details....<a href="orderdetails.php">Visit here </a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php';  ?>