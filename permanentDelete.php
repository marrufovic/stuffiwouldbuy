<?php 
include_once("phpIncludes/check_login_status.php");
if (isset($_POST['action']) && $_POST['action'] == "delete"){
	if(!isset($_POST['productid']) || $_POST['productid'] == ""){
		mysqli_close($dbConx);
		echo 1;
		exit();
	}
	
	$productid = preg_replace('#[^0-9]#', '', $_POST['productid']);
	$image = $_POST['image'];
	mysqli_query($dbConx, "DELETE FROM products WHERE id=$productid");
    $picurl = "products/$image"; 
   	if (file_exists($picurl)) {
	unlink($picurl);
   }
   mysqli_close($dbConx);
		
	    echo "delete";
		exit();
	
}
?>
