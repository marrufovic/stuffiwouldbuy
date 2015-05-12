<?php 
include_once("phpIncludes/check_login_status.php");
if (isset($_POST['action']) && $_POST['action'] == "save_product"){
	if(!isset($_POST['productid']) || $_POST['productid'] == ""){
		mysqli_close($dbConx);
		echo 1;
		exit();
	}
	$productid = preg_replace('#[^0-9]#', '', $_POST['productid']);
	mysqli_query($dbConx, "INSERT INTO saves (username, productid) 
	VALUES ('$log_username', '$productid')");
	
	mysqli_query($dbConx,"UPDATE products
SET saves=saves+1 WHERE id='$productid'");
	
		mysqli_close($dbConx);
	    echo 2;
		exit();
}
?>
