<?php 
include_once("phpIncludes/check_login_status.php");
if (isset($_POST['action']) && $_POST['action'] == "delete"){
	if(!isset($_POST['productid']) || $_POST['productid'] == ""){
		mysqli_close($dbConx);
		echo 1;
		exit();
	}
	$productid = preg_replace('#[^0-9]#', '', $_POST['productid']);
	$uid = mysqli_insert_id($dbConx);
	mysqli_query($dbConx, "DELETE FROM saves
WHERE username='$log_username' AND productid=$productid");
		mysqli_close($dbConx);
	    echo $log_username;
		exit();
	
}
?>
