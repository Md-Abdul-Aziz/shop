<?php include 'inc/header.php'; ?>

<?php
    // jodi login kora na thake tahole login page a nea jabe
    $login = session::get("cuslogin");       // take from classes->customer.php line 90
    if($login == false){
	    header("location:login.php");
    }
?>

<style>
    .tblone {
        width: 550px;
        margin: 0 auto;
        border: 2px solid #ddd;
    }
    .tblone tr td {
        text-align: justify;
    }
</style>

<div class="main">
    <div class="content">
        <div class="section group">

            <?php
                $id = session::get("cmrId");          // connect to classes->customer.php line 91
                $getdata = $cmr->getCustomerData($id);   // call to classes->customer.php line 102
                if($getdata){
                    while($result = $getdata->fetch_assoc()){
            ?>

            <table class="tblone">
                <tr>
                    <td colspan="3">
                        <h2>Your profile details</h2>
                    </td>
                </tr>
                <tr>
                    <td width="20%">name</td>
                    <td width="5%">:</td>
                    <td> <?php echo $result['name']; ?> </td>
                </tr>
                <tr>
                    <td>phone</td>
                    <td>:</td>
                    <td> <?php echo $result['phone']; ?> </td>
                </tr>
                <tr>
                    <td>email</td>
                    <td>:</td>
                    <td> <?php echo $result['email']; ?> </td>
                </tr>
                <tr>
                    <td>address</td>
                    <td>:</td>
                    <td> <?php echo $result['address']; ?> </td>
                </tr>
                <tr>
                    <td>city</td>
                    <td>:</td>
                    <td> <?php echo $result['city']; ?> </td>
                </tr>
                <tr>
                    <td>zip-code</td>
                    <td>:</td>
                    <td> <?php echo $result['zip']; ?> </td>
                </tr>
                <tr>
                    <td>country</td>
                    <td>:</td>
                    <td> <?php echo $result['country']; ?> </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td> <a href="editprofile.php">Update Details </a> </td>
                </tr>
            </table>

            <?php } } ?>

        </div>
    </div>
</div>

<?php include 'inc/footer.php';  ?>