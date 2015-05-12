<?php 
include_once("phpIncludes/check_login_status.php");
if (isset($_POST['action']) && $_POST['action'] == "search_product"){
	if(!isset($_POST['query']) || $_POST['query'] == ""){
		mysqli_close($dbConx);
		echo 3;
		exit();
	}

        $_SESSION['query'] = $_POST['query'];
		mysqli_close($dbConx);
	    echo 4;
		exit();
	
}
?>
<?php
$query = $_SESSION['query'];

$sql = "SELECT * FROM products WHERE productname LIKE '%$query%'";
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
	

$savebutton = '<label onmousedown="toLogin();" title="Save This Product"><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label>';
	
	if($user_ok == true){
$savebutton = '<label onmousedown="saveProduct('.$productid.');" title="Save This Product"><img src="images/save.png" width="15" height="15" alt="saves"> '.$saves.' saves</label>';
}

$productlink =  '<div id="productName"><label text-decoration:none;" onmousedown="productPage(\''.$productid.'\',\''.$product.'\');"  title="View This Product">'.$product.'</label></div>';
	
	$productlist .= '<td><h3>'.$productlink.'</h3><div id="productImage"><img src="products/'.$product.'/'.$image.'" width="280" height="265" alt="'.$product.'"></div><div id="descriptionBox"><p>'.$description.'</p></div><div id="button"><a href="http://'.$link.'"><img src="images/buybutton.png" width="118" height="41" alt="Buy It"></a></div><div id="price"><b>$'.$price.'</b></div><br/><div id="saves">'.$savebutton.'</div></td>';
	
	if ($rep % 3 == 0)
	{
		$productlist.="</tr><tr>";
	}
	$rep++;

}

if ($product == "")
{
	$productlist = "<div style='margin-left:50px; margin-top:50px; color:#14ABCC'><b>Sorry, there is no \"stuff\" that match the search criteria...</b></div>";
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Stuff I Would Buy</title>
  <link rel="icon" href="images/favicon.png" type="imgage/png">
  <link rel="stylesheet" href="style/style.css" type="text/css">
  <script src="js/main.js"></script>
  <script src="js/ajax.js"></script>
  <script>
  function saveProduct(productid){
	
	var ajax = ajaxObj("POST", "saveProduct.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == 2){
				alert("The Product Was Added To Your Wishlist");
			} else {
				alert("error: not added");
			}
		}
	}
	ajax.send("action=save_product&productid="+productid);
}

function productPage(productid,product){
	
	var ajax = ajaxObj("POST", "product.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == 4){
				location.href = 'product.php?='+product;
			} else {
				alert("Error");
			}
		}
	}
	ajax.send("action=display_product&productid="+productid);
}

</script>
</head>
<body>
<?php include_once("pageTop.php") ?>
<div id="wrapper">
 <div id="adTop">
  <h2>ADVERTISMENT</h2>
  </div>
  <div id="category">
  Search Results: 
  </div>
 <div id="shadow">
  <div id="pageMiddle" style="border-top:solid 1px #CCC;
	  border-bottom:solid 1px #CCC;">
  <div id="mainContent">
  <table width="1000"  border="0">
  <tr><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td><td><div style="width:285px"></div></td></tr>
   <?php echo $productlist?>
</table>
  </div>
  </div>
</div>
<?php include_once("pageBottom.php") ?>
</div>
</body>
</html>
