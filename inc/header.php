
<?php 
include 'lib/session.php'; 
session::init();               // get for session id
include 'lib/Database.php'; 
include 'helpers/format.php'; 

spl_autoload_register(function($class){
	include_once "classes/".$class.".php";
});

$db = new Database();
$fm = new Format();
$pd = new product();
$cat = new category();
$ct = new cart();
$cmr = new customer();
?>

<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
  
?>

<!DOCTYPE HTML>
<head>
<title>Store Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
<script src="js/jquerymain.js"></script>
<script src="js/script.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
<script type="text/javascript" src="js/nav.js"></script>
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script> 
<script type="text/javascript" src="js/nav-hover.js"></script>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
<script type="text/javascript">
  $(document).ready(function($){
    $('#dc_mega-menu-orange').dcMegaMenu({rowItems:'4',speed:'fast',effect:'fade'});
  });
</script>
</head>

  <div class="wrap">
		<div class="header_top">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png" alt="" /></a>
			</div>
			  <div class="header_top_right">
			    <div class="search_box">
				    <form>
				    	<input type="text" value="Search for Products" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search for Products';}"><input type="submit" value="SEARCH">
				    </form>
			    </div>
			    <div class="shopping_cart">
					<div class="cart">
						<a href="#" title="View my shopping cart" rel="nofollow">
								<span class="cart_title">Cart</span>
								<span class="no_product">

				<!-- uporer cart a total amount and quantity show korar jonno -->
								<?php
								  $getData = $ct->checkCartTable();  // call to cart.php line 107
								  if($getData){							
								  $sum = session::get("sum" );    // connect to cart.php line 92
								  $qty = session::get("qty" );   
								  echo "$ ".$sum." | Qty: ".$qty;
								  }
								  else{
									  echo "(empty)";
								  }
                                ?>


								</span>
							</a>
						</div>
			      </div>

	<?php 
	    // for logout
		if(isset($_GET['cid'])){                           // cid take from this file line 103
			
			$cmrid = session::get("cmrId");              // take from classes->customer.php line 90
			$delData = $ct->delCustomerCart();             // call to classes->cart.php line 119
			$delCompare = $pd->delCompareData($cmrid);           // call to classes->product.php line 372
			session::destroy();                            // call to lib->session.php line 46
		}
	?>

		   <div class="login">
		        <?php
				    // jokhon login kora thakbe tokhon r login show korbe na.tokhon logout show korbe
                    $login = session::get("cuslogin");
                    if($login == false){  ?>
	                    <a href="login.php">Login</a>
                        <?php } else{  ?>
	   		            <a href="?cid=<?php echo session::get("cmrId")?>">Logout</a>
                <?php } ?>		   
		    </div>
		 <div class="clear"></div>
	 </div>
	 <div class="clear"></div>
</div>

<div class="menu">
	<ul id="dc_mega-menu-orange" class="dc_mm-orange">
	    <li><a href="index.php">Home</a></li>
	    <li><a href="topbrands.php">Top Brands</a></li>

	    <!-- jodi cart a kono data na thake tahole cart option show korbe na -->
		<!-- r jodi cart a data thake tahole cart option show korbe -->
		<?php
	        $chkCart = $ct->checkCartTable();          // call to classes->cart.php line 109
	        if($chkCart){  ?>

		        <li><a href="cart.php">Cart</a></li>
		        <li><a href="payment.php">Payment</a></li>
	    <?php } ?>

	    <!-- order page a kono data na thakle tahole menu bar a order option show korbe na -->
	    <!-- r jodi order page a  data  thake tahole menu bar a order option show korbe-->
	    <?php
	        $cmrid = session::get("cmrId");        // take from classes->customer.php line 90
	        $chkOrder = $ct->checkOrder($cmrid);           // call to classes->cart.php line 164
	        if($chkOrder){  ?>
		        <li><a href="orderdetails.php">Order</a></li>
	    <?php } ?>

        <!-- jodi login kora thake tahole profile show korbe..na hoi korbe na -->
        <?php 
	        $login = session::get("cuslogin");        // take from classes->customer.php line 90
	        if($login == true){  ?>
		        <li><a href="profile.php">Profile</a> </li>
	    <?php } ?>

		<?php
            $cmrid = session::get("cmrId");              // take from classes->customer.php line 90
			$getpd = $pd->getCompareDate($cmrid);       // call to classes->product.php line 360
			if($getpd){
		?>
	    <li><a href="compare.php">Compare</a> </li>
		<?php }  ?>

		<?php
            $cmrid = session::get("cmrId");              // take from classes->customer.php line 90
			$getpd = $pd->getWlistDate($cmrid);       // call to classes->product.php line 360
			if($getpd){
		?>
		<li><a href="list.php">wishList</a> </li>
		
		<?php }  ?>


	    <li><a href="contact.php">Contact</a> </li>
	    <div class="clear"></div>
	</ul>
</div>
