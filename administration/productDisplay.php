<?php include_once("../phpIncludes/check_login_status.php");

$sql = "SELECT * FROM products WHERE approved=0 ORDER BY id DESC";

$query = mysqli_query($dbConx, $sql);
$productlist="<tr>";
$rep=1; 

while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
	$product = $row["productname"];
	$image = $row["image"];
	$link = $row["link"];
	$description = $row["description"];
	$saves = $row["saves"];
	$price = number_format($row["price"], 2);
	$productid = $row["id"];
	$urlname = $row["urlname"];
	
$approve = '<label onmousedown="approve('.$productid.');">approve</label>';
	

$productlink =  '<div id="productName"><label text-decoration:none;">'.$product.'</label></div>';

$deletebutton = '<a href="#"  onmousedown="deleteProduct('.$productid.',\''.$image.'\');" title="DELETE THIS PRODUCT"><div id="delete">X</div></a>';
	
	$productlist .= '<td><h3>'.$productlink.$deletebutton.'</h3><div id="productImage"><img src="../products/'.$image.'" width="280" height="265" alt="'.$product.'"></div><div id="descriptionBox"><p>'.$description.'</p></div><div id="button"><a href="http://'.$link.'"><img src="../images/buybutton.png" width="118" height="41" alt="Buy It"></a></div><div id="price"><b>$'.$price.'</b></div><br/><div id="saves">'.$approve.'</div></td>';
	
	if ($rep % 3 == 0)
	{
		$productlist.="</tr><tr>";
	}
	$rep++;

}

?>
<?php 
include_once("../phpIncludes/check_login_status.php");
if (isset($_POST['action']) && $_POST['action'] == "approve_product"){
	if(!isset($_POST['productid']) || $_POST['productid'] == ""){
		mysqli_close($dbConx);
		echo 1;
		exit();
	}
	$productid = preg_replace('#[^0-9]#', '', $_POST['productid']);
	mysqli_query($dbConx,"UPDATE products SET approved=1 WHERE id='$productid'");
	
		mysqli_close($dbConx);
	    echo "approved";
		exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Stuff I Would Buy</title>
  <link rel="icon" href="../images/favicon.png" type="image/png">
  <link rel="stylesheet" href="../style/style.css" type="text/css">
  <script src="../js/main.js"></script>
  <script src="../js/ajax.js"></script>
  <script>
   function approve(productid){
	var conf = confirm("Press OK to approve the product");
	if(conf != true){
		return false;
	}
	var ajax = ajaxObj("POST", "productDisplay.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "approved"){
				alert("the product was approved");
			} else {
				alert("error: not approved");
			}
		}
	}
	ajax.send("action=approve_product&productid="+productid);
}

function deleteProduct(productid,image){
	 var conf = confirm("Press OK to delete the product permanetly");
	if(conf != true){
		return false;
	}
	
	var ajax = ajaxObj("POST", "../permanentDelete.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "delete"){
				window.location = "productDisplay.php";
			} else {
				alert("error: item not deleted");
			}
		}
	}
	ajax.send("action=delete&productid="+productid+"&image="+image);
}
  </script>

</head>
<body>
<div id="wrapper">
 <div id="shadow">
  <div id="pageMiddle" style="border-top:solid 1px #CCC;
	  border-bottom:solid 1px #CCC;">
  <div id="mainContent">
  <table width="1000"  border="0">
  <tr><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td></tr>
   <?php echo $productlist?>
</table>
<div><a href="../index.php">Go To Index</a></div>
  </div>
  </div>
</div>
<?php include_once("../pageBottom.php") ?>
</div>
</body>
</html>






